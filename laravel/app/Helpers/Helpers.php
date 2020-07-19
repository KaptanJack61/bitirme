<?php

namespace App\Helpers;

use Alert;
use App\Models\Demand;
use App\Models\Help;
use App\Models\HelpType;
use App\Models\Neighborhood;
use App\Models\Status;
use DateTime;
use Session;
use URL;

class Helpers{

    public static function convertToIntPhone($phone)
    {
        $rules = array("(", ")", " ");
        return (int)str_replace($rules, "", $phone);
    }

    public static function phoneTextFormat($phone)
    {
        $sablon = '/^(\d{3})(\d{3})(\d{4}).*/';
        $yenisi = '($1) $2 $3';
        return preg_replace($sablon, $yenisi, $phone);
    }

    public static function getDemandsDetails($id)
    {
        $demand = Demand::find($id);
        $helpList = json_decode($demand->helps);
        if ($helpList!=null){
            $helpId = (int)$helpList[0];

            $help = Help::find($helpId);
            $help->select('first_name','last_name','neighborhood_id','street','city_name','gate_no');

            $detail = [
                'full_name' => $help->full_name,
                'address' => $help->address
            ];

            return $detail;
        }


    }

    public static function sessionMenu($open,$active){
        Session::put('menu_aktif', $active);
        Session::put('menu_acilma', $open);
    }

    public static function getHelpTypes(){
        $hqb = HelpType::query();
        $hqb->select('id','name','slug','metrik');
        $help = $hqb->get();

        return $help;

    }

    public static function getShowHelp($id){
        $help = Help::find($id);
        return $help;

    }

    public static function getShowHelpTypeProperties($property,$column){
        $helpType = HelpType::where($column,$property)->get();
        return $helpType;

    }

    public static function getNeighborhoods(){
        $nqb = Neighborhood::query();
        $nqb->select('id','name','slug');
        $neighborhood = $nqb->get();

        return $neighborhood;

    }

    public static function getStatus(){
        $status = Status::all();
        return $status;
    }

    public static function controlBackPreviousUrl($s1) {

        $segments = explode('/', url()->previous());
        if ($segments[3] != $s1){
                Alert::error('Hata',"Bu sayfada silme işlemi yapamazsınız!");
                return false;
        }else {
            return true;
        }
    }

    public static function activity($logName,$message){
        activity($logName)
            ->causedBy(auth()->guard('yonetim')->user())
            ->log(auth()->guard('yonetim')->user()->name." ".$message);
    }

    public static function is_date($str)
    {
        $format = "d.m.Y";
        $is_date = false;
        $date = DateTime::createFromFormat($format, $str);

        if ($date!==false && $date->format($format)===$str)
        {
            $is_date = true;
        }

        return $is_date;
    }

    public static function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    public static function random_color() {
        return  "#".self::random_color_part() . self::random_color_part() . self::random_color_part();
    }
}
