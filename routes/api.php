<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CommuneController;
use App\Http\Controllers\api\QuartierController;
use App\Http\Controllers\Api\users\UserController;
use App\Http\Controllers\api\DepartementController;
use App\Http\Controllers\api\ArrondissementController;

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

Route::prefix('departements')->group(function () {
    Route::get('/', [DepartementController::class, 'index']);
    Route::get('/{departementName}/communes', [DepartementController::class, 'getCommunes']);
    Route::get('/{departementName}/details', [DepartementController::class, 'getDepartementWithDetails']);
    Route::get('details', [DepartementController::class, 'getAllDepartementsWithDetails']);
});

Route::prefix('communes')->group(function () {
    Route::get('/', [CommuneController::class, 'index']);
    Route::get('/{communeName}/arrondissements', [CommuneController::class, 'getArrondissements']);
    Route::get('/{communeName}/details', [CommuneController::class, 'getCommuneWithDetails']);
    Route::get('details', [CommuneController::class, 'getAllCommunesWithDetails']);
});

Route::prefix('arrondissements')->group(function () {
    Route::get('/', [ArrondissementController::class, 'index']);
    Route::get('/{communeName}/arrondissement/{arrondissementName}', [ArrondissementController::class, 'getAllQuartierArrondissement']);
});

Route::prefix('quartiers')->group(function () {
    Route::get('/', [QuartierController::class, 'index']);
});