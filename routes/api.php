<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostAPIController;
use App\Http\Controllers\RabbitMQController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/storeAPI', [PostAPIController::class, 'storeAPI']);
Route::get('/searchPostAPI/{search}', [PostAPIController::class, 'searchPostAPI']);


Route::post('/rabbit/send', [RabbitMQController::class, 'send']);
