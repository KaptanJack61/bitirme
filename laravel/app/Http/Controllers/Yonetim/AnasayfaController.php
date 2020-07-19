<?php

namespace App\Http\Controllers\Yonetim;


use App\Helpers\Helpers;
use App\Models\Demand;
use App\Models\DemandHelp;
use App\Models\Help;
use App\Models\Person;
use App\Models\Status;
use DB;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AnasayfaController extends Controller
{
    public function index()
    {
        /*
        $person = Person::findOrFail(61);

        foreach ($person->demands as $p) {
            dd($p->helps);
        }

        dd($person->demands);

        $person = Person::findOrFail(2);

        $demand = Demand::findOrFail(34);

        $demandhelp = DemandHelp::findOrFail(1);

        dd($demandhelp->help->type->name);

        //dd($person->demands);

        foreach ($help->demand as $demand) {
            dd($demand->person);
        }

        $helps = [];

        for ($x = 0;$x < 4;$x++) {
            $help = new Help;
            $help->help_types_id = 3;
            $help->status_id = 1;
            $help->quantity = 100;
            $help->save();

            array_push($helps, $help->id);
        }

        //dd($helps);



        $demand = new Demand;
        $demand->person_id = 1;
        $demand->save();

        $demand->helps()->attach($helps);

        /*

        $help = Help::findOrFail(216);
        $demand = Demand::findOrFail($help->demand->demand_id);

        $demand->helps()->detach($help);

        dd($demand);

        dd($demand->helps);

        */



        $helps = Help::all();
        $help = $helps->count();
        $person = $helps
            ->groupBy('person_slug')
            ->count();

        $maskeSayisi = DB::table('helps')
            ->where('help_types_id','=','7')
            ->sum('quantity');

        $statuses = Status::all();
        $bts = DB::table('helps');
            foreach ($statuses as $s){
                if ($s->finisher == false){
                    $bts->orWhere('status_id','=',$s->id);
                }
            }

        $bekleyenTalep = $bts->count();

        Session::put('menu_aktif', 'anasayfa');
        Session::put('menu_acilma', 'anasayfa');
        return view('yonetim.anasayfa')->with([
            'helps' => $help,
            'people' => $person,
            'maskeSayisi' => $maskeSayisi,
            'bekleyenTalep' => $bekleyenTalep,
        ]);
    }

    public function yetkisizErisim(){
        return view('errors.401');
    }
}