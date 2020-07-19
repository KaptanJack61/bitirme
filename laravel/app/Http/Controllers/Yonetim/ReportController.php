<?php

namespace App\Http\Controllers\Yonetim;

use Alert;
use App\Exports\HelpsExport;
use App\Exports\HelpsReportExport;
use App\Exports\NeighborhoodsExport;
use App\Exports\NotCompletedExport;
use App\Exports\SameHelpsReportExport;
use App\Exports\SameOneHelpsReportExport;
use App\Http\Controllers\Controller;
use App\Models\HelpType;
use App\Models\Neighborhood;
use Carbon\Carbon;
use Excel;
use Helpers;
use Illuminate\Http\Request;
use Session;

class ReportController extends Controller
{

    public function index(){

        Helpers::sessionMenu('yardim-masasi','raporlar');

        return view('yonetim.reports.reports');
    }

    public function notCompletedHelpsToExcel(Request $request){

        Session::put('excel-help-type-id', $request->excel_help_type); 
        $tarih = Carbon::now();       
        
        Session::put('first_date',$request->first_date);
        Session::put('last_date',$request->last_date);       
        

        $id = Session::get('excel-help-type-id');

        if ($id == 0){
            return Excel::download(new HelpsExport, 'tumliste.xlsx');
        }

        if ($id == 1){
            return Excel::download(new NotCompletedExport, 'cocukbezi.xlsx');
        }

        if ($id == 2){
            return Excel::download(new NotCompletedExport, 'colyak.xlsx');
        }

        if ($id == 3){
            return Excel::download(new NotCompletedExport, 'erzakyardimi.xlsx');
        }

        if ($id == 4){
            return Excel::download(new NotCompletedExport, 'kitap.xlsx');
        }

        if ($id == 5){
            return Excel::download(new NotCompletedExport, 'lkystalepleri.xlsx');
        }

        if ($id == 6){
            return Excel::download(new NotCompletedExport, 'mama.xlsx');
        }

        if ($id == 7){
            return Excel::download(new NotCompletedExport, 'maske.xlsx');
        }

        if ($id == 8){
            return Excel::download(new NotCompletedExport, 'saglikcalisani.xlsx');
        }

        if ($id == 9){
            return Excel::download(new NotCompletedExport, 'sokakhayvanlari.xlsx');
        }

        if ($id == 10){
            return Excel::download(new NotCompletedExport, 'sut.xlsx');
        }

        if ($id == 11){
            return Excel::download(new NotCompletedExport, 'diger.xlsx');
        }

        Alert::error('Hata','İstediğiniz rapor sistemde mevcut değil');
        return redirect()->back();


    }

    public function helpsToExcel(Request $request){

        Session::put('excel-help-type-id', $request->excel_help_type);
        Session::put('neighborhood', $request->neighborhood);
        Session::put('first-date', $request->first_date);
        Session::put('last-date', $request->last_date);
        Session::put('status', $request->status);

        $hid = $request->excel_help_type;
        $nid = $request->neighborhood;
        $sid = $request->status;

        if ($hid == 0 and $nid == 0 and $sid == 0){
            return Excel::download(new NeighborhoodsExport, 'tum-yardimlar.xlsx');
        }

        if ($hid == 0 and $nid == 0 and $sid != 0){
            $statusName = "";
            if ($sid == 1) {
                $statusName = "acik";
            }else {
                $statusName = "kapali";
            }
            return Excel::download(new NeighborhoodsExport, $statusName.'-tum-yardimlar.xlsx');
        }

        if ($hid == 0 and $nid != 0 and $sid == 0){
            $neighborhood = Neighborhood::find($nid);
            $name = $neighborhood->slug;
            return Excel::download(new NeighborhoodsExport, $name.'-tum-yardimlar.xlsx');
        }

        if ($hid == 0 and $nid != 0 and $sid != 0){
            $neighborhood = Neighborhood::find($nid);
            $name = $neighborhood->slug;
            $statusName = "";
            if ($sid == 1) {
                $statusName = "acik";
            }else {
                $statusName = "kapali";
            }
            return Excel::download(new NeighborhoodsExport, $name.'-'.$statusName.'-yardimlar.xlsx');
        }

        if ($hid != 0 and $nid == 0 and $sid == 0){
            $helpType = HelpType::find($hid);
            $helpTypeName = $helpType->slug;
            return Excel::download(new NeighborhoodsExport, $helpTypeName.'-tum-yardimlar.xlsx');
        }

        if ($hid != 0 and $nid == 0 and $sid != 0){
            $helpType = HelpType::find($hid);
            $helpTypeName = $helpType->slug;
            $statusName = "";
            if ($sid == 1) {
                $statusName = "acik";
            }else {
                $statusName = "kapali";
            }
            return Excel::download(new NeighborhoodsExport, $helpTypeName.'-'.$statusName.'-yardimlar.xlsx');
        }

        if ($hid != 0 and $nid != 0 and $sid == 0){
            $helpType = HelpType::find($hid);
            $helpTypeName = $helpType->slug;
            $neighborhood = Neighborhood::find($nid);
            $neighborhoodName = $neighborhood->slug;
            return Excel::download(new NeighborhoodsExport, $neighborhoodName.'-'.$helpTypeName.'-yardimlar.xlsx');
        }

        if ($hid != 0 and $nid != 0 and $sid != 0){
            $helpType = HelpType::find($hid);
            $helpTypeName = $helpType->slug;
            $neighborhood = Neighborhood::find($nid);
            $neighborhoodName = $neighborhood->slug;
            $statusName = "";
            if ($sid == 1) {
                $statusName = "acik";
            }else {
                $statusName = "kapali";
            }
            return Excel::download(new NeighborhoodsExport, $neighborhoodName.'-'.$helpTypeName.'-'.$statusName.'-yardimlar.xlsx');
        }


        Alert::error('Hata','İstediğiniz rapor sistemde mevcut değil');
        return redirect()->back();


    }

