<?php

use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('login.index');
});

Route::middleware(['guest'])->group(function() {
    Route::name('login.')->group(function() {
        Route::get('/login', 'LoginController@index')->name('index');
        Route::post('/login', 'LoginController@store')->name('store');
    });
});

Route::prefix('/register')->group(function(){
    Route::name('register.')->group(function() {
        Route::get('/', 'RegisterController@index')->name('index');
        Route::post('/', 'RegisterController@store')->name('store');
    });

    Route::prefix('email')->group(function() {

        Route::get('verify', function () {
            return view('auth.verify-email');
        })->middleware('auth')->name('verification.notice');
    
        Route::get('verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect()->route('painel.index');
        })->middleware(['auth', 'signed'])->name('verification.verify');
    
        Route::post('verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('message', 'Verification link sent!');
        })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    });
    
});

Route::middleware(['auth', 'verified'])->group(function() {

    Route::prefix('painel')->group(function() {

        Route::name('painel.')->group(function() {
            Route::get('/', 'DashboardController@index')->name('index');
            Route::post('/', 'DashboardController@beginnerPokemon')->name('beginnerPokemon');
            Route::get('/logout', function() {
                Auth::logout();
                return redirect()->route('login.index');
            })->name('logout');
        });

        Route::prefix('battle')->group(function() {
            Route::name('battle.')->group(function() {
                Route::get('/', 'BattleController@index')->name('index');
                Route::post('/', 'BattleController@userPokemon')->name('user.pokemon');
            });
        });

    });

});

