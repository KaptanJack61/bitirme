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

class HelpsReportExport implements FromQuery, WithMapping, WithHeadings
{

    public function query()
    {
        $neighborhoods = Session::get('neighborhood');
        $helptypes = Session::get('helptypes');
        $status = Session::get('status');
        $first_date = Session::get('first_date');
        $last_date = Session::get('last_date');

        $data = Help::query();
        $data->join('statuses','helps.status_id','=','statuses.id');
        $data->select('helps.*');

        if ($status != "all") {
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

        $data->orderBy('helps.neighborhood_id');
        $data->orderBy('helps.help_types_id');
        $data->orderBy('helps.created_at','desc');

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
            $help->id,
            $help->full_name,
            Helpers::phoneTextFormat($help->phone),
            $help->type->name,
            $help->quantity." ".$help->type->metrik,
            $help->neighborhood->name,
            $help->street." ".$help->city_name." No: ".$help->gate_no,
            $help->status->name,
            date('d M Y',strtotime($help->created_at)),
            date('d M Y',strtotime($help->updated_at)),
            $help->detail
        ];
    }

    public function headings(): array
    {
        return [
            'Yardım No',
            'Ad Soyad',
            'Telefon',
            'Yardım Türü',
            'Miktar',
            'Mahalle',
            'Adres',
            'Durum',
            'Kayıt Tarihi',
            'Son İşlem Tarihi',
            'Açıklama'
        ];
    }
}
