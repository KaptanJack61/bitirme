<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use Helpers;
use App\Models\Demand;
use App\Models\Help;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request) {

        if ($request->type == 1 and $request->search != null)
            return $this->searchWithPhone($request->search);
        if ($request->type == 2 and $request->search != null)
            return $this->searchWithDemand($request->search);
        if ($request->type == 3 and $request->search != null)
            return $this->searchWithHelp($request->search);
        if ($request->type == 4 and $request->search != null)
            return $this->searchWithTcNumber($request->search);
        if ($request->type == 5 and $request->neighborhood != 0)
            return $this->searchWithNeighborhood($request->neighborhood);
        if ($request->type == 6 and $request->search != null)
            return $this->searchWithStreet($request->search);
        if ($request->type == 7 and $request->search != null)
            return $this->searchWithFullName($request->search);

        Alert::error('Hata','Eksik ya da hatalı bilgi girdinzi.');
        return redirect()->back();

    }

    public function searchWithPhone($phone){

        $help = Help::where('phone','=',Helpers::convertToIntPhone($phone))
            ->get();

        if (count($help) != 0) {
            return view('yonetim.search.phone')->with([
                'helps' => $help,
                'phone' => Helpers::phoneTextFormat($phone)
            ]);
        }else{
            Alert::error('Hata','Girilen telefon numarasına ait kayıt bulunamadı');
            return redirect()->back();
        }

    }

    public function searchWithDemand($id){
        $demand = Demand::find($id);
        if ($demand != null){
            $helpList = json_decode($demand->helps);
            $count = count($helpList);
            if ($count == 0){
                Alert::error('Hata','Yardım talebinde istek yardım kalmamış');
                return redirect()->back();
            }

            $hid = $helpList[0];
            $help = Help::find($hid);

            return view('yonetim.search.demand')->with([
                'demand' => $demand,
                'phone' => Helpers::phoneTextFormat($demand->phone),
                'count' => $count,
                'full_name' => $help->full_name,
                'neighborhood' => $help->neighborhood->name,
                'address' => $help->address
            ]);

        }else {
            Alert::warning('Uyarı',$id."Yardım talebi bulunamadı");
            return redirect()->back();
        }

    }

    public function searchWithHelp($id){
        $help = Help::find($id);

        if ($help != null) {
            return view('yonetim.search.helpno')->with([
                'help' => $help
            ]);
        }else{
            Alert::error('Hata',$id.' yapılan yardım numarasına ait kayıt bulunamadı');
            return redirect()->back();
        }
    }

    public function searchWithTcNumber($tcNo){
        $helps = Help::where('tc_no','=',$tcNo)->get();
        if (count($helps) != 0){
            return view('yonetim.search.tc_no')->with([
                'helps' => $helps,
                'tc_no' => $tcNo
            ]);
        }
        else{
            Alert::warning('Uyarı',$tcNo."T.C numarası ile yardım bulunuamadı");
            return redirect()->back();
        }

    }

    public function searchWithNeighborhood($nid){

        $helps = Help::where('neighborhood_id','=',$nid)->get();
        $neighborhood = Neighborhood::find($nid);
        if (count($helps) != 0){
            return view('yonetim.search.neighborhood')->with([
                'helps' => $helps,
                'neighborhoodName' => $neighborhood->name
            ]);
        }
        else{
            Alert::warning('Uyarı',$neighborhood->name." mahallesinde yardım bulunuamadı");
            return redirect()->back();
        }

    }

    public function searchWithStreet($streetName){
        $helps = Help::where('street','like','%'.$streetName.'%')->get();

        if (count($helps) != 0){
            return view('yonetim.search.street')->with([
                'helps' => $helps,
                'streetName' => $streetName
            ]);
        }
        else{
            Alert::warning('Uyarı',$streetName." sokağında yardım bulunamadı");
            return redirect()->back();
        }

    }

    public function searchWithFullName($name){

        $helps = Help::where('person_slug','like','%'.str_slug($name).'%')->get();
        if (count($helps) != 0){
            return view('yonetim.search.full_name')->with([
                'helps' => $helps,
                'full_name' => $name
            ]);
        }else{
            Alert::warning('Uyarı',$name. " adında kimseye ait yardım bulunuamadı");
            return redirect()->back();
        }



    }
}
