<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'username' => $faker->userName,
        'slug' => Str::slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make("12345"),
        'detail' => "Deneme detail",
        'photo' => "/img/avatar04.png",
        'active' => 1,
        'admin' =>1,
        'remember_token' => str_random(10),
    ];
});
