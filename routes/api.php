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

Route::get('/list/university', 'UniversityController@getListOfUniversity');

Route::post('/list/department', 'UniversityController@getListOfDepartmentByUniversity');

Route::post('/update/university', 'UniversityController@updateUniversity');
