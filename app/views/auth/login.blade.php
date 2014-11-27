@extends('layouts.default')

@section('content')
	{{ Form::open(['route' => ['login.post'], 'method' => 'POST', 'class'=>'form-signin']) }}
		<h1>Login</h1>

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
			{{ Form::label('username', 'Login') }}
			{{ Form::text('username', Input::old('username'), ['placeholder' => 'admin', 'class' => 'form-control']) }}
		</div>

		<div class="form-group">
			{{ Form::label('password', 'Password') }}
			{{ Form::password('password', ['class'=>'input-block-level', 'placeholder'=>'Password', 'class' => 'form-control']) }}
		</div>

		<p>{{ Form::submit('Submit!', ['class'=>'btn btn-large btn-primary btn-block']) }}</p>
	{{ Form::close() }}
@stop