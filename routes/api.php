<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:airlock')->get('/user', function (Request $request) {
    return $request->user();
});





//login user
Route::post('/login', 'API\UserController@login');

//post product
Route::post('/products/create', 'API\ProductsController@store');
//delete product
Route::delete('/products/{id}', 'API\ProductsController@destroy');
//update product
Route::put('/products/{id}', 'API\ProductsController@update');
//get all product
Route::get('/products', 'API\ProductsController@index');

Route::group(['middleware' => 'auth:airlock'], function(){
    //logout user
    Route::delete('/logout', 'API\UserController@logout');
});


