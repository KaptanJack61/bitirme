<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Models\DemandHelp;
use App\Models\Person;
use Helpers;
use App\Models\Demand;
use App\Models\Help;
use App\Models\HelpType;
use App\Models\Neighborhood;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class HelpController extends Controller
{
    public function index()
    {
        Helpers::sessionMenu('yardim-masasi','yapilan-yardimlar');

        return view('yonetim.helps.helps2');


    }

    public function index2()
    {
        return view('yonetim.helps.helps2');
    }

    public function notCompletedHelps (){
        Helpers::sessionMenu('yardim-masasi','tamamlanmayan-yardimlar');
        return view('yonetim.helps.notcompleted');
    }

    public function getNotCompletedHelps(){


        $model = Help::query();
        $model->with('type');
        $model->join('statuses','statuses.id','=','helps.status_id');
        $model->join('demand_help','demand_help.help_id','helps.id');
        $model->join('demands','demands.id','demand_help.demand_id');
        $model->join('people','people.id','demands.person_id');
        $model->join('neighborhoods','neighborhoods.id','people.neighborhood_id');
        $model->where('statuses.finisher', '=',false);
        $model->select(
            'helps.*',
            'people.first_name',
            'people.last_name',
            'people.person_slug',
            'people.street',
            'people.city_name',
            'people.gate_no',
            'people.phone',
            'demands.detail',
            'statuses.name as statusname',
            'statuses.id as statusid',
            'neighborhoods.name as neighborhoodname',
            'neighborhoods.id as neighborhoodid'
        );

        return DataTables::of($model)

            ->setRowAttr([
                'data-toggle' => "tooltip",
                'data-placement' => 'top',
                'title' => function($help) {
                    if ($help->detail != "")
                        return $help->detail;
                },
            ])

            ->setRowData([
                'full_name'=> function($help){
                    return $help->first_name.' '.$help->last_name;
                },
                'street'=> function($help){
                    return $help->street." ".$help->city_name." No: ".$help->gate_no;
                },
                'neighborhoods' => function ($help){
                    return $help->neighborhoodname;
                },
                'phone' => function($help){
                    return Helpers::phoneTextFormat($help->phone);
                },
                'help_types' => function ($help) {
                    return $help->type->name;
                },
                'quantity' => function ($help) {
                    return $help->quantity." ".$help->type->metrik;
                },
                'date' => function ($help) {
                    return date('d.m.Y', strtotime($help->created_at));
                },
                'udate' => function ($help) {
                    return date('d.m.Y', strtotime($help->updated_at));
                },
                'detail' => function ($help) {
                    return $help->detail;
                }
            ])

            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "CONCAT(helps.first_name,'-',helps.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->filterColumn('address', function($query, $keyword) {
                $sql = "CONCAT(helps.street,'-',helps.city_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->addColumn('statuses', function($help) {
                if ($help->statusid == 1)
                    return '<h5><span class="badge badge-pill badge-success">'.$help->statusname.'</span></h5>';
                else
                    return '<h5><span class="badge badge-pill badge-warning">'.$help->statusname.'</span></h5>';
            })

            ->addColumn('islemler', function (Help $help) {

                return '<a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                             data-target="#completed"
                             data-helpid="'.$help->id.'"
                             data-detail="'.$help->detail.'"
                          >
                              <i class="fa fa-check"></i>
                          </a>
                          <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                             data-target="#helpEdit"
                             data-helpid="'.$help->id.'"
                             data-quantity="'.$help->quantity.'"
                             data-neighborhoodid="'.$help->neighborhoodid.'"
                             data-neighborhoodname="'.$help->neighborhoodname.'"
                             data-metrik="'.$help->type->metrik.'"
                             data-street="'.$help->street.'"
                             data-cityname="'.$help->city_name.'"
                             data-gateno="'.$help->gate_no.'"
                             data-helptypeid="'.$help->type->id.'"
                             data-name="'.$help->type->name.'"
                             data-statusid="'.$help->statusid.'"
                             data-statusname="'.$help->statusname.'"
                          >
                              <i class="fa fa-edit"></i>
                          </a>

                          <a id="sil" href="#" class="btn btn-danger btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#deleted"
                                        data-helpid="'.$help->id.'">
                              <i class="fa fa-trash"></i>
                          </a>                       
                          
                          ';
            })

            ->rawColumns(['islemler','statuses'])

            ->make(true);

    }

    public function getHelps()
    {

        $model = Help::query();
        $model->with('status','type');
        $model->join('demand_help','demand_help.help_id','helps.id');
        $model->join('demands','demands.id','demand_help.demand_id');
        $model->join('people','people.id','demands.person_id');
        $model->join('neighborhoods','neighborhoods.id','people.neighborhood_id');
        $model->select(
            'helps.*',
            'people.first_name',
            'people.last_name',
            'people.person_slug',
            'people.street',
            'people.city_name',
            'people.gate_no',
            'people.phone',
            'demands.detail',
            'neighborhoods.name as neighborhoodname',
            'neighborhoods.id as neighborhoodid'
        );

        return DataTables::of($model)

            ->setRowAttr([
                'data-toggle' => "tooltip",
                'data-placement' => "top",
                'title' => function($help) {
                    if ($help->detail != "")
                        return $help->detail;
                },
                'role' => 'row'
            ])

            ->setRowData([
                'full_name'=> function($help){

                    return $help->first_name.' '.$help->last_name;
                },
                'street'=> function($help){
                    return $help->street." ".$help->city_name." No: ".$help->gate_no;
                },
                'neighborhoods' => function ($help){
                    return $help->neighborhoodname;
                },
                'phone' => function($help){
                    return Helpers::phoneTextFormat($help->phone);
                },
                'help_types' => function ($help) {
                    return $help->type->name;
                },
                'quantity' => function ($help) {
                    return $help->quantity." ".$help->type->metrik;
                },
                'date' => function ($help) {
                    return date('d.m.Y', strtotime($help->created_at));
                },
                'udate' => function ($help) {
                    return date('d.m.Y', strtotime($help->updated_at));
                }
            ])

            ->filterColumn('full_name', function($query, $keyword) {
                $sql = "CONCAT(people.person_slug)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->filterColumn('neighborhoods', function($query, $keyword) {
                $sql = "CONCAT(neighborhoods.slug)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->filterColumn('address', function($query, $keyword) {
                $sql = "CONCAT(people.street,'-',people.city_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })

            ->filterColumn('date', function($query, $keyword) {
                $sql = "select * from helps where date(created_at) = date($keyword)";
                $query->whereRaw($sql,$keyword);
            })

            ->addColumn('statuses', function($help) {
                if ($help->status->finisher == true and $help->status->id != 5) {
                    return '<h5><span class="badge badge-pill badge-secondary">'.$help->status->name.'</span></h5>';
                }else if ($help->status->finisher == true and $help->status->id == 5){
                    return '<h5><span class="badge badge-pill badge-danger">'.$help->status->name.'</span></h5>';
                }else {
                    if ($help->status->finisher == false and $help->status->id != 1)
                        return '<h5><span class="badge badge-pill badge-warning">'.$help->status->name.'</span></h5>';
                    else
                        return '<h5><span class="badge badge-pill badge-success">'.$help->status->name.'</span></h5>';
                }
            })

            ->addColumn('islemler', function (Help $help) {



                if ($help->demandHelp !== null) {
                    $demand = Demand::find($help->demandHelp->demand_id);
                    if ($help->status->finisher == true){
                        return '
                   <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                             data-target="#completed"
                             data-helpid="'.$help->id.'"
                             data-detail="'.$demand->detail.'"
                          >
                              <i class="fa fa-edit text-dark"></i>
                          </a>
                    ';
                    }else {
                        return '<a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                             data-target="#completed"
                             data-helpid="'.$help->id.'"
                             data-detail="'.$demand->detail.'"
                          >
                              <i class="fa fa-check"></i>
                          </a>
                          <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                             data-target="#helpEdit"
                             data-helpid="'.$help->id.'"
                             data-quantity="'.$help->quantity.'"
                             data-neighborhoodid="'.$help->neighborhoodid.'"
                             data-neighborhoodname="'.$help->neighborhoodname.'"
                             data-metrik="'.$help->type->metrik.'"
                             data-street="'.$help->street.'"
                             data-cityname="'.$help->city_name.'"
                             data-gateno="'.$help->gate_no.'"
                             data-helptypeid="'.$help->help_types_id.'"
                             data-name="'.$help->type->name.'"
                             data-statusid="'.$help->status->id.'"
                             data-statusname="'.$help->status->name.'"
                          >
                              <i class="fa fa-edit"></i>
                          </a>

                          <a id="sil" href="#" class="btn btn-danger btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#deleted"
                                        data-helpid="'.$help->id.'">
                              <i class="fa fa-trash"></i>
                          </a>                       
                          
                          ';
                    }

                }else {

                    if ($help->status->finisher == true){
                        return '
                   <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                             data-target="#completed"
                             data-helpid="'.$help->id.'"
                             data-detail=""
                          >
                              <i class="fa fa-edit text-dark"></i>
                          </a>
                    ';
                    }else {
                        return '<a href="#" class="btn btn-success btn-sm" data-toggle="modal"
                             data-target="#completed"
                             data-helpid="'.$help->id.'"
                             data-detail=""
                          >
                              <i class="fa fa-check"></i>
                          </a>
                          <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                             data-target="#helpEdit"
                             data-helpid="'.$help->id.'"
                             data-quantity="'.$help->quantity.'"
                             data-neighborhoodid="'.$help->neighborhoodid.'"
                             data-neighborhoodname="'.$help->neighborhoodname.'"
                             data-metrik="'.$help->type->metrik.'"
                             data-street="'.$help->street.'"
                             data-cityname="'.$help->city_name.'"
                             data-gateno="'.$help->gate_no.'"
                             data-helptypeid="'.$help->help_types_id.'"
                             data-name="'.$help->type->name.'"
                             data-statusid="'.$help->status->id.'"
                             data-statusname="'.$help->status->name.'"
                          >
                              <i class="fa fa-edit"></i>
                          </a>

                          <a id="sil" href="#" class="btn btn-danger btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#deleted"
                                        data-helpid="'.$help->id.'">
                              <i class="fa fa-trash"></i>
                          </a>                       
                          
                          ';
                    }

                }
            })

            ->rawColumns(['islemler','statuses'])

            ->make(true);


    }

    public function storeIndex()
    {
        $hqb = HelpType::query();
        $hqb->select('id','name','slug','metrik');
        $hqb->orderBy('name','asc');
        $helpTypes = $hqb->get();

        return view('yonetim.helps.ekle')->with([
            'helpTypes' => $helpTypes
        ]);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'neighborhood' => 'required',
            'street' => 'required'
        ]);

        $helpTypes = HelpType::all();

        $c = false;

        foreach ($helpTypes as $h) {
            if ($request[$h->slug]!=null){
                $c = true;
            }
        }

        if ($c==false) {
            Alert::error('Hata', 'Yardım kalemlerinden en az 1 tanesini doldurmak zorundasınız!');
            return redirect()->back()->withInput();
        }

        foreach ($helpTypes as $h){
            if ($h->isSingle==true and $request[$h->slug]!=null) {
                $c = false;
            }

        }

        if ($c==false) {
            return $this->verifyStore($request,$helpTypes);
        }

        return $this->addHelps($request,$helpTypes);

    }

    public function verifyStore($request,$helpTypes) {

        $c = false;
        $helpList = [];
        $helpListOnControl = [];
        $phone = Helpers::convertToIntPhone($request->phone);

        foreach ($helpTypes as $h) {
           $help = $this->showWithPhoneAndHelpType($phone,$h->id);
           if($h->isSingle == true){
               if ($this->helpControl($phone,$h->id) == true){
                   array_push($helpList,$help);
                   array_push($helpListOnControl,$h->id);
                   $c=true;
               }
           }else {
               if ($this->helpControl($phone,$h->id) == true){
                   array_push($helpList,$help);
               }
           }

        }

        if ($c==true) {
            Alert::warning('Uyarı', $request->first_name." ".$request->last_name." isimli vatandaşın mevcut talepleri var.");
            $nb = Neighborhood::find($request->neighborhood);
            $neighborhood = $nb->name;
            $buttonControl = false;

            $person = Person::where('phone','=',Helpers::convertToIntPhone($request->phone))->get();

            return view('yonetim.helps.ekle_dogrula')->with([
                'helpListOnControl' => $helpListOnControl,
                'helpList' => $helpList,
                'helpTypes' => $helpTypes,
                'request' => $request,
                'neighborhood' => $neighborhood,
                'buttonControl' => $buttonControl,
                'person' => $person[0]
            ]);
        }

        return $this->addHelps($request,$helpTypes);

    }

    public function showWithPhoneAndHelpType($phone,$helpTypeId){

        $hqb = Help::query();
        $hqb->join('demand_help','helps.id','demand_help.help_id');
        $hqb->join('demands','demands.id','demand_help.demand_id');
        $hqb->join('people','people.id','demands.person_id');
        $hqb->where('people.phone','=',$phone);
        $hqb->where('helps.help_types_id','=',$helpTypeId);
        $hqb->select('helps.*');
        $help = $hqb->get();

        return $help;
    }

    protected function helpControl($phone,$typeId){

        if ($phone == 1111111111)
          return false;
        $hqb = Help::query();
        $hqb->join('demand_help','helps.id','demand_help.help_id');
        $hqb->join('demands','demands.id','demand_help.demand_id');
        $hqb->join('people','people.id','demands.person_id');
        $hqb->where('people.phone','=',$phone);
        $hqb->where('helps.help_types_id','=',$typeId);
        $count = $hqb->count();

        if ($count>0)
            return true;
        else
            return false;

    }

    protected function acceptStore(Request $request){

        $helpTypes = HelpTypeController::getShowByOther();
        return $this->addHelps($request,$helpTypes);
    }

    protected function addHelps($request, $helpTypes)
    {
        $phone = Helpers::convertToIntPhone($request->phone);
        $isPerson = Person::where('phone', '=',$phone)->get();
        $personid = "";

        if($isPerson->count() > 0) {
            $personid = $isPerson[0]->id;
        }else {
            $person = new Person;
            $person->first_name = $request->first_name;
            $person->last_name = $request->last_name;
            $person->person_slug = Str::slug($request->first_name." ".$request->last_name);
            $person->phone = Helpers::convertToIntPhone($request->phone);
            if ($request->tc_no!=null)
                $person->tc_no = $request->tc_no;

            if ($request->email!=null)
                $person->email = $request->email;


            $person->neighborhood_id = $request->neighborhood;
            $person->street = $request->street;

            if ($request->city_name!=null){
                $person->city_name = $request->city_name;
                $address['city_name'] = $request->city_name;
            }

            if ($request->gate_no!=null){
                $person->gate_no = $request->gate_no;
                $address['gate_no'] = $request->gate_no;
            }

            $person->save();

            $address['neighborhood'] = $person->neighborhood->name;

            $personid = $person->id;
        }

        $demand = new Demand;
        $demand->person_id = $personid;

        if ($request->detail!=null){
            $demand->detail = $request->detail;
        }

        $demand->save();

        $okHelpList = [];

        foreach ($helpTypes as $h){
            if ($request[$h->slug]!=null) {
                $help = new Help;
                $help->help_types_id = $h->id;
                $help->status_id = 1;
                $help->quantity = $request[$h->slug];

                if ($help->save()){
                    array_push($okHelpList,$help->id);
                    Helpers::activity('Yardım talebi eklendi.','ekledi');
                }

           }

        }

        return DemandController::store($demand,$okHelpList);

    }

    public function addSuccess($id)
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

    public function destroy($id)
    {

        if (Helpers::controlBackPreviousUrl("tamamlanmayanyardimlar")==false){
            if (Helpers::controlBackPreviousUrl("yapilanyardimlar" == false)){
                Alert::error('Hata','Bu sayfada silme işlemi yapamazsınız.');
                return redirect()->back();
            }
        }

        $help = Help::findOrFail($id);

        if ($help->status->finisher == true) {
            Alert::error('Hata','Kapatılmış yardım talebinini silemezsiniz.');
            return redirect()->back();
        }

        $demand = "";
        foreach($help->demand as $demands) {
            $demand = $demands;
        }


        if ($help->delete()) {

            $demand->helps()->detach($help);
            $helpCount = DemandHelp::where('demand_id','=',$demand->id)->count();

            if ($helpCount === 0) {
                $person = $demand->person;
                $demand->delete();
                $person->delete();

                Helpers::activity('Yapılan yardım silindi','sildi');
                Alert::success('Başarılı','Yardım başarıyla silindi.');
                return redirect()->route('yardimtalepleri.demands');

            }

            Helpers::activity('Yapılan yardım silindi','sildi');
            Alert::success('Başarılı','Yardım başarıyla silindi.');
            return redirect()->back();
        }

    }

    public function complete(Request $request){

        //dd($request->all());
        $help = Help::findOrFail($request->helpId);
        $help->status_id = $request->helpType;


        if ($help->save()){
            Helpers::activity('Yapılan yardım durumu değiştirildi',$help->status->name." olarak değiştirdi.");
            Alert::success("Başarılı","Yardım başarıyla kapatıldı.");
            if ($request->detail != null) {
                $demandhelp = DemandHelp::where('help_id','=',$request->helpId)->get();
                foreach ($demandhelp as $dh){
                    $demand = Demand::findOrFail($dh->demand_id);
                    $demand->detail = $request->detail;
                    $demand->save();
                }
            }

            return redirect()->back();
        }else {
            Alert::error('Hata','Yardım kapatılamadı.');
            return redirect()->back();
        }
    }

    public function update(Request $request){

        //dd($request->all());
        $help = Help::findOrFail($request->helpId);
        $person = "";
        foreach($help->demand as $demand) {
            $person = $demand->person;
        }


        $person->neighborhood_id = $request->neighborhood;
        $person->street = $request->street;
        $person->city_name = $request->city_name;
        $person->gate_no = $request->gate_no;

        if ($person->save()) {
            $help->help_types_id = $request->helpType;
            $help->status_id = $request->status;
            $help->quantity = $request->quantity;

            if ($help->save()){
                Helpers::activity('Yapılan yardımı güncelledi.',$help->id." nolu yardımı güncelledi");
                Alert::success('Başarılı','Yardım başarıyla güncellendi.');
                return redirect()->back();
            }else {
                Alert::error('Hata','Adres Bilgileri güncellendi.');
                return redirect()->back();
            }

        }else {
            if ($help->save()){
                Helpers::activity('Yapılan yardımı güncelledi.',$help->id." nolu yardımı güncelledi");
                Alert::error('Hata','Adres Bilgileri güncellenemedi.');
                return redirect()->back();
            }else {
                Alert::error('Hata','Yardım güncellenemedi.');
                return redirect()->back();
            }
        }

    }

    public function copyHelpInfo($id){

        $help = Help::find($id);

        $helpTypes = Helpers::getHelpTypes();

        return view('yonetim.helps.ekle_kopyala')->with([
            'first_name' => $help->demandHelp->demand->person->first_name,
            'last_name' => $help->demandHelp->demand->person->last_name,
            'phone' => $help->demandHelp->demand->person->phone,
            'tc_no' => $help->demandHelp->demand->person->tc_no,
            'email' => $help->demandHelp->demand->person->email,
            'neighborhood_id' => $help->demandHelp->demand->person->neighborhood_id,
            'street' => $help->demandHelp->demand->person->street,
            'city_name' => $help->demandHelp->demand->person->city_name,
            'gate_no' => $help->demandHelp->demand->person->gate_no,
            'helpTypes' => $helpTypes

        ]);

    }

}
