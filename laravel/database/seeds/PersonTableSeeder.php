<?php

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table people');
        factory(Person::class,70)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
