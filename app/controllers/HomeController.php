<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
        // Mail::send('emails.auth.test', array('name' => 'Kris'), function($message){
        //     $message->to('ott.kristian@gmail.com', 'Kristian Ott')->subject('Test Email');
        // });

        return View::make('home');
	}

}
