<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Helpers\Helpers;
use App\Models\Help;
use App\Models\HelpType;
use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Http\Request;

class HelpTypeController extends Controller
{
    public static function  getShowByOther(){
        $hqb = HelpType::query();
        $hqb->select('id','name','slug','isSingle','metrik');
        $helpTypes = $hqb->get();

        return $helpTypes;
    }

    public function index(){
        Helpers::sessionMenu('parametre','yardim-turleri');


            $helpTypes = HelpType::all();
            Cache::forever('helptypes', $helpTypes);



        return view('yonetim.helptypes.helptypes')->with([
            'helpTypes' => $helpTypes
        ]);
    }

    public function update(Request $request){

        $helpType = HelpType::findOrFail($request->helpId);
        $helpType->name = $request->name;
        $helpType->slug = str_slug($request->name);
        $helpType->metrik = $request->metrik;
        $helpType->isSingle = $request->isSingle;

        if ($helpType->save()){
            Alert::success('Başarılı','Yardım Türü Güncellendi.');
            return redirect()->back();
        }else {
            Alert::error('Hata','Yardım Türü güncellenemedi.');
            return redirect()->back();
        }
    }

    public function store(Request $request){
        $helpType = new HelpType;
        $helpType->name = $request->name;
        $helpType->slug = str_slug($request->name);
        $helpType->metrik = $request->metrik;
        $helpType->isSingle = $request->isSingle;

        if ($helpType->save()){
            Alert::success('Başarılı','Yardım talebi eklendi.');
            return redirect()->back();
        }else {
            Alert::error('Hata','Yardım talebi eklenemedi.');
            return redirect()->back();
        }
    }

    public function showByAllHelps($id){
        $helpType = HelpType::findOrFail($id);

        $hqb = Help::query();
        $hqb->join('demand_help','helps.id','demand_help.help_id');
        $hqb->join('demands','demands.id','demand_help.demand_id');
        $hqb->join('people','people.id','demands.person_id');
        $hqb->join('neighborhoods','neighborhoods.id','people.neighborhood_id');
        $hqb->select('helps.*','people.first_name','people.last_name','people.city_name',
            'people.street','people.gate_no','demands.detail','people.phone','neighborhoods.name as neighborhood');

        $hqb->where('helps.help_types_id','=',$id);

        $helps = $hqb->get();

        return view('yonetim.helptypes.helps')->with([
            'helps' => $helps,
            'helpTypeName' => $helpType->name
        ]);
    }

    public function destroy($id){
        $helpType = HelpType::findOrFail($id);

        if ($helpType->delete()){
            Alert::success('Başarılı','Yardım türü başarıyla silindi.');
            return redirect()->back();
        }else {
            Alert::error('Hata','Yardım türü silinemedi.');
            return redirect()->back();
        }
    }
}
