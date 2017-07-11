<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\TypeTrip::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->randomElement(['micro', 'mini', 'chico', 'mediano', 'grande']),
        'number_passengers' => $faker->numberBetween(1,19),
    ];
});
