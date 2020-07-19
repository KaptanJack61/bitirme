<?php

namespace App\Exports;

use Helpers;
use App\Models\Help;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Session;

class HelpsExport implements FromQuery, WithMapping, WithHeadings
{

    public function query()
    {       
        $first_date = Session::get('first_date');
        $lastdate = Session::get('last_date');

        $data = Help::query();
        $data->join('statuses','helps.status_id','statuses.id');
        $data->join('neighborhoods','helps.neighborhood_id','neighborhoods.id');
        $data->select('helps.*');
        $data->where('statuses.finisher', '=', 0);

        if($first_date == null) {
            if($lastdate != null) {
                $data->where('helps.created_at','<',Carbon::createFromFormat('d.m.Y H:i:s',$lastdate." 23:59:59"));
            }
        }else {
            if($lastdate == null) {
                $data->where('helps.created_at','>',Carbon::createFromFormat('d.m.Y H:i:s',$first_date." 00:00:00"));
            }else{
                if(date('d.m.Y',strtotime($first_date))<=date('d.m.Y',strtotime($lastdate))){

                    $data->whereBetween('helps.created_at',[Carbon::createFromFormat('d.m.Y H:i:s',$first_date." 00:00:00"),Carbon::createFromFormat('d.m.Y H:i:s',$lastdate." 23:59:59")]);
                }else {
                    $data->whereBetween('helps.created_at',[Carbon::createFromFormat('d.m.Y H:i:s',$lastdate." 00:00:00"),Carbon::createFromFormat('d.m.Y H:i:s',$first_date." 23:59:59")]);
                }                
            } 
        }
        
        $data->orderBy('neighborhoods.name');

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
            'Kayıt Tarihi',
            'Son İşlem Tarihi',
            'Açıklama'
        ];
    }

}
