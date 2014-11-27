<?php

class Upload extends Eloquent {
	protected $table = 'uploads';

	protected $guarded = ['id', 'user_id'];
	protected $fillable = ['nom', 'status'];

	public static $rules = [
		'nom'=>'required|regex:/^[a-zA-Z0-9\-\.\_]+$/i'
	];

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function getPath()
	{
		$path = (empty($this->path))? '/' : '/'.$this->path.'/';
		return 'uploads/'.md5($this->user_id).$path;
	}

	public function getUri()
	{
		$path = (empty($this->path))? '/' : '/'.$this->path.'/';
		return 'uploads/'.md5($this->user_id).$path.$this->nom;
	}

	public static function octetToMio($octet)
	{
		return ($octet / pow(2, 20));
	}

	public static function getUploadsSizeByUser($user_id)
	{
		return self::where('user_id', '=', $user_id)->get()->sum('size');
	}

	public function isShare()
	{
		$shareWithMe = Share::where('id_upload', '=', $this->id)->where('email', '=', Auth::User()->email)->first();
		return ($this->user_id == Auth::User()->id || $this->status == 1 || isset($shareWithMe->exists) || Auth::User()->hasRole('admin'));
	}

	public function isMyUpload()
	{
		return ($this->user_id == Auth::User()->id || Auth::User()->hasRole('admin'));
	}
}
