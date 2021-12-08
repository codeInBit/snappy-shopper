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

Route::resource('properties', PropertyController::class);
Route::post('link-properties', [\App\Http\Controllers\AgentController::class, 'linkProperties']);
Route::post('delink-properties', [\App\Http\Controllers\AgentController::class, 'deLinkProperties']);
Route::resource('agents', AgentController::class);
