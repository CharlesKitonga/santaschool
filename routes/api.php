<?php

use App\Http\Controllers\API\AboutController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\PartnerController;
use App\Http\Controllers\API\PhilosophyController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\TeamLeaderController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user' => UserController::class,
    'homes' => HomeController::class,
    'sliders' => SliderController::class,
    'abouts' => AboutController::class,
    'philosophy' => PhilosophyController::class,
    'teams' => TeamController::class,
    'teamleader' => TeamLeaderController::class,
    'galleries' => GalleryController::class,
    'partners' => PartnerController::class,
]);

Route::get('profile', [UserController::class, 'profile']);
Route::put('profile', [UserController::class, 'updateProfile']);
