<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Helpers\Helpers;
use App\Models\Help;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    public function index(){
        Helpers::sessionMenu('yardim-masasi','durumlar');
        $statuses = Status::all();
        return view('yonetim.statuses.statuses')->with([
            'statuses' => $statuses
        ]);
    }

    public function update(Request $request){
        $status = Status::findOrFail($request->statusId);
        $status->name = $request->name;
        $status->finisher = $request->finisher;

        if ($status->save()){
            Alert::success('Başarılı','Durum bilgisi başarıyla güncellendi.');
            return redirect()->back();
        }else {
            Alert::error('Hata','Durum bilgisi güncellenemedi.');
            return redirect()->back();
        }

    }

    public function store(Request $request){


        $status = new Status;
        $status->name = $request->name;
        $status->finisher = $request->finisher;

        if ($status->save()){
            Alert::success('Başarılı','Durum bilgisi başarıyla eklendi.');
            return redirect()->back();
        }else {
            Alert::error('Hata','Durum bilgisi eklenemedi.');
            return redirect()->back();
        }

    }

    public function showByAllHelps($id){
        $status = Status::findOrFail($id);

        $hqb = Help::query();
        $hqb->where('status_id','=',$id);
        $helps = $hqb->get();

        return view('yonetim.statuses.helps')->with([
            'helps' => $helps,
            'statusName' => $status->name
        ]);
    }

    public function destroy($id){
        $status = Status::findOrFail($id);

        if ($status->delete()){
            Alert::success('Başarılı','Durum bilgisi başarıyla silindi.');
            return redirect()->back();
        }else {
            Alert::error('Hata','Durum bilgisi silinemedi.');
            return redirect()->back();
        }
    }

}
