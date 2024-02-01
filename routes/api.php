<?php

use App\Constants\RouteNames;
use App\Constants\RouteParameters;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Customer\InteractionController;
use App\Http\Controllers\Api\CustomerController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('auth')->group(function() {
    Route::post('login', [AuthController::class, 'login'])->name(RouteNames::API_AUTH_LOGIN);
});

Route::middleware('auth:api')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::get('logout', [AuthController::class, 'logout'])->name(RouteNames::API_AUTH_LOGOUT);
    });

    Route::prefix('customer')->group(function() {
        Route::get('/', [CustomerController::class, 'index'])->name(RouteNames::API_CUSTOMER_INDEX);
        Route::post('/', [CustomerController::class, 'store'])->name(RouteNames::API_CUSTOMER_STORE);
        Route::prefix('{' . RouteParameters::CUSTOMER . '}')->group(function() {
            Route::get('/', [CustomerController::class, 'show'])->name(RouteNames::API_CUSTOMER_SHOW);
            Route::patch('/', [CustomerController::class, 'update'])->name(RouteNames::API_CUSTOMER_UPDATE);
            Route::delete('/', [CustomerController::class, 'delete'])->name(RouteNames::API_CUSTOMER_DELETE);

            Route::prefix('interactions')->group(function() {
                Route::get('/', [InteractionController::class, 'index'])->name(RouteNames::API_CUSTOMER_INTERACTION_INDEX);
                Route::post('/', [InteractionController::class, 'store'])->name(RouteNames::API_CUSTOMER_INTERACTION_STORE);
                Route::prefix('{' . RouteParameters::INTERACTION . '}')->group(function() {
                    Route::get('/', [InteractionController::class, 'show'])
                        ->name(RouteNames::API_CUSTOMER_INTERACTION_SHOW)
                        ->scopeBindings();
                    Route::patch('/', [InteractionController::class, 'update'])
                        ->name(RouteNames::API_CUSTOMER_INTERACTION_UPDATE)
                        ->scopeBindings();
                    Route::delete('/', [InteractionController::class, 'delete'])
                        ->name(RouteNames::API_CUSTOMER_INTERACTION_DELETE)
                        ->scopeBindings();
                });
            });
        });
    });
});
