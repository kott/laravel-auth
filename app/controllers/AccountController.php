<?php

class AccountController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    /**
    *   Log the user out of the current session
    */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::route('home');
    }

    /**
     * Show the form for login.
     *
     * @return Response
     */
    public function getLogin()
    {
        return View::make('account.login');
    }


    /**
     *  Handles the login logic.
     *
     */
    public function postLogin()
    {
        $validator = Validator::make(Input::all(),
            array(
                'email'              => 'required|email|exists:users,email',
                'password'           => 'required',
            )
        );

        if($validator->fails())
        {
            return Redirect::route('account-login')
                    ->withErrors($validator)
                    ->withInput();
        }
        else
        {
            $remember = (Input::has('remember')) ? true : false;

            $auth = Auth::attempt(array(
                'email'    => Input::get('email'),
                'password' => Input::get('password'),
                'active'  => 1,
            ), $remember);

            if($auth)
            {
                //Redirect to intended page
                return Redirect::intended('/');
            }
            else
            {
                return Redirect::route('account-login')
                        ->with('global', 'Invalid credentials, or you may not yet have activated your account.');
            }
        }

        //last fallback
        return Redirect::route('account-login')->with('global', 'A login error occured, please try again');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('account.create');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function postCreate()
    {
        $validator = Validator::make(Input::all(),
            array(
                'email'              => 'required|max:50|email|unique:users',
                'username'           => 'required|max:30|min:3|unique:users',
                'password'           => 'required|min:6',
                'password_reenter'   => 'required|same:password',
            )
        );

        if($validator->fails())
        {
            return Redirect::route('account-create')
                    ->withErrors($validator)
                    ->withInput();
        }
        else
        {
            $email = Input::get('email');
            $username = Input::get('username');
            $password = Input::get('password');

            //activation code
            $code = str_random(60);

            $user = User::create(array(
                'email'    => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'code'     => $code,
                'active'   => 0,
            ));

            if($user)
            {
                //send email
                Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user){
                    $message->to($user->email, $user->username)->subject('Account Activation');
                });

                return Redirect::route('home')
                        ->with('global', 'Your account has been created! An email has been sent to you to activate your account.');
            }
        }
    }

    /**
    *   Activates an account for a given code
    */
    public function getActivate($code)
    {
        $user = User::where('code', '=', $code)->where('active', '=', 0);

        if($user->count())
        {
            $user = $user->first();

            //update user to 'active'
            $user->active = 1;
            $user->code = '';

            if($user->save())
            {
                return Redirect::route('home')->with('global', 'Success! You can now sign in.');
            }
        }
        return Redirect::route('home')->with('global', 'A problem has occured, please try again later.');
    }

    /**
    *   Display the view for changing a password
    *   @return the view
    */
    public function getChangePassword()
    {
        return View::make('account.password');
    }

    /**
    *   Logic for changing the password
    */
    public function postChangePassword()
    {
        $validator = Validator::make(Input::all(),
            array(
                'old_password'     => 'required',
                'password'         => 'required|min:6',
                'password_reenter' => 'required|same:password',
            )
        );

        if($validator->fails())
        {
            return Redirect::route('account-change-password')
                    ->withErrors($validator);
        }
        else
        {
            $user = User::find(Auth::user()->id);

            $old_password = Input::get('old_password');
            $password = Input::get('password');

            if(Hash::check($old_password, $user->getAuthPassword()))
            {
                $user->password = Hash::make($password);

                if($user->save())
                {
                    return Redirect::route('home')
                            ->with('global', 'Your password has successfully been changed.');
                }
            }
            else
            {
                return Redirect::route('account-change-password')
                        ->with('global', 'Your old password was incorrect.');
            }
        }

        //fallback
        return Redirect::route('account-change-password')
                ->with('global', 'Your password could not be changed.');
    }


    /**
    *   Display the view for the forgot password form
    *   @return the view
    */
    public function getForgotPassword()
    {
        return View::make('account.forgot');
    }

    /**
    *   Logic for account recovery
    */
    public function postForgotPassword()
    {
        $validator = Validator::make(Input::all(), 
            array(
                'email' => 'required|email|exists:users,email',
            )
        );

        if($validator->fails())
        {
            return Redirect::route('account-forgot-password')
                    ->withErrors($validator)
                    ->withInput();
        }
        else
        {
            $user = User::where('email', '=', Input::get('email'));

            if($user->count())
            {
                $user = $user->first();
                $code = str_random(60);
                $password = str_random(15);

                $user->code = $code;
                $user->password_temp = Hash::make($password);

                if($user->save())
                {
                    //send email
                    Mail::send('emails.auth.forgot', 
                        array(
                            'link' => URL::route('account-recover', $code), 
                            'username' => $user->username,
                            'password' => $password
                        ), 
                        function($message) use ($user){
                            $message->to($user->email, $user->username)->subject('Password Reset');
                        }
                    );

                    return Redirect::route('home')->with('global', 'An account recovery email has been sent to you.');
                }
            }
        }

        return Redirect::route('account-forgot-password')->with('global', 'Error resetting password.');
    }


    /**
    *   Account recovery logic (the link from email sent)
    *   @param string $code
    */
    public function getRecover($code)
    {
        $user = User::where('code', '=', $code)->where('password_temp', '!=', '');

        if($user->count())
        {
            $user = $user->first();

            $user->password = $user->password_temp;
            $user->password_temp = '';
            $user->code = '';

            if($user->save())
            {
                return Redirect::route('account-login')
                        ->with('global', 'Your account has been recovered, it is advised that you change your password.');
            }
        }

        return Redirect::route('home')->with('global', 'Account could not be recovered.');
    }

}
