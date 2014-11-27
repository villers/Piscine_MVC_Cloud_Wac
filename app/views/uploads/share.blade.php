@extends('layouts.default')

@section('content')

	<div class="page-title">
		<h1>Partager le fichier</h1>
	</div>

	@if (isset($errors) && count($errors->all()) >0)
		<div class="alert alert-warning">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	{{ Form::model($upload, ['class'=>'form-signup']) }}
		<div class="form-group">
			{{ Form::label('url', "Le lien du fichier est:") }}
			{{ Form::text('url', URL::to('/upload/download/'.$upload->id), ['class'=>'form-control']) }}
		</div>
		<div class="form-group">
			{{ Form::label('status', 'Votre fichier est public') }}
			{{ Form::checkbox('status', 1, ['class'=>'form-control']) }}
		</div>
		<div class="form-group">
			{{ Form::label('email', 'Partager avec') }}
			{{ Form::text('email', null, ['class'=>'form-control', 'placeholder' => 'lol@machin.fr']) }}
		</div>
		<div class="form-group">
			<div class="list-group">
				<span class="list-group-item disabled">
					Partagé avec:
				</span>
				@foreach ($shares as $share)
					<span class="list-group-item">{{ $share->email }}<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true" id="{{ $share->id }}" class="deleteshare">&times;</span></button></span>
				@endforeach
			</div>
		</div>

		{{ Form::submit('Valider', ['class'=>'btn btn-large btn-primary btn-block'])}}
	{{ Form::close() }}
@stop