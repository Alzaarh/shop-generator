<?php

use Josh\Faker\Faker;

$factory->define(App\Models\Category::class, function (\Faker\Generator $faker) {

    return [
        'title' => Faker::firstName(),

        'parent_id' => rand(1, 10) % 2 == 0 ? $faker->numberBetween(1, 50) : null,

        'details' => rand(1, 10) % 2 == 0 ? json_encode(['description' => $faker->sentence]) : null,
    ];
});

$factory->afterCreating(App\Models\Category::class, function ($category) {

    if($category->id == $category->parent_id)
    {
        $category->parent_id = null;
    }

    return $category;
});
