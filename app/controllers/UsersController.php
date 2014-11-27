<?php

class UsersController extends BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', ['on' => 'post']);
	}

	public function getLogin()
	{
		return View::make('auth.login');
	}

	public function postLogin()
	{
		$input = ['username' => Input::get('username'), 'password' => Input::get('password')];
		if (Auth::attempt($input))
			return Redirect::intended()->with('message', 'Vous etes maintenant connecté!');
		else
			return Redirect::back()->with('message', 'Incorrect Username or Password');
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('login')->with('message', 'Vous etes maintenant déconnecté!');
	}

	public function getRegister()
	{
		return View::make('auth.register');
	}

	public function postRegister()
	{
		$validator = Validator::make(Input::all(), User::$rules);

		if ($validator->passes()) {
			$user = new User;
			$user->username = Input::get('username');
			$user->name = Input::get('name');
			$user->lastname = Input::get('lastname');
			$user->birthdate = Input::get('birthdate');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::to('login')->with('message', 'Merci pour ton incription!');
		} else
			return Redirect::back()->with('message', 'Une erreur est apparue')->withErrors($validator)->withInput();
	}
}
