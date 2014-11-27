<?php

class ContactController extends BaseController {

	public function index()
	{
		return View::make('contact.contact');
	}

	public function send()
	{
		$data = Input::all();
		Mail::send('emails.contact', $data, function($message){
			$message->from('villers.mickael@gmail.com', 'Cloud');
			$message->to('villers.mickael@gmail.com')->subject('Welcome!');
		});
		return Redirect::to('/')->with('message', "L'émail a été envoyé au administrateurs");
	}

}
