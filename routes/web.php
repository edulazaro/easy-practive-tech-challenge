<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'clients'], function () {
    Route::get('/', 'ClientsController@index')->name('clients.index');
    Route::get('/create', 'ClientsController@create')->name('clients.create');
    Route::get('/{client}', 'ClientsController@show')->name('clients.show');
});

Route::group(['middleware' => ['auth', 'json'], 'prefix' => 'data'], function () {

    Route::post('/clients', 'Data\ClientsDataController@store')->name('data.clients.store');
    Route::delete('/clients/{client}', 'Data\ClientsDataController@destroy')->name('data.clients.destroy');

    Route::delete('/journals/{journal}', 'Data\JournalsDataController@destroy')->name('data.journals.destroy');
    Route::delete('/bookings/{booking}', 'Data\BookingsDataController@destroy')->name('data.bookings.destroy');

    Route::get('/clients/{client}/bookings', 'Data\Client\ClientBookingsDataController@index')
        ->name('data.clients.bookings.index');

    Route::get('/clients/{client}/journals', 'Data\Client\ClientJournalsDataController@index')
        ->name('data.clients.journals.index');

    Route::post('/clients/{client}/journals', 'Data\Client\ClientJournalsDataController@store')
        ->name('data.clients.journals.store');

});
