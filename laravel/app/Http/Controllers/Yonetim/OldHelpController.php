<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use Helpers;
use App\Models\Help;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OldHelpController extends Controller
{
    public function index(){
        Helpers::sessionMenu("yardim-masasi","eskiyardimtalepleri");
        $helpTypes = Helpers::getHelpTypes();
        $statuses = Status::where('finisher','=',true)->get();
        return view('yonetim.oldhelps.add')->with([
            'helpTypes' => $helpTypes
        ]);
    }

    public function store(Request $request){

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'neighborhood' => 'required',
            'street' => 'required',
            'cdate' => 'required|',
            'udate' => 'required'
        ]);

        if ($request->status == 0) {
            Alert::error('Hata','Hatalı ya da eksik bilgi girdiniz');
            return redirect()->back()->withInput();
        }

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = Helpers::convertToIntPhone($request->phone);
        $neighborhood_id = $request->neighborhood;
        $street = $request->street;

        $helpTypes = Helpers::getHelpTypes();

        // TODO: REFACTOR EDİLECEK KAYIT METHODU YAZILACAK KOD GÖRÜNÜMÜ DÜZELTİLECEK
        foreach ($helpTypes as $h){
            if ($request[$h->slug]!=null) {
                $help = new Help;
                $help->first_name = $first_name;
                $help->last_name = $last_name;
                $help->person_slug = str_slug($first_name." ".$last_name);
                $help->phone = $phone;
                $help->neighborhood_id = $neighborhood_id;
                $help->street = $street;
                $help->help_types_id = $h->id;
                if ($request->status == 0)
                    $help->status_id = 3;
                else
                    $help->status_id = $request->status;
                $help->quantity = $request[$h->slug];
                $help->created_at = strtotime($request->cdate);
                $help->updated_at = strtotime($request->udate);

                if ($request->tc_no!=null)
                    $help->tc_no = $request->tc_no;

                if ($request->email!=null)
                    $help->email = $request->email;

                if ($request->city_name!=null){
                    $help->city_name = $request->city_name;
                    $address['city_name'] = $request->city_name;
                }
                if ($request->gate_no!=null){
                    $help->gate_no = $request->gate_no;
                    $address['gate_no'] = $request->gate_no;
                }
                if ($request->detail!=null){
                    $help->detail = $request->detail;
                }

                $help->save();

                Helpers::activity('Eski yardım talebi eklendi.','ekledi');

            }

        }

        Alert::success("Başarılı","Yardım kayıtları başarı ile alındı.");
        return redirect()->back();

    }


}
