<?php

use App\Http\Controllers\Api\v1 as V1;
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
Route::as('v1.')
    ->prefix('v1')
    ->group(function () {
        Route::post('login', V1\LoginController::class);

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::post('task/{task}/complete', [V1\TaskController::class, 'complete'])->name('task.complete');
            Route::resource('task', V1\TaskController::class)->except(['create', 'edit', 'show']);
        });
    });
