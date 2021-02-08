<?php

use App\Http\Controllers;
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


Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


Route::get('/', function () {
    return view('auth.login');
});


Route::get('login', function () {
    return view('backend.pages.login');
});

Route::get('home', function () {
    return view('backend.pages.index');
});


Route::get('admin/{name?}', 'Controller@showView');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('Dashboard');

Route::get('/pulldata', 'PullDataController@index')->name('Pull Data from Server');

// Buoy Information
Route::resource('buoys', 'BuoyController')->middleware('auth');
Route::resource('qumatiks', 'QumatikController')->middleware('auth');
Route::resource('communities', 'CommunityController')->middleware('auth');

Route::get('/buoy/summary/{id}', 'BuoyController@summary');
Route::get('/buoy/summary/{imei}/{month}/{year}', 'BuoyController@updateSummary');
// Data
Route::resource('datas', 'DataController');


Route::get('email/{imei}', 'DataController@show');
Route::get('data/show/{operationID}', 'DataController@singleData');
Route::get('data/edit/{operationID}', 'DataController@editData');
Route::get('data/flagged/{operationID}', 'DataController@flagData');




Route::get('registeruser', 'HomeController@register');


Route::resource('summery', 'SummeryController');


Route::match('post', 'updateApproval/{imei}/{operationID}', [
    'as' => 'summery.approval',
    'uses' => 'SummeryController@updateApproval'
]);


//Route::get('profile/{id}', [
//    'as'    =>  '{id}',
//    'uses'  =>  'ProfileController@show',
//]);

// All profile information will display here
Route::get('/users/all', [
    'as'    =>  'users',
    'uses'  =>  'ProfileController@index',
]);

// profile section
Route::resource(
    'profile',
    'profileController', [
        'only' =>   [
            'show',
            'edit',
            'update',
            'create',
        ],
    ]
);



// All profile information will display here
Route::resource('/qumatikdata', QumatikDataController::class);
Route::get('qumatiksdata/data/{imei}', [Controllers\QumatikDataController::class, 'index']);
Route::get('qumatiksdata/location/{id}', [Controllers\QumatikDataController::class, 'location']);




