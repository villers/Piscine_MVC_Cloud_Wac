<?php
namespace Admin;
use \Upload;
use \User;
use \View;
use \Input;
use \Validator;
use \Redirect;
use \Hash;

class UsersController extends \BaseController {

	public function index()
	{
		$users = User::paginate(10);
		return View::make('admin.index', compact('users'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.create_user');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, User::$rules);

		if ($validation->passes())
		{
			$user = new User;
			$user->username = Input::get('username');
			$user->name = Input::get('name');
			$user->lastname = Input::get('lastname');
			$user->birthdate = Input::get('birthdate');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();
			return Redirect::route('admin')->with('message', "L'utilisateur a bien été crée");
		}

		return Redirect::route('admin.create_user')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::findOrFail($id);
        if (is_null($user))
        {
            return Redirect::route('admin');
        }
        return View::make('admin.edit_user', compact('user'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
        $validation = Validator::make($input, User::$rules);
        if ($validation->passes())
        {
            $user = User::findOrFail($id);
            $user->update($input);
            return Redirect::route('admin');
        }
		return Redirect::route('admin.edit_user', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'Il y a des erreurs de validation.');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::findOrFail($id)->delete();
        return Redirect::route('admin');
	}
}
