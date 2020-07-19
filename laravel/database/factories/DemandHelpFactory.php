<?php

use App\Models\DemandHelp;
use Faker\Generator as Faker;

$factory->define(DemandHelp::class, function (Faker $faker) {
    return [
        'demand_id' => rand(1,70),
        'help_id' => rand(1,210)
    ];
});
