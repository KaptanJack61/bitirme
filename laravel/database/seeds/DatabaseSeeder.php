<?php


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(NeighborhoodsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(HelpTypesTableSeeder::class);
        $this->call(HelpsTableSeeder::class);
        $this->call(DemandsTableSeeder::class);
        $this->call(PersonTableSeeder::class);
        $this->call(DemandHelpTableSeeder::class);

    }
}
