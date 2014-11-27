<?php

class Share extends Eloquent {
	protected $table = 'shares';

	public $timestamps = false;

	public static $rules = [
		'email'=>'email'
	];

	public function isMyFile()
	{
		$data = Upload::find($this->id_upload);
		return ($data->user_id == Auth::User()->id);
	}
}
