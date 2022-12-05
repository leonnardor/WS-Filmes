<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\PassportAuthController;
use App\Http\Controllers\Api\v1\PessoaController;
use App\Http\Controllers\Api\v1\TelefonePessoaController;
use App\Http\Controllers\Api\v1\EmailPessoaController;
use App\Http\Controllers\Api\v1\EnderecoPessoaController;


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


// rotas de cadastro de pessoas e login sem autenticação
Route::post('registrar', [PassportAuthController::class, 'cadastrar']);
Route::post('login', [PassportAuthController::class, 'login']);





// rotas com autenticação 
Route::group(['middleware' => 'auth:api'], function(){
  
    Route::get('/pessoas', 'App\Http\Controllers\Api\v1\PessoaController@index');
Route::post('/pessoas', 'App\Http\Controllers\Api\v1\PessoaController@store');
Route::get('/pessoas/{id}', 'App\Http\Controllers\Api\v1\PessoaController@show');
Route::put('/pessoas/{id}', 'App\Http\Controllers\Api\v1\PessoaController@update');
Route::delete('/pessoas/{id}', 'App\Http\Controllers\Api\v1\PessoaController@destroy');

    Route::get('/telefones', 'App\Http\Controllers\Api\v1\TelefonePessoaController@index');
    Route::post('/telefones', 'App\Http\Controllers\Api\v1\TelefonePessoaController@store');
    Route::get('/telefones/{id}', 'App\Http\Controllers\Api\v1\TelefonePessoaController@show');
    Route::put('/telefones/{id}', 'App\Http\Controllers\Api\v1\TelefonePessoaController@update');
    Route::delete('/telefones/{id}', 'App\Http\Controllers\Api\v1\TelefonePessoaController@destroy');

    Route::get('/emails', 'App\Http\Controllers\Api\v1\EmailPessoaController@index');
    Route::post('/emails', 'App\Http\Controllers\Api\v1\EmailPessoaController@store');
    Route::get('/emails/{id}', 'App\Http\Controllers\Api\v1\EmailPessoaController@show');
    Route::put('/emails/{id}', 'App\Http\Controllers\Api\v1\EmailPessoaController@update');
    Route::delete('/emails/{id}', 'App\Http\Controllers\Api\v1\EmailPessoaController@destroy');

    Route::get('/user', 'App\Http\Controllers\Api\v1\PassportAuthController@user');
    Route::get('/logout', 'App\Http\Controllers\Api\v1\PassportAuthController@logout');
});




