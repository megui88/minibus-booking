<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Chauffeur::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
    ];
});
