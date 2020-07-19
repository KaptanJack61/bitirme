<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('truncate table users');

        $user = new User;
        $user->name = "Hamdi Kalaycı";
        $user->username = "h.kalayci";
        $user->slug = Str::slug($user->name);
        $user->email = "hamdikalayci@gmail.com";
        $user->photo = "/dosya-yoneticisi/fotograflar/kaptan-jack-sparrow/20190513_011459.jpg";
        $user->password = Hash::make("426340061");
        $user->detail = "Deneme özgeçmişi";
        $user->active = 1;
        $user->admin = 1;
        $user->save();


        factory(User::class, 10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
