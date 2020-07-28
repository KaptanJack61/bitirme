<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Models\Person;
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

        $helps = $this->helpSqlQuery('people.phone',Helpers::convertToIntPhone($phone),"=");

        if (count($helps) != 0) {
            return view('yonetim.search.phone')->with([
                'helps' => $helps,
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
            $helpList = $demand->helps;
            $count = count($helpList);

            if ($count == 0){
                Alert::error('Hata','Yardım talebinde istek yardım kalmamış');
                return redirect()->back();
            }

            $closed = 0;
            $open = 0;

            foreach ($helpList as $help) {
                if ($help->status->finisher == true)
                    $closed++;
                else
                    $open++;
            }

            return view('yonetim.search.demand')->with([
                'demand' => $demand,
                'phone' => Helpers::phoneTextFormat($demand->person->phone),
                'count' => $count,
                'full_name' => $demand->person->full_name,
                'neighborhood' => $demand->person->neighborhood->name,
                'address' => $demand->person->address,
                'open' => $open,
                'closed' => $closed
            ]);

        }else {
            Alert::warning('Uyarı',$id."Yardım talebi bulunamadı");
            return redirect()->back();
        }

    }

    public function searchWithHelp($id){
        $helps = $this->helpSqlQuery('helps.id',$id,"=");

        if ($helps != null) {
            return view('yonetim.search.helpno')->with([
                'helps' => $helps
            ]);
        }else{
            Alert::error('Hata',$id.' yapılan yardım numarasına ait kayıt bulunamadı');
            return redirect()->back();
        }
    }

    public function searchWithTcNumber($tcNo){
        $helps = $this->helpSqlQuery('people.tc_no',$tcNo,"=");
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

        $helps = $this->helpSqlQuery('neighborhoods.id',$nid,"=");
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

        $helps = $this->helpSqlQuery('people.person_slug',$streetName,"like");

        if (count($helps) != 0){
            return view('yonetim.search.street')->with([
                'helps' => $helps,
                'streetName' => $streetName
            ]);

        }else {
            Alert::warning('Uyarı',$streetName." sokağında yardım bulunamadı");
            return redirect()->back();
        }

    }

    public function searchWithFullName($name){

        $helps = $this->helpSqlQuery('people.person_slug',str_slug($name),"like");

        if (count($helps) != 0){
            return view('yonetim.search.full_name')->with([
                'helps' => $helps,
                'full_name' => $name
            ]);

        }else {
            Alert::warning('Uyarı',$name. " adında kimseye ait yardım bulunuamadı");
            return redirect()->back();
        }

    }

    public function helpSqlQuery($column, $value, $operator){

        $hqb = Help::query();
        $hqb->join('demand_help','helps.id','demand_help.help_id');
        $hqb->join('demands','demands.id','demand_help.demand_id');
        $hqb->join('people','people.id','demands.person_id');
        $hqb->join('neighborhoods','neighborhoods.id','people.neighborhood_id');
        $hqb->select('helps.*','people.first_name','people.last_name','people.city_name',
            'people.street','people.gate_no','demands.detail','people.phone','neighborhoods.name as neighborhood');

        if ($operator == "like") {
            $hqb->where($column,'like','%'.$value.'%')->get();
        }

        if ($operator == "=") {
        $hqb->where($column,'=',$value)->get();
        }

        return $hqb->get();
    }
}
