<?php

use App\Constants\RouteNames;
use App\Constants\RouteParameters;
use App\Livewire\Auth\Login;
use App\Livewire\Customer\InteractionCreate;
use App\Livewire\Customer\InteractionShow;
use App\Livewire\CustomerShow;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', Login::class)->name(RouteNames::WEB_AUTH_LOGIN);

Route::middleware('auth:web')->group(function(){
    Route::get('dashboard', Dashboard::class)->name(RouteNames::WEB_DASHBOARD);
    Route::prefix('customer')->group(function(){
        Route::prefix('{'. RouteParameters::CUSTOMER.'}')->group(function(){
            Route::get('/', CustomerShow::class)->name(RouteNames::WEB_CUSTOMER_SHOW);
            Route::prefix('interactions')->group(function(){
                Route::get('/create', InteractionCreate::class)->name(RouteNames::WEB_CUSTOMER_INTERACTION_CREATE);
                Route::prefix('{'.RouteParameters::INTERACTION.'}')->group(function(){
                    Route::get('/', InteractionShow::class)->name(RouteNames::WEB_CUSTOMER_INTERACTION_SHOW);
                });
            });
        });
    });
});
