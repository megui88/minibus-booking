<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Route::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->randomElement(['city', 'zoo', 'tigre', 'lujan', 'La plata']),
    ];
});
