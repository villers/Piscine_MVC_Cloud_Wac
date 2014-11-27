@extends('layouts.default')

@section('content')
	{{ Form::open(['route' => ['register.post'], 'method' => 'POST', 'class'=>'form-signup']) }}
		<h2 class="form-signup-heading">Inscription</h2>

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
			{{ Form::text('username', null, ['class'=>'form-control', 'placeholder'=>'Username']) }}
		</div>
		<div class="form-group">
			{{ Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name']) }}
		</div>
		<div class="form-group">
			{{ Form::text('lastname', null, ['class'=>'form-control', 'placeholder'=>'Last Name']) }}
		</div>
		<div class="form-group">
			{{ Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Email Address']) }}
		</div>
		<div class="form-group">
			{{ Form::input('date', 'birthdate', null, array('class'=>'form-control')) }}
		</div>
		<div class="form-group">
			{{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password']) }}
		</div>
		<div class="form-group">
			{{ Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Confirm Password']) }}
		</div>
		<div class="form-group">
			{{ Form::submit('Register', ['class'=>'btn btn-large btn-primary btn-block'])}}
		</div>
	{{ Form::close() }}
@stop