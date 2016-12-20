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

use Illuminate\Support\Facades\DB;


Route::get('hello', function () {
    return view('welcome');
});

//user routes

Route::post('signUp', [
    'uses' => 'user_Controller@signUp',
    'as' => 'signUp']
);

Route::post('update_first_name',[
    'uses' =>'user_Controller@update_first_name',
    'as' => 'update_first_name']
);

Route::post('update_last_name',[
        'uses' =>'user_Controller@update_last_name',
        'as' => 'update_last_name']
);

Route::post('update_password',[
        'uses' =>'user_Controller@update_password',
        'as' => 'update_password']
);

//disease routes

Route::post('add_disease',[
        'uses' =>'Disease_Controller@add_disease',
        'as' => 'add_disease']
);

Route::post('update_disease',[
        'uses' =>'Disease_Controller@update_disease',
        'as' => 'update_disease']
);

//report routes

Route::get('get_disease_details',[
        'uses' => 'Report_Controller@get_disease_details',
        'as' => 'get_disease_details']
);

Route::get('get_location_diseases',[
        'uses' => 'Report_Controller@get_location_diseases',
        'as' => 'get_location_diseases']
);


