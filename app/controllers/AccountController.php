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
                'password_reenter' => 'required|same:password',
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

                return Redirect::route('home')
                        ->with('global', 'Your account has been created! An email has been sent to you to activate your account.');
            }
        }
    }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
