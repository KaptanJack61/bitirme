<?php

namespace App\Exports;

use App\Models\Help;
use Carbon\Carbon;
use Helpers;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Session;

class NeighborhoodsExport implements FromQuery, WithMapping, WithHeadings
{

    public function query()
    {
        $hid = Session::get('excel-help-type-id');
        $nid = Session::get('neighborhood');
        $sid = Session::get('status');
        $first_date = Session::get('first-date');
        $last_date = Session::get('last-date');


        $data = Help::query();
        $data->join('statuses','helps.status_id','statuses.id');
        $data->select('helps.*');

        if ($sid == 1) {
            $data->where('statuses.finisher', '=', 0);
        }

        if ($sid == 2) {
            $data->where('statuses.finisher', '=', 1);
        }

        if ($nid != 0){
            $data->where('helps.neighborhood_id','=',$nid);
        }

        if ($hid != 0){
            $data->where('helps.help_types_id','=',$hid);
        }

        if ($first_date != null){
            if ($last_date == null){
                $data->where('helps.created_at','>',Carbon::createFromFormat('d.m.Y H:i:s',$first_date." 00:00:00"));
            }else {
                $data->whereBetween('helps.created_at',[Carbon::createFromFormat('d.m.Y H:i:s',$first_date." 00:00:00"),Carbon::createFromFormat('d.m.Y H:i:s',$last_date." 23:59:59")]);
            }
        }else {
            if ($last_date != null){
                $data->where('helps.created_at','<',Carbon::createFromFormat('d.m.Y H:i:s',$last_date." 23:59:59"));
            }
        }

        $data->orderBy('helps.updated_at');

        Session::forget('excel-help-type-id');
        Session::forget('neighborhood');
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
