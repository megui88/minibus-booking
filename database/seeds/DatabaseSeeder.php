<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Agency::class, 5)->create();
        factory(App\Route::class, 4)->create();
        factory(App\TypeTrip::class, 3)->create();
        factory(App\Vehicle::class, 7)->create();
        factory(App\User::class,1)->create([
            'name' => 'Homero',
            'email' => 'homero@minibus.lo',
            'password' => 'homero',
            'remember_token' => str_random(10),
        ]);
    }
}
