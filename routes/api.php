<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Version 1 (V1) - API Routes
|--------------------------------------------------------------------------
|namespace: Api\V1
|middleware: api
|prefix: api/v1/
*/


Route::prefix('v1')->namespace('V1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        // get current user profile
        Route::get('/profile', 'UserController@profile');

        // log out user
        Route::get('/logout', 'UserController@logout');



        // get all loan applications
        Route::get('/loans', 'LoanApplicationController@index');

        // save new loan application
        Route::post('/loans', 'LoanApplicationController@store');


    });



    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */

    // login user
    Route::post('/login', 'UserController@login');

    // signup user
    Route::post('/register', 'UserController@register');


    //get all terms
    Route::get('/interest-rate', 'LoanTermController@index');


});
