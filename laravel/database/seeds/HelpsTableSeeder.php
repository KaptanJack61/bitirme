<?php

use App\Models\Demand;
use App\Models\DemandHelp;
use App\Models\Help;
use App\Models\Person;
use Illuminate\Database\Seeder;

class HelpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table helps');
        DB::statement('truncate table demands');
        DB::statement('truncate table demand_help');

        for ($i = 0; $i < 210; $i++) {
            $help = new Help;
            $help->help_types_id = rand(1,11);
            $help->quantity = rand(1,40);
            $help->status_id = rand(1,3);
            $help->save();
        }

        for ($i = 0; $i <=104 ; $i++) {
            $demand = new Demand;
            $demand->person_id = ($i % 35) + 1;
            $demand->save();
        }

        $d = 1;

        for ($i=1; $i<=210; $i++) {
            $demand_help = new DemandHelp;
            $demand_help->demand_id = $d;
            $demand_help->help_id = $i;
            $demand_help->save();

            if ($i % 2 == 0) {
                $d++;
            }

        }




        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
