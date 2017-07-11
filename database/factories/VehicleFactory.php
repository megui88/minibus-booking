<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Vehicle::class, function (Faker\Generator $faker) {

    $chauffeur = factory(\App\Chauffeur::class)->create();
    return [
        'name' => $faker->companySuffix,
        'chauffeur_id' => $chauffeur->id,
    ];
});
