<?php

use App\Models\Help;
use Faker\Generator as Faker;

$factory->define(Help::class, function (Faker $faker) {

    return [
        'help_types_id' => rand(1,10),
        'person_id' => rand(1,70),
        'status_id' => rand(1,3),
        'quantity' => rand(1,150)
    ];
});
