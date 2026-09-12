<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Front page routes
Route::get('/', [PagesController::class, 'Index']);
Route::get('/about-us', [PagesController::class, 'About']);
Route::get('/gallery', [PagesController::class, 'Gallery']);
Route::get('/teachers', [PagesController::class, 'Teachers']);
Route::get('/admissions', [PagesController::class, 'Admissions']);
Route::match(['get', 'post'], '/contact', [PagesController::class, 'Contact']);

// Admin logout route
Route::get('/admin-logout', [PagesController::class, 'logout']);

// Hand remaining paths to the Vue SPA
Route::get('{path}', [HomeController::class, 'index'])->where('path', '.*');
