<?php

use App\Models\Demand;
use Illuminate\Database\Seeder;

class DemandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table demands');
        factory(Demand::class,70)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
