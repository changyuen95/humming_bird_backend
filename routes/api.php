<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\TourController;
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

    Route::get('/tours', [TourController::class, 'getTours']); // Get a list of tours
    Route::get('/tours/{id}', [TourController::class, 'getTourDetails']); // Get tour details by ID




