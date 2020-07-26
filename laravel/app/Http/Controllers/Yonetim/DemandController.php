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

                          <a id="sil" href='.route('yardimtalebi.all.destroy',  ['id' => $demand->id]).' 
                                        class="btn btn-danger btn-sm"
                                        data-toggle="tooltip" data-placement="top" title="Sil" 
                          >
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
        $helpIdList = json_decode($demand->helps);

        if ($this->controlCompletedHelps($helpIdList,true) == true){
            Alert::error('Hata','Bu talepteki tüm yardımlar tamamlandığından silemezsiniz.');
            return redirect()->back();
        }

        if ($this->controlCompletedHelps($helpIdList,false) == true ){
            $deleteHelps = $this->deleteHelps($helpIdList);
            $this->deleteDemandInHelpsList($deleteHelps);
            Alert::warning('Kısmen Başarılı', 'Talep içerisinde tamamlanmayan yardımlar silindi.');
            return redirect()->back();

        }

        $this->deleteHelps($helpIdList);

        $demand->delete();
        Alert::success('Başarılı', 'Talep ve içerisindeki yardımlar silndi.');
        return redirect()->back();
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

    public static function store($phone,$okHelpList){
        $demand = new Demand;
        $demand->helps = $okHelpList;
        $demand->phone = $phone;
        $demand->save();

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
        $demand = $this::show($id);
        $helpId = json_decode($demand->helps);
        $phone = $demand->phone;
        $date = $demand->created_at;
        $helpList = [];
        $full_name = "";
        $address = "";
        $detail = "";

        foreach ($helpId as $h){
            $help = Help::findOrFail($h);
            array_push($helpList,$help);
            $full_name = $help->full_name;
            $address = $help->address;
            $detail = $help->detail;
        }

        return view('yonetim.demands.details')->with([
            'demand_no' => $demand->id,
            'phone' => Helpers::phoneTextFormat($phone),
            'full_name' => $full_name,
            'helpList' => $helpList,
            'date' => $date,
            'address' => $address,
            'detail' => $detail
        ]);
    }

    public function editAllInputForm($id){

        $demand = Demand::findOrFail($id);
        $helpsIdList = json_decode($demand->helps);

        foreach ($helpsIdList as $helpId){
            $help = Help::find($helpId);

            if ($help!=null) {
                $help->quantity = (int)Request::get($helpId);
                $help->save();
            }

        }

        Alert::success('Başarılı','Yardım Talepleri Güncellendi.');
        return redirect()->back();

    }

    public function updateIndex($id){

        $demand = Demand::findOrFail($id);
        $helpIdList = json_decode($demand->helps);

        $slug_list = [];
        $first_name = "";
        $last_name = "";
        $tc_no = "";
        $email = "";
        $neighborhood_id = "";
        $street = "";
        $city_name = "";
        $gate_no = "";
        $detail = "";

        foreach ($helpIdList as $helpId){
            $help = Help::find((int)$helpId);
            if ($help != null) {
                array_push($slug_list,$help->type->slug);
                $first_name = $help->first_name;
                $last_name = $help->last_name;
                $tc_no = $help->tc_no;
                $email = $help->email;
                $neighborhood_id = $help->neighborhood_id;
                $street = $help->street;
                $city_name = $help->city_name;
                $gate_no = $help->gate_no;
                $detail = $help->detail;
            }


        }

        $helpTypes = Helpers::getHelpTypes();

        return view('yonetim.demands.edit')->with([
            'demand' => $demand,
            'helpIdList' => $helpIdList,
            'helpTypes' => $helpTypes,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'tc_no' => $tc_no,
            'email' => $email,
            'neighborhood_id' => $neighborhood_id,
            'street' => $street,
            'city_name' => $city_name,
            'gate_no' => $gate_no,
            'detail' => $detail,
            'slug_list' =>$slug_list
        ]);

    }

    public function update($id){
        $demand = Demand::find($id);
        $helpIdList = json_decode($demand->helps);

        $helpTypes = Helpers::getHelpTypes();

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

        $requestFullList = [];
        $requestEmptyList = [];
        $demandTypeList = [];
        $otherDeleteList = [];
        $newList = [];

        foreach ($helpTypes as $ht){
            if (Request::get($ht->slug)!=""){
                array_push($requestFullList,$ht->slug);
            }else{
                array_push($requestEmptyList,$ht->slug);
            }
        }

        foreach ($helpIdList as $hi){
            $help = Help::find($hi);
            if ($help != null)
                array_push($demandTypeList,$help->type->slug);
        }

        foreach ($helpIdList as $hi){
            foreach ($requestFullList as $rfl){
                $helpType = Helpers::getShowHelpTypeProperties($rfl,'slug');
                $hti = $helpType[0]->id;
                if (in_array($rfl,$demandTypeList) == true ){
                    $help = Help::find((int)$hi);
                    if ($help != null and $help->type->slug == $rfl){
                        $help->first_name = $first_name;
                        $help->last_name = $last_name;
                        $help->person_slug = str_slug($first_name." ".$last_name);
                        $help->phone = $phone;
                        $help->tc_no = $tc_no;
                        $help->email = $email;
                        $help->neighborhood_id = $neighborhood_id;
                        $help->street = $street;
                        $help->city_name = $city_name;
                        $help->gate_no = $gate_no;
                        $help->help_types_id = $hti;
                        $help->quantity = Request::get($rfl);
                        $help->detail = $detail;
                        $help->save();
                        array_push($newList,(string)$help->id);
                    }
                }else{
                    $help = new Help;
                    $help->first_name = $first_name;
                    $help->last_name = $last_name;
                    $help->person_slug = str_slug($first_name." ".$last_name);
                    $help->phone = $phone;
                    $help->tc_no = $tc_no;
                    $help->email = $email;
                    $help->neighborhood_id = $neighborhood_id;
                    $help->street = $street;
                    $help->city_name = $city_name;
                    $help->gate_no = $gate_no;
                    $help->help_types_id = $hti;
                    $help->status_id = 1;
                    $help->quantity = Request::get($rfl);
                    $help->detail = $detail;
                    $help->save();
                    array_push($newList,(string)$help->id);
                    array_push($demandTypeList,$help->type->slug);
                }
            }
        }

        if (count($requestEmptyList) > 0){
            foreach ($helpIdList as $hi) {
                foreach ($requestEmptyList as $rel) {
                    if (in_array($rel,$demandTypeList) == true ){
                        $help = Help::find((int)$hi);
                        if ($help != null and $help->type->slug == $rel){
                            array_push($otherDeleteList,$help->id);
                            $help->delete();
                        }

                    }

                }
            }
        }

        $demand->phone = $phone;
        $demand->helps = json_encode($newList);
        $demand->save();

        Alert::success("Başarılı","Yardım talebi güncellendi.");
        return redirect()->route('yardimtalebi.all.detail',['id' => $id]);


    }
}
