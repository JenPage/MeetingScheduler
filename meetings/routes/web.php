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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/event', function(){
    $facade = EventClass::createEvent('test facade');
    echo $facade;
});
Route::get('/testMessage', 'HomeController@testMessage');

Route::get('/testOtherMessage', 'HomeController@testOtherMessage');


// API route group that we need to protect
Route::group(['prefix' => 'api', 'middleware' => ['ability:admin,create-users']], function()
{
    //The regsiter and login routes for the api
    Auth::routes();
    // Protected route
    Route::get('users', 'JwtAuthenticateController@index');
    // Route to create a new role
    Route::post('role', 'JwtAuthenticateController@createRole');
// Route to create a new permission
    Route::post('permission', 'JwtAuthenticateController@createPermission');
// Route to assign role to user
    Route::post('assign-role', 'JwtAuthenticateController@assignRole');
// Route to attache permission to a role
    Route::post('attach-permission', 'JwtAuthenticateController@attachPermission');
    Route::post('authenticate', 'JwtAuthenticateController@authenticate');
});

//The Register and login routes for the website
Auth::routes();
