<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Helpers\Helpers;
use App\Models\Demand;
use App\Models\DemandHelp;
use App\Models\Help;
use App\Models\HelpType;
use DataTables;
use DB;
use App\Http\Controllers\Controller;
use DemeterChain\A;
use Request;
use Session;

/**
 * TODO: TÜM METHODLAR DÖKÜMANTE EDİLECEK
 */

class DemandController extends Controller
{
    public function index(){
        $demands = Demand::all();
        $count = $demands->count();

        Helpers::sessionMenu('yardim-masasi','yardim-talepleri');

        if($count > 0){
            return view('yonetim.demands.demands')->with([
                'demands' => $demands
            ]);
        }else {
            return view('yonetim.demands.no-demands');
        }
    }

    public function index2(){

        Helpers::sessionMenu('yardim-masasi','yardim-talepleri');

        return view('yonetim.demands.demands2');

    }

    public function getDemands(){

        $model = Demand::query();
        $model->join('people', 'people.id','demands.person_id');
        $model->join('neighborhoods','neighborhoods.id','people.neighborhood_id');
        $model->select(
            'demands.*',
            'people.first_name',
            'people.last_name',
            'people.phone',
            'people.street',
            'people.city_name',
            'people.gate_no',
            'neighborhoods.name as neighborhoodname'
        );

        return DataTables::of($model)

            /*->setRowClass(function ($demand){

                $demandhelp = DemandHelp::query();
                $demandhelp->where('demand_id','=', $demand->id);
                $dhelp = $demandhelp->get();

                $closed = 0;
                $count = $dhelp->count();

                foreach ($dhelp as $dh) {
                    if ($dh->help->status->finisher == true)
                        $closed++;
                }

                if ($closed == $count)
                    return 'alert-success';

            })*/

            ->setRowData([
                'full_name'=> function($demand){
                    return $demand->person->full_name;
                },
                'street'=> function($demand){
                    return $demand->street." ".$demand->city_name." No: ".$demand->gate_no;
                },
                'neighborhood' => function ($demand){
                    return $demand->person->neighborhood->name;
                },
                'phone' => function($demand){
                    return Helpers::phoneTextFormat($demand->person->phone);
                },
                'sum' => function ($demand) {
                    $demandhelp = DemandHelp::query();
                    $demandhelp->where('demand_id','=', $demand->id);
                    return $demandhelp->count(). " Adet";
                },
                'date' => function ($demand) {
                    return date('d.m.Y', strtotime($demand->created_at));
                },
                'udate' => function ($demand) {
                    return date('d.m.Y', strtotime($demand->updated_at));
                }
            ])

            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "CONCAT(people.first_name,'-',people.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->filterColumn('neighborhood', function($query, $keyword) {
                $sql = "CONCAT(neighborhoods.name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->filterColumn('address', function($query, $keyword) {
                $sql = "CONCAT(people.street,'-',people.city_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->filterColumn('sum', function($query, $keyword) {
                $sql = "CONCAT(people.street,'-',people.city_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->addColumn('status', function ($demand) {
                $demandhelp = DemandHelp::query();
                $demandhelp->where('demand_id','=', $demand->id);
                $dhelp = $demandhelp->get();

                $closed = 0;
                $open = 0;
                $count = $dhelp->count();

                foreach ($dhelp as $dh) {
                    if ($dh->help->status->finisher == true)
                        $closed++;
                    else
                        $open++;
                }

                if ($closed == $count)
                    return '<h5><span class="badge badge-pill badge-secondary">Tamamlandı</span></h5>';

                if ($open == $count)
                    return '<h5><span class="badge badge-pill badge-success">İşleme Alındı</span></h5>';

                return '<h5><span class="badge badge-pill badge-warning">'.$closed.' Adet Tamamlandı</span></h5>';

            })

            ->addColumn('islemler', function ($demand) {

                $demandhelp = DemandHelp::query();
                $demandhelp->where('demand_id','=', $demand->id);
                $dhelp = $demandhelp->get();

                $closed = 0;
                $count = $dhelp->count();

                foreach ($dhelp as $dh) {
                    if ($dh->help->status->finisher == true)
                        $closed++;
                }

                if ($closed != $count){
                    return '                         
                          <a id="duzenle" href='.route('yardimtalebi.all.updateIndex',  ['id' => $demand->id]).'
                             class="btn btn-warning btn-sm" data-toggle="tooltip" data-toggle="tooltip" data-placement="top" title="Düzenle"                         
                             
                          >
                              <i class="fa fa-edit"></i>
                          </a>
                          
                          <a id="sil" href="#" class="btn btn-danger btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#deleted"
                                        data-demandid="'.$demand->id.'">
                              <i class="fa fa-trash"></i>
                          </a> 
                          
                          <a id="goruntule" href='.route('yardimtalebi.all.detail',  ['id' => $demand->id]).' 
                                        class="btn btn-primary btn-sm"
                                        data-toggle="tooltip" data-placement="top" title="Görüntüle" 
                          >
                              <i class="fa fa-eye"></i>
                          </a>                         
                          
                          ';
                }else {
                    return '                          
                          <a id="goruntule" href='.route('yardimtalebi.all.detail',  ['id' => $demand->id]).' 
                                        class="btn btn-primary btn-sm"
                                        data-toggle="tooltip" data-placement="top" title="Görüntüle" 
                          >
                              <i class="fa fa-eye"></i>
                          </a>                         
                          
                          ';
                }

            })

            ->rawColumns(['islemler', 'mahalle','status'])

            ->make(true);
    }

    public function destroy($id){
        $demand = Demand::find($id);

        $demandHelp = DemandHelp::where('demand_id','=', $id)->get();

        $countClosed = 0;
        $countOpen = 0;
        $helpList = [];

        foreach ($demandHelp as $dh) {
            if($dh->help->status->finisher == true){
                $countClosed++;
            }else {
                $countOpen++;
                array_push($helpList, $dh->help->id);
            }

        }


        if ($countClosed == 0) {

            $person = $demand->person;
            $demand->helps()->detach($helpList);

            if ($demand->delete()) {

                foreach ($helpList as $hid) {
                    $help = Help::find($hid);
                    $help->delete();
                }

                $countDemands = Demand::where('person_id','=', $person->id)->count();

                if ($countDemands == 0)
                    $person->delete();

                Alert::success('Başarılı', 'Talep ve içerisinde ki tüm yardımlar silindi.');
                return redirect()->route('yardimtalepleri.demands');

            }else {

                $demand->helps()->attach($helpList);
                Alert::warning('Hata', 'Yardım Talebi silinemedi.');
                return redirect()->route('yardimtalepleri.demands');
            }



        }else if($countOpen === 0) {

            Alert::error('Hata','Bu talepteki tüm yardımlar tamamlandığından silemezsiniz.');
            return redirect()->back();

        }else {

            $demand->helps()->detach($helpList);

            foreach ($helpList as $hid) {
                $help = Help::find($hid);
                $help->delete();
            }

            Alert::warning('Kısmen Başarılı', 'Talep içerisinde tamamlanmayan yardımlar silindi.');
            return redirect()->back();

        }


    }

    public function deleteDemandInHelpsList($deleteHelps){

        $dqb = Demand::query();
        $dqb->whereJsonContains('helps',$deleteHelps[0]);
        $demand = $dqb->get();
        $helpList = json_decode($demand[0]->helps);
        $id = $demand[0]->id;

        $newList = [];

        foreach ($helpList as $h){
            if (in_array($h, $deleteHelps)==false){
                $s = Help::find($h);
                if ($s != null) {
                    array_push($newList,$h);
                }
            }
        }

        $update = DB::table('demands')
            ->where('id', $id)
            ->update(['helps' => json_encode($newList)]);

    }

    public function deleteHelps($helpIdList){

        $deleteList = [];

        foreach ($helpIdList as $hid){
            $h = Help::find($hid);
            if ($h != null){
                if ($h->status->finisher == false){
                    if ($h->delete())
                        array_push($deleteList,$hid);
                }
            }

        }

        return $deleteList;

    }

    public function controlCompletedHelps($helpIdList,$finisher){

        $c = !$finisher;

        foreach ($helpIdList as $h){
            $h = Help::find($h);
            if ($h != null){
                if ($h->status->finisher == !$finisher)
                    $c = $finisher;

            }

        }

        if ($c == !$finisher)
            return $finisher;
        else
            return !$finisher;

    }

    public static function store($demand,$okHelpList){

        $demand->helps()->attach($okHelpList);

        return redirect()->route('yardimtalebi.addSuccess',['id' => $demand->id]);
    }

    public static function updateByHelpController($id,$list){
        $updated = DB::table('demands')
            ->where('id', $id)
            ->update(['helps' => $list]);

        if ($updated)
            return true;
        else
            return false;

    }

    public static function show($id){
        $demand = Demand::findOrFail($id);
        return $demand;
    }

    public function detail($id)
    {

        $demand = Demand::findOrFail($id);

        $helps = $demand->helps;

        $count = count($helps);
        $closed = 0;

        $isClosed = false;

        foreach ($helps as $help) {
            if ($help->status->finisher == true)
                $closed++;
        }

        if ($closed == $count)
            $isClosed = true;

        return view('yonetim.demands.details')->with([
            'demand_no' => $demand->id,
            'phone' => Helpers::phoneTextFormat($demand->person->phone),
            'full_name' => $demand->person->full_name,
            'helpList' => $demand->helps,
            'address' => $demand->person->address,
            'detail' => $demand->detail,
            'closed' => $isClosed
        ]);
    }

    public function editAllInputForm($id){

        $demandhelp = DemandHelp::where('demand_id','=',$id)->get();
        //dd($demandhelp);
        //$helpsIdList = json_decode($demand->helps);

        foreach ($demandhelp as $dh){
            $help = Help::find($dh->help_id);

            if ($help!=null) {
                $help->quantity = (int)Request::get($dh->help_id);
                $help->save();
            }

        }

        Alert::success('Başarılı','Yardım Talepleri Güncellendi.');
        return redirect()->back();

    }

    public function updateIndex($id){

        $demand = Demand::findOrFail($id);
        $helpIdList = [];
        $slug_list = [];

        $helps = $demand->helps;

        foreach ($helps as $help) {
            array_push($helpIdList, $help->id);
            array_push($slug_list, $help->type->slug);
        }

        $helpTypes = Helpers::getHelpTypes();

        return view('yonetim.demands.edit')->with([
            'demand' => $demand,
            'helpIdList' => $helpIdList,
            'helpTypes' => $helpTypes,
            'slug_list' =>$slug_list
        ]);

    }

    public function update($id){
        $demand = Demand::find($id);
        $person = $demand->person;


        $helps = $demand->helps;

        $first_name = Request::get('first_name');
        $last_name = Request::get('last_name');
        $phone = Helpers::convertToIntPhone(Request::get('phone'));
        $tc_no = Request::get('tc_no');
        $neighborhood_id = Request::get('neighborhood');
        $street = Request::get('street');
        $city_name = Request::get('city_name');
        $gate_no = Request::get('gate_no');
        $email = Request::get('email');
        $detail = Request::get('detail');

        $person->first_name = $first_name;
        $person->last_name = $last_name;
        $person->person_slug = str_slug($first_name." ".$last_name);
        $person->phone = $phone;
        $person->tc_no = $tc_no;
        $person->email = $email;
        $person->neighborhood_id = $neighborhood_id;
        $person->street = $street;
        $person->city_name = $city_name;
        $person->gate_no = $gate_no;
        $person->save();

        $demand->detail = $detail;
        $demand->save();

        $requestFullList = [];
        $requestEmptyList = [];
        $demandTypeList = [];
        $deleteList = [];
        $newList = [];


        foreach ($helps as $help) {
            array_push($demandTypeList,$help->type->slug);
        }

        $helpTypes = Helpers::getHelpTypes();

        foreach ($helpTypes as $ht){
            if (Request::get($ht->slug) != ""){
                array_push($requestFullList,$ht->slug);
            }else{
                array_push($requestEmptyList,$ht->slug);
            }
        }

        foreach ($requestFullList as $rfl) {

            if (in_array($rfl, $demandTypeList) == true) {
                foreach ($helps as $help) {
                    if ($help->type->slug == $rfl){
                        $help->quantity = Request::get($rfl);
                        $help->save();
                    }
                }
            }else {
                $h = new Help;
                $helpType = Helpers::getShowHelpTypeProperties($rfl,'slug');
                $hti = $helpType[0]->id;
                $h->help_types_id = $hti;
                $h->status_id = 1;
                $h->quantity = Request::get($rfl);
                $h->save();
                array_push($newList,$h->id);

            }
        }

        foreach ($requestEmptyList as $rel) {
            if (in_array($rel, $demandTypeList) == true) {
                foreach ($helps as $help) {
                    if ($help->type->slug == $rel){
                        array_push($deleteList,$help->id);
                        $help->delete();
                    }
                }
            }
        }


        if ($newList != null) {
            $demand->helps()->attach($newList);
        }

        if ($deleteList != null) {
            $demand->helps()->detach($deleteList);
        }

        Alert::success("Başarılı","Yardım talebi güncellendi.");
        return redirect()->route('yardimtalebi.all.detail',['id' => $id]);


    }
}
