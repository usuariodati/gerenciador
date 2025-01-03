<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', function () {
    return view('admin');
})->middleware('role:admin')->name('admin');

Route::get('/form', function () {
    return view('form');
})->middleware('role:admin|usuario')->name('form');