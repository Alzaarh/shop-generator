<?php

use Illuminate\Support\Facades\Hash;
use Josh\Faker\Faker;

$factory->define(App\Models\User::class, function (\Faker\Generator $faker) {

    $profilePictures = [
        'img-1.jpg',
        'img-2.jpg',
        'img-3.jpg',
        'img-4.jpg',
        'img-5.jpg',
    ];

    return [

        'first_name' => Faker::firstname(),

        'last_name' => Faker::lastname(),

        'email' => $faker->unique()->safeEmail,

        'username' => $faker->userName,

        'password' => Hash::make('12345'),

        'phone' => Faker::mobile(),

        'profile_picture' => $faker->randomElement($profilePictures),
    ];
});
