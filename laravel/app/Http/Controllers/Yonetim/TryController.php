<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Exports\NeighborhoodsExport;
use App\Imports\HelpsImport;
use App\Models\Help;
use App\Models\HelpImport;
use Auth;
use Carbon\Carbon;
use DB;
use Excel;
use FastExcel;
use App\Http\Controllers\Controller;

class TryController extends Controller
{
    public function index(){

        dd("buralar tehlikeli");
        //return Excel::download(new NeighborhoodsExport, 'kemalpasaerzak.xlsx');

    }

    public function export(){

        if (Auth::guard('yonetim')->user()->id !=1) {
            Alert::error('Hata','Bu işlemi yapmaya yetkin yok');
            return redirect()->back();
        }

        $hqb = Help::query();
        $hqb->where('help_types_id', '=', 4);
        $help = $hqb->get();

        return (new FastExcel($help))::download('raporlar/deneme.xlsx', function ($help) {
            return [
                'Ad Soyad' => $help->full_name,
                'Mahalle' => $help->neighborhood->name,
                'Yardım' => $help->type->name,
                'Miktar' => $help->quantity,
                'Durum' => $help->status->name
            ];
        });

    }

    public function import(){

        if (Auth::guard('yonetim')->user()->id !=1) {
            Alert::error('Hata','Bu işlemi yapmaya yetkin yok');
            return redirect()->back();
        }

        $fastexcel = new FastExcel;
        $collection = $fastexcel->import('raporlar/helpsimportdata.xlsx');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table helps');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach ($collection as $c) {
            $help = new Help;
            $help->first_name = $c['ad'];
            $help->last_name = $c['soyad'];
            $help->person_slug = str_slug($c['ad']." ".$c['soyad']);
            $help->phone = $c['telefon'];
            if ($c['tc'] != "")
                $help->tc_no = $c['tc'];
            $help->help_types_id = $c['type'];
            $help->quantity = $c['adet'];
            $help->neighborhood_id = $c['mahalle'];

            $rules = array("Sk.", "sk.", ".Sokak");
            $street = str_replace($rules, "SOK.", $c['sokak']);

            $help->street = $street;
            $help->city_name = strtoupper($c['site']);
            $help->gate_no = strtoupper($c['kapi']);
            $help->status_id = $c['durum'];
            $help->detail = $c['aciklama'];
            $help->created_at = $c['tarih'];
            $help->updated_at = $c['tarih'];
            $help->save();


        }

        $helps = HelpImport::all();

        return "import edildi.";

    }

    public function maskImport(){

        if (Auth::guard('yonetim')->user()->id !=1) {
            Alert::error('Hata','Bu işlemi yapmaya yetkin yok');
            return redirect()->back();
        }

        $fastexcel = new FastExcel;

        $collection = $fastexcel::import('raporlar/maske.xlsx');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table helps');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach ($collection as $c) {
            $help = new Help;
            $help->first_name = $c['ad'];
            $help->last_name = $c['soyad'];
            $help->person_slug = str_slug($c['ad']." ".$c['soyad']);
            $help->phone = $c['telefon'];
            if ($c['tc'] != "")
                $help->tc_no = $c['tc'];
            $help->help_types_id = $c['type'];
            $help->quantity = $c['adet'];
            $help->neighborhood_id = $c['mahalle'];

            $rules = array("Sk.", "sk.", ".Sokak");
            $street = str_replace($rules, "SOK.", $c['sokak']);

            $help->street = $street;
            $help->city_name = strtoupper($c['site']);
            $help->gate_no = strtoupper($c['kapi']);
            $help->status_id = $c['durum'];
            $help->detail = $c['aciklama'];
            $help->created_at = $c['tarih'];
            $help->updated_at = $c['tarih'];
            $help->save();


        }

        return "import edildi.";

    }

    public function mask2Import()
    {
        if (Auth::guard('yonetim')->user()->id !=1) {
            Alert::error('Hata','Bu işlemi yapmaya yetkin yok');
            return redirect()->back();
        }

        Excel::import(new HelpsImport(), 'raporlar/maske7.xlsx');

        return "import edildi.";
    }

}
