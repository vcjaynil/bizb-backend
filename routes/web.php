<?php

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

//Route::get('email-template',function (){
//   $user = \App\Models\User::find(3);
//   $otp = 12345;
//
//   return view('frontend.mail.welcome',compact('user','otp'));
//});

Route::group(['middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    /*
    * Frontend Routes
    * Namespaces indicate folder structure
    */
    Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
        includeRouteFiles(__DIR__ . '/Frontend/');
    });


    /* ----------------------------------------------------------------------- */

    /*
     * Backend Routes
     * Namespaces indicate folder structure
     */
    Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', 'permitted', 'verified']], function () {
        /*
         * These routes need view-backend permission
         * (good if you want to allow more than one group in the backend,
         * then limit the backend features by different roles or permissions)
         *
         * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
         */

        includeRouteFiles(__DIR__ . '/Backend/');
    });
});

Route::group(['middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function ()
{
Route::get('/apm', '\Done\LaravelAPM\ApmController@index')->name('apm')->middleware(['auth', 'permitted', 'verified']);

});
