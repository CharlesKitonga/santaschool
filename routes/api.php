<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user' => 'API\UserController',
    'homes' =>'API\HomeController',
    'sliders' => 'API\SliderController',
    'services' => 'API\ServicesController',
    'abouts' => 'API\AboutController',
    'philosophy' => 'API\PhilosophyController',
    'teams' => 'API\TeamController',
    'teamleader' => 'API\TeamLeaderController',
    'galleries' => 'API\GalleryController',
    'partners' => 'API\PartnerController',
    'clients' => 'API\ClientsController',
    'topics' => 'API\TopicController'

]);
Route::get('profile', 'API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');
