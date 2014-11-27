<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';
	protected $hidden = ['password', 'remember_token'];

	public static $rules = [
		'username'=>'required|unique:users|alpha|min:2|not_in:users,Users,files,Files',
		'name'=>'required|alpha|min:2',
		'lastname'=>'required|alpha|min:2',
		'birthdate'=>'required|date',
		'email'=>'required|email|unique:users',
		'password'=>'required|alpha_num|between:6,12|confirmed',
		'password_confirmation'=>'required|alpha_num|between:6,12'
	];

	public function roles()
	{
		return $this->belongsToMany('Role', 'users_roles');
	}

	public function hasRoles()
	{
		$roles = $this->roles->toArray();
		return !empty($roles);
	}

	public function hasRole($check)
	{
		return in_array($check, array_fetch($this->roles->toArray(), 'name'));
	}

	private function getIdInArray($array, $term)
	{
		foreach ($array as $key => $value) {
			if ($value == $term)
				return $key;
		}

		throw new UnexpectedValueException;
	}

	public function addRole($title)
	{
		$assigned_roles = [];

		$roles = array_fetch(Role::all()->toArray(), 'name');

		switch ($title) {
			case 'super_admin':
				$assigned_roles[] = $this->getIdInArray($roles, 'edit_customer');
				$assigned_roles[] = $this->getIdInArray($roles, 'delete_customer');
			case 'admin':
				$assigned_roles[] = $this->getIdInArray($roles, 'create_customer');
			case 'concierge':
				$assigned_roles[] = $this->getIdInArray($roles, 'add_points');
				$assigned_roles[] = $this->getIdInArray($roles, 'redeem_points');
				break;
			default:
				throw new \Exception("The employee status entered does not exist");
		}

		$this->roles()->attach($assigned_roles);
	}
}
