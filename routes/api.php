<?php

use App\Summery;
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

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/summary/date/{date}', 'SummeryController@summaryDate');
    Route::get('/summary/imei/{imei}', 'SummeryController@summaryIMEI');

});



Route::get('/allusers', function (Request $request){
    return $request->user();
});
