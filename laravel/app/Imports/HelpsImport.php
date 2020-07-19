<?php

namespace App\Imports;

use App\Models\Help;
use App\Models\HelpImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HelpsImport implements ToModel,WithHeadingRow
{

    public function model(array $row)
    {

        return HelpImport::create([
            'first_name' => $row['ad'],
            'last_name' => $row['soyad'],
            'person_slug' => str_slug($row['ad']." ".$row['soyad']),
            'phone' => $row['telefon'],
            'tc_no' => $row['tc'],
            'help_types_id' => $row['type'],
            'quantity' => $row['adet'],
            'neighborhood_id' => $row['mahalle'],
            'street' => $row['sokak'],
            'city_name' => $row['site'],
            'gate_no' => $row['kapi'],
            'status_id' => $row['durum'],
            'created_at' => strtotime($row['tarih']),
            'updated_at' => strtotime($row['tarih']),
            'detail' => $row['aciklama']
        ]);
    }
}
