<?php

use Illuminate\Http\Request;

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

Route::get('cidadao','CidadaoController@index');
Route::get('cidadao/{cpf}','CidadaoController@show');
Route::post('cidadao', 'CidadaoController@store');
Route::post('cidadao/{cpf?}', 'CidadaoController@store');
Route::delete('cidadao/{cpf}','CidadaoController@delete');