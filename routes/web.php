<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/get-countries', [App\Http\Controllers\CountryController::class, 'getCountries']);
Route::post('/register', [App\Http\Controllers\CountryController::class, 'registerUser']);
Route::post('/delete-user', [App\Http\Controllers\CountryController::class, 'deleteUser']);
Route::get('/get-users', [App\Http\Controllers\CountryController::class, 'getAllUsers']);

