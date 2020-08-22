<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Help;
use App\Models\HelpType;
use Carbon\Carbon;
use Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class StatisticController extends Controller
{


    public function index(){
        Helpers::sessionMenu('raporlar-i̇statistikler','istatistik');

        return view('yonetim.statistic.statistic');
    }

    public function neighborhoodPie(){

        $labels = [];
        $data1 = [];
        $bg = [];

        $q = Help::query();
        $q->join('statuses','helps.status_id','statuses.id');
        $q->where('statuses.finisher','=',true);
        $sumHelps = $q->count();

        $neighborhood = Helpers::getNeighborhoods();

        foreach ($neighborhood as $n) {

            $q = Help::query();
            $q->join('statuses','helps.status_id','statuses.id');
            $q->join('demand_help','demand_help.help_id','helps.id');
            $q->join('demands','demands.id','demand_help.demand_id');
            $q->join('people','people.id','demands.person_id');
            $q->join('neighborhoods','neighborhoods.id','people.neighborhood_id');
            $q->where('statuses.finisher','=',true);
            $q->where('people.neighborhood_id','=',$n->id);


            $toplam = $q->count();
            $yuzde = $toplam * 100 / $sumHelps;
            array_push($data1,$toplam);
            array_push($bg,Helpers::random_color());
            array_push($labels,$n->name." - ".round($yuzde,1)."%");

        }


        $data = [
            "label" => "Mahalle Dağılımı ( Toplam: ".$sumHelps." )",
            "data" => $data1,
            "backgroundColor" => $bg,
        ];

        $response = [
            "labels" => $labels,
            "datasets" => [$data]
        ];

        return Response::json($response);
    }

    public function neighborhoodBar(){

        $labels = [];
        $data1 = [];

        $q = Help::query();
        $q->join('statuses','helps.status_id','statuses.id');
        $q->where('statuses.finisher','=',true);
        $sumHelps = $q->count();

        $neighborhood = Helpers::getNeighborhoods();

        foreach ($neighborhood as $n) {
            $q = Help::query();
            $q->join('statuses','helps.status_id','statuses.id');
            $q->join('demand_help','demand_help.help_id','helps.id');
            $q->join('demands','demands.id','demand_help.demand_id');
            $q->join('people','people.id','demands.person_id');
            $q->where('statuses.finisher','=',true);
            $q->where('peoples.neighborhood_id','=',$n->id);

            $toplam = $q->count();
            $yuzde = $toplam * 100 / $sumHelps;
            array_push($data1,$toplam);
            array_push($labels,$n->name." - ".(int)$yuzde."%");

        }


        $data = [
            "label" => "Mahalleler",
            "data" => $data1,
            "backgroundColor" => "rgba(60,141,188,0.9)",
        ];

        $deneme = [
            "labels" => $labels,
            "datasets" => [$data]
        ];

        return Response::json($deneme);
    }

    public function helpTypeBar(){

        $labels = [];
        $data1 = [];

        $q = Help::query();
        $q->join('statuses','helps.status_id','statuses.id');
        $q->where('statuses.finisher','=',true);
        $sumHelps = $q->count();

        $helpTypes = Helpers::getHelpTypes();

        foreach ($helpTypes as $h) {
            $q = Help::query();
            $q->join('statuses','helps.status_id','statuses.id');
            $q->where('statuses.finisher','=',true);
            $q->where('helps.help_types_id','=',$h->id);

            $toplam = $q->count();
            $yuzde = $toplam * 100 / $sumHelps;
            array_push($data1,$toplam);
            array_push($labels,$h->name." - ".(int)$yuzde."%");

        }


        $data = [
            "label" => "",
            "data" => $data1,
            "backgroundColor" => "rgba(60,141,188,0.9)",
        ];

        $response = [
            "labels" => $labels,
            "datasets" => [$data]
        ];

        return Response::json($response);
    }

    public function helpTypeCycle(){

        $labels = [];
        $data1 = [];
        $bg = [];

        $q = Help::query();
        $q->join('statuses','helps.status_id','statuses.id');
        $q->where('statuses.finisher','=',true);
        $sumHelps = $q->count();

        $helpTypes = Helpers::getHelpTypes();

        foreach ($helpTypes as $h) {
            $q = Help::query();
            $q->join('statuses','helps.status_id','statuses.id');
            $q->where('statuses.finisher','=',true);
            $q->where('helps.help_types_id','=',$h->id);

            $toplam = $q->count();
            $yuzde = $toplam * 100 / $sumHelps;
            array_push($data1,$toplam);
            array_push($bg,Helpers::random_color());
            array_push($labels,$h->name." - ".(int)$yuzde."%");

        }


        $data = [
            "label" => " Yardım Türleri Dağılımı",
            "data" => $data1,
            "backgroundColor" => $bg,
        ];

        $deneme = [
            "labels" => $labels,
            "datasets" => [$data]
        ];

        return Response::json($deneme);
    }

    public function dailyLine(){
        $labels = [];
        $data1 = [];

        $bugun = date("d.m.Y");

        for ($x = -0;$x > -30;$x--){
            $date = date('d.m.Y',strtotime($x.' day',strtotime($bugun)));
            $q = Help::query();
            $q->whereBetween('created_at', [
                Carbon::createFromFormat('d.m.Y H:i:s',$date."00:00:00"),
                Carbon::createFromFormat('d.m.Y H:i:s',$date."23:59:59")
            ]);

            array_push($data1,$q->count());
            array_push($labels,$date);
        }


        $labelsReverse = array_reverse($labels);
        $dataReverse = array_reverse($data1);


        $data = [
            "label" => "Günlük Değişim",
            "backgroundColor" => 'rgba(60,141,188,0.9)',
            "borderColor" => 'rgba(60,141,188,0.8)',
            "pointRadius" => '6',
            "pointColor" => '#3b8bba',
            "pointStrokeColor" => 'rgba(60,141,188,1)',
            "pointHighlightFill" => '#fff',
            "pointHighlightStroke" => 'rgba(60,141,188,1)',
            "data" => $dataReverse,
        ];

        $response = [
            "labels" => $labelsReverse,
            "datasets" => [$data]
        ];

        return Response::json($response);
    }


    public function customize(Request $request){
        $labels = [];
        $data1 = [];

        $neighborhood = Helpers::getNeighborhoods();

        $hq = HelpType::query();
        $hq->whereIn('id',$request->helptypes);
        $hq->select('id','name');
        $hq->orderBy('name');

        $helpTypes = $hq->get();

        $data = [];

        foreach ($helpTypes as $h) {
            $labels = [];
            foreach ($neighborhood as $n) {

                $q = Help::query();
                $q->join('demand_help','demand_help.help_id','helps.id');
                $q->join('demands','demands.id','demand_help.demand_id');
                $q->join('people','people.id','demands.person_id');
                $q->where('people.neighborhood_id','=',$n->id);
                $q->where('helps.help_types_id','=', $h->id);

                $toplam = $q->count();

                array_push($data1, $toplam);
                array_push($labels, $n->name);

            }

            $d = [
                "label" => $h->name,
                "data" => $data1,
                "backgroundColor" => Helpers::random_color(),
            ];
            array_push($data, $d);
            $data1 = [];

        }

        $response = [
            "labels" => $labels,
            "datasets" => $data
        ];

        return Response::json($response);
    }


    public function customizeDaily(Request $request){

        $labels = [];
        $data1 = [];

        $bugun = date("d.m.Y");

        $hq = HelpType::query();
        $hq->whereIn('id',$request->helptypes);
        $hq->select('id','name');
        $hq->orderBy('name');

        $helpTypes = $hq->get();

        $data = [];

        foreach ($helpTypes as $h) {
            $labels = [];
            for ($x = 0;$x > -30;$x--){
                $date = date('d.m.Y',strtotime($x.' day',strtotime($bugun)));
                $q = Help::query();
                $q->where('help_types_id','=',$h->id);
                $q->whereBetween('created_at', [
                    Carbon::createFromFormat('d.m.Y H:i:s',$date."00:00:00"),
                    Carbon::createFromFormat('d.m.Y H:i:s',$date."23:59:59")
                ]);

                array_push($data1,$q->count());
                array_push($labels,$date);
            }

            $color = Helpers::random_color();
            $dataReverse = array_reverse($data1);

            $d = [
                "label" => $h->name,
                "backgroundColor" => $color,
                "borderColor" => $color,
                "pointRadius" => '6',
                "pointColor" => $color,
                "pointStrokeColor" => $color,
                "pointHighlightFill" => '#fff',
                "pointHighlightStroke" => $color,
                "data" => $dataReverse,
            ];

            array_push($data, $d);
            $data1 = [];

        }


        $labelsReverse = array_reverse($labels);

        $response = [
            "labels" => $labelsReverse,
            "datasets" => $data
        ];

        return Response::json($response);

    }

    public function customizeHelpType(Request $request){
        $labels = [];
        $data1 = [];
        $bg = [];
        $customLabels = [];

        $q = Help::query();
        $sumHelps = $q->count();

        $hq = HelpType::query();
        $hq->select('id','name');
        $hq->whereIn('id',$request->helptypes);
        $helpTypes = $hq->get();
        $htoplam = 0;

        foreach ($helpTypes as $h) {
            $q = Help::query();
            $q->where('help_types_id','=',$h->id);

            $toplam = $q->count();
            $htoplam = $htoplam + $toplam;
            $yuzde = $toplam * 100 / $sumHelps;
            array_push($data1,$toplam);
            array_push($bg,Helpers::random_color());
            array_push($labels,$h->name." - ".(int)$yuzde."%");
            array_push($customLabels,$h->name);

        }

        $data = [
            "label" => " Yardım Türleri Dağılımı",
            "data" => $data1,
            "backgroundColor" => $bg,
        ];

        $response = [
            "labels" => $labels,
            "datasets" => [$data],
            "customTitle" => "Toplam: ".$sumHelps." - Seçili Toplam: ".$htoplam,
            "customLabel" => $customLabels
        ];

        return Response::json($response);
    }


    public function dashboardShowSumMask(){
        $labels = [];
        $data1 = [];

        $bugun = date("d.m.Y");

        for ($x = 0;$x > -30;$x--){
            $date = date('d.m.Y',strtotime($x.' day',strtotime($bugun)));
            $q = Help::query();
            $q->where('help_types_id','=',7);
            $q->whereBetween('created_at', [
                Carbon::createFromFormat('d.m.Y H:i:s',$date."00:00:00"),
                Carbon::createFromFormat('d.m.Y H:i:s',$date."23:59:59")
            ]);

            array_push($data1,$q->sum('quantity'));
            array_push($labels,$date);
        }


        $labelsReverse = array_reverse($labels);
        $dataReverse = array_reverse($data1);


        $data = [
            "backgroundColor" => 'rgba(60,141,188,0.9)',
            "borderColor" => 'rgba(60,141,188,0.8)',
            "pointRadius" => '6',
            "pointColor" => '#3b8bba',
            "pointStrokeColor" => 'rgba(60,141,188,1)',
            "pointHighlightFill" => '#fff',
            "pointHighlightStroke" => 'rgba(60,141,188,1)',
            "data" => $dataReverse,
        ];

        $response = [
            "labels" => $labelsReverse,
            "datasets" => [$data]
        ];

        return Response::json($response);
    }

    public function dashboardShowSumFood(){
        $labels = [];
        $data1 = [];

        $bugun = date("d.m.Y");

        for ($x = 0;$x > -30;$x--){
            $date = date('d.m.Y',strtotime($x.' day',strtotime($bugun)));
            $q = Help::query();
            $q->where('help_types_id','=',3);
            $q->whereBetween('created_at', [
                Carbon::createFromFormat('d.m.Y H:i:s',$date."00:00:00"),
                Carbon::createFromFormat('d.m.Y H:i:s',$date."23:59:59")
            ]);

            array_push($data1,$q->sum('quantity'));
            array_push($labels,$date);
        }


        $labelsReverse = array_reverse($labels);
        $dataReverse = array_reverse($data1);


        $data = [
            "backgroundColor" => 'rgba(60,141,188,0.9)',
            "borderColor" => 'rgba(60,141,188,0.8)',
            "pointRadius" => '6',
            "pointColor" => '#3b8bba',
            "pointStrokeColor" => 'rgba(60,141,188,1)',
            "pointHighlightFill" => '#fff',
            "pointHighlightStroke" => 'rgba(60,141,188,1)',
            "data" => $dataReverse,
        ];

        $response = [
            "labels" => $labelsReverse,
            "datasets" => [$data]
        ];

        return Response::json($response);
    }



}