    public function createReport(Request $request){

        //dd($request->all());

        if (date('d.m.Y',strtotime($request->first_date)) <= date('d.m.Y',strtotime($request->last_date))){
            Session::put('first_date',$request->first_date);
            Session::put('last_date',$request->last_date);
        }else {
            Session::put('first_date',$request->last_date);
            Session::put('last_date',$request->first_date);
        }

        if (isset($request->allneighborhood) == false){
             if (isset($request->neighborhood) == false){
                 Alert::error('Hata', 'Mahalle seçimi yapmadınız');
                 return redirect()->back()->withInput();
             }
            Session::put('neighborhood',$request->neighborhood);

        }else {
            Session::put('neighborhood',"all");
        }

        if (isset($request->allhelptypes) == false){
            if (isset($request->helptypes) == false){
                Alert::error('Hata', 'Yardım türü seçimi yapmadınız');
                return redirect()->back()->withInput();
            }else {
                Session::put('helptypes',$request->helptypes);
            }
        }else {
            Session::put('helptypes',"all");
        }

        if (isset($request->statuses) == false){
            Alert::error('Hata', 'Durum bilgisi seçmediniz');
            return redirect()->back()->withInput();
        }else {
            if ($request->situation == 1 ){
                Session::put('status',"open");
            }

            if ($request->situation == 2 ){
                Session::put('status',"closed");
            }

            if ($request->situation == 3 ){
                Session::put('status',"all");
            }

            if ($request->situation == 0 ){
                Session::put('status',$request->statuses);
            }
        }


        if ($request->rapor == 1) {
            $today = Carbon::now();

            if ($request->samehelp == 0)
                return Excel::download(new HelpsReportExport(), 'rapor-'. $today->format('d.m.Y-H-i') .'.xlsx');

            if ($request->samehelp == 1)
                return Excel::download(new SameOneHelpsReportExport(), 'birden-fazla-yardim-alanlar-'. $today->format('d.m.Y-H-i') .'.xlsx');

            if ($request->samehelp == 2)
                return Excel::download(new SameHelpsReportExport(), 'ayni-yardimi-birden-fazla-alanlar'. $today->format('d.m.Y-H-i') .'.xlsx');

        }elseif ($request->rapor == 2){
            if ($request->samehelp == 0) {
                return view('yonetim.reports.kisitlamayok')->with([
                    'request' => $request->all()
                ]);
            }

            if ($request->samehelp == 1) {
                return view('yonetim.reports.sameone')->with([
                    'request' => $request->all()
                ]);
            }

            if ($request->samehelp == 2) {
                return view('yonetim.reports.same')->with([
                    'request' => $request->all()
                ]);
            }

        }else {
            Session::forget('first_date');
            Session::forget('last_date');
            Session::forget('neighborhood');
            Session::forget('helptypes');
            Session::forget('status');

            Alert::error('Hata', 'Rapor oluşturulamadı.');
            return redirect()->back()->withInput();
        }


    }

    public function createStatistic($request){


        return view('yonetim.reports.statistic');

    }

}
