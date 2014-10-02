<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
    'as'   => 'home',
    'uses' => 'HomeController@home',
));

/**
*   Unauthenticated group
*/
Route::group(array('before' => 'guest'), function(){

    /**
    *   CSRF protection group
    */
    Route::group(array('before' => 'csrf'), function(){
    
        /**
        *   Create account (POST)
        */
        Route::post('/account/create', array(
            'as' => 'account-create-post',
            'uses' => 'AccountController@postCreate',
        ));

        /**
        *   Login (POST)
        */
        Route::post('/account/login', array(
            'as' => 'account-login-post',
            'uses' => 'AccountController@postLogin',
        ));


        /**
        *   Forgot Password (POST)
        */
        Route::post('/account/forgot-password', array(
            'as' => 'account-forgot-password-post',
            'uses' => 'AccountController@postForgotPassword',
        ));

    });

    /**
    *   Create account (GET)
    */
    Route::get('/account/create', array(
        'as' => 'account-create',
        'uses' => 'AccountController@getCreate',
    ));

    /**
    *   Login (GET)
    */
    Route::get('/account/login', array(
        'as' => 'account-login',
        'uses' => 'AccountController@getLogin',
    ));

    /**
    *   Activate account
    */
    Route::get('/account/activate/{code}', array(
        'as' => 'account-activate',
        'uses' => 'AccountController@getActivate',
    ));


    /**
    *   Forgot password (GET)
    */
    Route::get('/account/forgot-password', array(
        'as' => 'account-forgot-password',
        'uses' => 'AccountController@getForgotPassword',
    ));

    /**
    *   Account recovery (GET)
    */
    Route::get('/account/recover/{code}', array(
        'as' => 'account-recover',
        'uses' => 'AccountController@getRecover',
    ));

});


/**
*   Authenticated group
*/
Route::group(array('before' => 'auth'), function(){


    /**
    *   CSRF protection group
    */
    Route::group(array('before' => 'csrf'), function(){
    
        /**
        *   Change password (POST)
        */
        Route::post('/account/change-password', array(
            'as' => 'account-change-password-post',
            'uses' => 'AccountController@postChangePassword',
        ));

    });

    /**
    *   Logout (GET)
    */
    Route::get('/account/logout', array(
        'as' => 'account-logout',
        'uses' => 'AccountController@getLogout',
    ));

    /**
    *   Change password (GET)
    */
    Route::get('/account/change-password', array(
        'as' => 'account-change-password',
        'uses' => 'AccountController@getChangePassword',
    ));



});