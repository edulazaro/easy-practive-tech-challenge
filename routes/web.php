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
    Route::get('/create', 'ClientsController@create');
    Route::post('/', 'ClientsController@store');
    Route::get('/{client}', 'ClientsController@show');

    Route::get('/{client}/journals', 'JournalsController@index');
    Route::post('/{client}/journals', 'JournalsController@store');
    Route::delete('/{client}/journals/{journal}', 'JournalsController@destroy');
});


Route::group(['middleware' => ['auth', 'json'], 'prefix' => 'data'], function () {

    Route::delete('/{client}', 'Data\ClientsDataController@destroy')->name('data.clients.destroy');

    Route::get('/clients/{client}/bookings', 'Data\Client\ClientBookingsDataController@index')
        ->name('data.clients.bookings.index');

        
    Route::get('/clients/{client}/journals', 'Data\Client\ClientJournalsDataController@index')
    ->name('data.clients.journals.index');

    Route::post('/clients/{client}/journals', 'Data\Client\ClientJournalsDataController@store')
        ->name('data.clients.journals.store');

    Route::delete('/journals/{journal}', 'JSON\JournalsDataController@destroy')->name('data.journals.destroy');
});
