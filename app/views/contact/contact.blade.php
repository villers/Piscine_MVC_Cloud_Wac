@extends('layouts.default')

@section('content')
	{{ Form::open(['route' => ['contact.post'], 'method' => 'POST', 'class'=>'form-signin']) }}
		<h1>Contacter l'administrateur</h1>

		@if (isset($errors) && count($errors->all()) >0)
			<div class="alert alert-warning">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="form-group">
			{{ Form::label('email', 'Mon email') }}
			{{ Form::email('email', Input::old('email'), ['placeholder' => 'moi@hotmail.com', 'class' => 'form-control']) }}
		</div>

		<div class="form-group">
			{{ Form::label('text', 'Méssage') }}
			{{ Form::textarea('text', Input::old('text'), ['class' => 'form-control']) }}
		</div>

		<p>{{ Form::submit('Submit!', ['class'=>'btn btn-large btn-primary btn-block']) }}</p>
	{{ Form::close() }}
@stop