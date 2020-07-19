<?php

use App\Models\Help;
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
        factory(Help::class,210)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
