<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post("v1/login", 'App\Http\Controllers\AuthController@login');
Route::post("v1/torneo", 'App\Http\Controllers\TorneoController@Torneo')->middleware('auth');
Route::get("v1/torneos", 'App\Http\Controllers\TorneoController@getTorneos')->middleware('auth');
Route::get("v1/torneo/{id}", 'App\Http\Controllers\TorneoController@getTorneo')->middleware('auth');;
Route::get("v1/torneo/{id}/winner", 'App\Http\Controllers\TorneoController@getWinner')->middleware('auth');
Route::get("v1/torneo/{id}/players", 'App\Http\Controllers\TorneoController@getPlayers')->middleware('auth');
Route::get("v1/torneo/{id}/matchs", 'App\Http\Controllers\TorneoController@getMatchs')->middleware('auth');

