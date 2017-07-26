<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Agency::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->randomElement(['ATC', 'GEO', 'CT', 'IT', 'GE3']),
        ];
});
