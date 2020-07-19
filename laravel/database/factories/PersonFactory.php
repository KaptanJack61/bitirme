<?php

use App\Models\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    $first_name = $faker->firstName;
    $last_name = $faker->lastName;
    return [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'person_slug' => str_slug($first_name." ".$last_name),
        'tc_no' => rand(9999999999,100000000000),
        'phone' => rand(5000000000,5619999999),
        'email' => $faker->safeEmail,
        'neighborhood_id' => rand(1,24),
        'street' => $faker->streetName,
        'city_name' => $faker->streetName,
        'gate_no' => rand(1,150),
    ];
});
