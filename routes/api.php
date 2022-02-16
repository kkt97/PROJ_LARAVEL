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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
],  function ($router) {
    Route::post('/login/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::get('/loginCheck', [\App\Http\Controllers\Auth\AuthController::class, 'loginCheck']);
});



Route::get('/board/search', [App\Http\Controllers\Board\BoardsController::class, 'search']);
Route::post('/board/{id}', [App\Http\Controllers\Board\BoardsController::class, 'upload']);


Route::apiResources([
    '/register' => \App\Http\Controllers\Auth\RegisterController::class,
    '/board' => \App\Http\Controllers\Board\BoardsController::class,
    '/booking' => \App\Http\Controllers\Booking\BookingController::class,
]);



//DB::listen(function($query) { \Illuminate\Support\Facades\Log::info($query->sql); });
//DB::listen(function($query) { dump($query->sql); });
