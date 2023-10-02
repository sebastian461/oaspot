<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Authenticate */
Route::post('login', [AuthController::class, 'login']);

/* Middleware */
Route::middleware(['auth:sanctum'])->group(function () {
  /* Authenticate */
  Route::post('logout', [AuthController::class, 'logout']);

  /* Parking */
  Route::get('parking', [ParkingController::class, 'index']);
});
