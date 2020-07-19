<?php

use App\Models\Demand;
use Faker\Generator as Faker;

$factory->define(Demand::class, function (Faker $faker) {

    return [
        'person_id' => rand(1,70)
    ];
});
