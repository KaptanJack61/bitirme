<?php

use App\Models\DemandHelp;
use Illuminate\Database\Seeder;

class DemandHelpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table demand_help');
        factory(DemandHelp::class,70)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
