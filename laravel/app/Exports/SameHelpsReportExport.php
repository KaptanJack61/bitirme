<?php

namespace App\Exports;

use App\Models\Help;
use Carbon\Carbon;
use Helpers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Session;

class SameHelpsReportExport implements FromQuery, WithMapping, WithHeadings
{

    public function query()
    {

        /*dd([
            "İşlem" => "Aynı yardımı birden fazla alanlar",
            "first date" => Session::get('first_date'),
            "last date" => Session::get('last_date'),
            "aynı yardım durumu" => Session::get('samehelp'),
            "mahalleler" => Session::get('neighborhood'),
            "yardım türleri" => Session::get('helptypes'),
            "durumlar" => Session::get('status')
        ]);*/

        $neighborhoods = Session::get('neighborhood');
        $helptypes = Session::get('helptypes');
        $status = Session::get('status');
        $first_date = Session::get('first_date');
        $last_date = Session::get('last_date');

        $data = Help::query();
        $data->join('help_types','help_types.id','helps.help_types_id');
        $data->join('statuses','helps.status_id','statuses.id');
        $data->join('demand_help','demand_help.help_id','helps.id');
        $data->join('demands','demands.id','demand_help.demand_id');
        $data->join('people','people.id','demands.person_id');
        $data->join('neighborhoods','neighborhoods.id','people.neighborhood_id');

        $data->selectRaw('people.first_name, people.last_name, people.phone, 
            neighborhoods.name as neighborhood,helps.help_types_id, COUNT(people.person_slug) as toplam, help_types.name as type'

        );
        //$data->select('helps.*','COUNT(helps.person_slug) as toplam');

        if ($status != "all") {
            $data->join('statuses','helps.status_id','=','statuses.id');
            if ($status == "open"){
                $data->where('statuses.finisher', '=', 0);

            }elseif ($status == "closed"){
                $data->where('statuses.finisher', '=', 1);

            }else{
                $data->whereIn('statuses.id', $status);
            }
        }

        if ($helptypes != "all"){
            $data->whereIn('helps.help_types_id',$helptypes);

        }

        if ($neighborhoods != "all") {
            $data->whereIn('people.neighborhood_id',$neighborhoods);

        }

        if ($first_date != null){
            if ($last_date == null){
                $data->where('helps.created_at','>',Carbon::createFromFormat('d.m.Y H:i:s',$first_date." 00:00:00"));
            }else {
                $data->whereBetween('helps.created_at',[
                    Carbon::createFromFormat('d.m.Y H:i:s',$first_date." 00:00:00"),
                    Carbon::createFromFormat('d.m.Y H:i:s',$last_date." 23:59:59")
                ]);
            }

        }else {
            if ($last_date != null){
                $data->where('helps.created_at','<',Carbon::createFromFormat('d.m.Y H:i:s',$last_date." 23:59:59"));
            }

        }

        $data->groupBy(['helps.help_types_id','people.person_slug','people.phone']);
        $data->havingRaw('COUNT(people.person_slug) > 1');
        $data->orderByRaw('COUNT(helps.help_types_id) DESC');

        Session::forget('first_date');
        Session::forget('last_date');
        Session::forget('neighborhood');
        Session::forget('helptypes');
        Session::forget('status');

        return $data;
    }

    public function map($help): array
    {
        return [
            $help->first_name." ".$help->last_name,
            Helpers::phoneTextFormat($help->phone),
            $help->neighborhood,
            $help->type,
            $help->toplam,
        ];
    }

    public function headings(): array
    {
        return [
            'Ad Soyad',
            'Telefon',
            'Mahalle',
            'Yardım Türü',
            'Toplam',
        ];
    }
}
