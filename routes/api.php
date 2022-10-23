<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user-timezone', function(Request $request) {
    $timezone = $request->input('tz');
    if ($timezone) {
        // throws error if timezone is not correct, preventing malicious behavior
        new DateTimeZone($timezone);

        if (!session()->get('userTimezone')) {
            session()->put('userTimezone', $timezone);
            return response('Timezone set')->header('Content-Type', 'text/plain');
        }

        return response('Timezone already set')->header('Content-Type', 'text/plain');
    }

    return response('No timezone set', 400)->header('Content-Type', 'text/plain');
});

Route::get('/user-timezone', function(Request $request) {
    $timezone = session()->get('userTimezone');

    if (isset($timezone)) {
        return response($timezone)->header('Content-Type', 'text/plain');
    }

    return response('Timezone not set', 400)->header('Content-Type', 'text/plain');
});
