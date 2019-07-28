<?php

use Josh\Faker\Faker;

$factory->define(App\Models\Attribute::class, function (\Faker\Generator $faker) {

    return [
        'title' => Faker::firstName(),

        'value' => Faker::lastName(),

        'unit' => rand(1, 10) % 2 == 0 ? Faker::firstName() : null,
    ];
});