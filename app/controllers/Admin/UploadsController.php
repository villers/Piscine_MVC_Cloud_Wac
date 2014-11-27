<?php
namespace Admin;
use \Upload;
use \User;
use \View;

class UploadsController extends \BaseController {

	public function index($username = null)
	{
		if(is_null($username))
			$uploads = Upload::paginate(10);
		else{
			$user = User::where('username', '=', $username)->firstOrFail();
			$uploads = Upload::where('user_id', '=', $user->id)->paginate(10);
		}
		return View::make('admin.index', compact('uploads'));
	}
}
