<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/settings', 'HomeController@settings')->name('settings');
//Booking
Route::get('/bookings', 'BookingController@all')->name('bookings');
Route::post('/bookings', 'BookingController@create')->name('create_booking');
Route::put('/bookings/{service}', 'BookingController@update')->name('update_booking');
//Routes
Route::get('/routes', 'RouteController@all')->name('routes');
Route::post('/routes', 'RouteController@create')->name('create_route');
Route::put('/routes/{route}', 'RouteController@update')->name('update_route');
//Vehicles
Route::get('/vehicles', 'VehicleController@all')->name('vehicles');
Route::post('/vehicles', 'VehicleController@create')->name('create_vehicle');
Route::put('/vehicles/{vehicle}', 'VehicleController@update')->name('update_vehicle');
//Agencies
Route::get('/agencies', 'AgencyController@all')->name('agencies');
Route::post('/agencies', 'AgencyController@create')->name('create_agency');
Route::put('/agencies/{agency}', 'AgencyController@update')->name('update_agency');
//Chauffeurs
Route::get('/chauffeurs', 'ChauffeurController@all')->name('chauffeurs');
Route::post('/chauffeurs', 'ChauffeurController@create')->name('create_chauffeur');
Route::put('/chauffeurs/{chauffeur}', 'ChauffeurController@update')->name('update_chauffeur');
//Type Trip
Route::get('/types_trip', 'TypeTripController@all')->name('types_trip');
Route::post('/types_trip', 'TypeTripController@create')->name('create_type_trip');
Route::put('/types_trip/{type_trip}', 'TypeTripController@update')->name('update_type_trip');