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

class SameOneHelpsReportExport implements FromQuery, WithMapping, WithHeadings
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
        $data->selectRaw('helps.first_name, helps.last_name, helps.phone, helps.neighborhood_id, COUNT(helps.person_slug) as toplam');
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
            $data->whereIn('help_types_id',$helptypes);

        }

        if ($neighborhoods != "all") {
            $data->whereIn('neighborhood_id',$neighborhoods);

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

        $data->groupBy(['helps.person_slug','helps.phone']);
        $data->havingRaw('COUNT(helps.person_slug) > 1');
        $data->orderByRaw('COUNT(helps.person_slug) DESC');

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
            $help->neighborhood->name,
            $help->toplam,
        ];
    }

    public function headings(): array
    {
        return [
            'Ad Soyad',
            'Telefon',
            'Mahalle',
            'Toplam',
        ];
    }
}
