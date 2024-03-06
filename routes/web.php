<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\User\CreateController;
use App\Http\Controllers\User\DestroyController;
use App\Http\Controllers\User\ShowController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/get-countries', [CountryController::class, 'getCountries']);
Route::post('/register', CreateController::class);
Route::post('/delete-user', DestroyController::class);
Route::get('/get-users', ShowController::class);

