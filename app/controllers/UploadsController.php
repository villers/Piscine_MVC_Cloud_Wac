<?php
define('DS', DIRECTORY_SEPARATOR);
class UploadsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$uploads = Upload::where('user_id', '=', Auth::User()->id)->paginate(10);
		$size = round(Upload::getUploadsSizeByUser(Auth::User()->id), 2);

		return View::make('uploads.index', compact('uploads', 'size'));
	}

	public function store($pathUrl = '')
	{
		$file = Input::file('file');
		$path = strtolower(public_path('uploads'.DS.md5(Auth::User()->id)));
		$extension = strtolower($file->getClientOriginalExtension());
		$filename = strtolower($file->getClientOriginalName());
		$size = Upload::octetToMio($file->getSize());
		$totalSize = round(Upload::getUploadsSizeByUser(Auth::User()->id), 2);

		if($size > 10)
			throw new Exception("Votre fichier est trop volumineux..", 1);
		if($size + $totalSize > 50)
			throw new Exception("Votre cloud est rempli.", 1);


		$mime = $file->getMimeType();

		$file->move($path, $filename);

		$upload = new Upload;
		if(!isset(Upload::where('nom', '=', $filename)->where('user_id', '=', Auth::User()->id)->first()->id)){
			$upload->user_id = Auth::User()->id;
			$upload->nom = $filename;
			$upload->type = $mime;
			$upload->size = $size;
			$upload->status = 1;
			$upload->path = trim($pathUrl, "/");
			$upload->save();

			$upload->html = "<tr>".
							"<td>".$upload->id."</td>".
							"<td>".
							"<a class=\"fancybox fancybox.iframe\" href=\"".URL::to('/uploads/'.md5($upload->user_id).'/'.$upload->nom)."\">".
								e($upload->nom).
							"</a>".
							"</td>".
							"<td>".$upload->type."</td>".
							"<td>".
								HTML::linkRoute('upload.download', 'Télécharger', [$upload->id], ['class' => 'btn btn-success']).' '.
								HTML::linkRoute('upload.share', 'Partager', [$upload->id], ['class' => 'btn btn-info']).' '.
								HTML::linkRoute('upload.rename', 'Renomer', [$upload->id], ['class' => 'btn btn-primary']).' '.
								HTML::linkRoute('upload.delete', 'Supprimer', [$upload->id], ['class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Êtes vous sur ?\')']).
							"</td>".
						"</tr>";
		}

		$upload->totalSize = round(Upload::getUploadsSizeByUser(Auth::User()->id), 2);

		return $upload;
	}

	public function show($id)
	{

	}

	public function getDownload($id)
	{
		$upload = Upload::findOrFail($id);
		if(!$upload->isShare())
			return Redirect::to('/')->with('message', "Vous n'êtes pas autorisé a télécharger ce fichier.");
		if(file_exists(public_path('uploads'.DS.md5($upload->user_id).DS.$upload->nom)))
			return Response::download(public_path('uploads'.DS.md5($upload->user_id).DS.$upload->nom));
		else
			return Redirect::to('/')->with('message', "Le fichier n'existe plus.".public_path('uploads'.DS.md5($upload->user_id).DS.$upload->nom));
	}

	public function getShare($id)
	{
		$upload = Upload::findOrFail($id);
		if(!$upload->isMyUpload())
			return Redirect::to('/')->with('message', "Vous n'êtes pas le propriétaire de ce fichier.");

		$shares = Share::where('id_upload', '=', $id)->get();

		$upload->url = URL::to('uploads'.DS.md5($upload->user_id).DS.$upload->nom);
		return View::make('uploads.share', compact('upload', 'shares'));
	}

	public function getShareDelete($id)
	{
		$share = Share::findOrFail($id);
		if(!$share->isMyFile())
			return die("Vous n'êtes pas le propriétaire de ce fichier.");

		Share::destroy($id);
	}

	public function postShare($id)
	{
		$upload = Upload::findOrFail($id);
		if(!$upload->isMyUpload())
			return Redirect::to('/')->with('message', "Vous n'êtes pas le propriétaire de ce fichier.");

		$data = Input::only('status');
		$data['status'] = ($data['status'] == null) ? 0 : 1;

		$upload->update($data);


		$data = Input::only('email');
		if(!empty($data['email']))
		{
			$data['id_upload'] = $id;
			$validator = Validator::make($data, Share::$rules);
			if($validator->fails()) {
				return Redirect::back()->withErrors($validator)->withInput();
			}
			$share = new Share;
			$share->email = $data['email'];
			$share->id_upload = $id;
			$share->save();
			Mail::send('emails.share', $data, function($message) use ($data) {
				$message->from('villers.mickael@gmail.com', 'Cloud');
				$message->to($data['email'])->subject('Welcome!');
			});
		}
		return Redirect::back();
	}

	public function getRename($id)
	{
		$upload = Upload::findOrFail($id);
		if(!$upload->isMyUpload())
			return Redirect::to('/')->with('message', "Vous n'êtes pas le propriétaire de ce fichier.");
		return View::make('uploads.rename', compact("upload"));
	}

	public function postRename($id)
	{
		$upload = Upload::findOrFail($id);
		if(!$upload->isMyUpload())
			return Redirect::to('/')->with('message', "Vous n'êtes pas le propriétaire de ce fichier.");

		$datas = Input::only('nom');

		$validator = Validator::make($datas, Upload::$rules);
		if($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if(file_exists(public_path('uploads'.DS.md5($upload->user_id).DS.$upload->nom)))
			File::move(public_path('uploads'.DS.md5($upload->user_id).DS.$upload->nom), public_path('uploads'.DS.md5($upload->user_id).DS.$datas['nom']));

		$upload->update($datas);
		return Redirect::to('/')->with('message', "Le fichier $id a été renomé!");
	}

	public function getDelete($id)
	{
		$upload = Upload::findOrFail($id);
		if(!$upload->isMyUpload())
			return Redirect::to('/')->with('message', "Vous n'êtes pas le propriétaire de ce fichier.");

		if(file_exists(public_path('uploads'.DS.md5($upload->user_id).DS.$upload->nom)))
			File::delete(public_path('uploads'.DS.md5($upload->user_id).DS.$upload->nom));

		Upload::destroy($id);
		return Redirect::to('/')->with('message', "Le fichier $id a été suprimé!");
	}
}