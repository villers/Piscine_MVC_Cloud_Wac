@extends('layouts.default')

@section('content')

	<div class="page-title">
		<h1>Renomer le fichier</h1>
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

	{{ Form::open(['class'=>'form-signup']) }}
		{{ Form::text('nom', null, ['class'=>'form-control', 'placeholder'=> $upload->nom]) }}
		{{ Form::submit('Renomer', ['class'=>'btn btn-large btn-primary btn-block'])}}
	{{ Form::close() }}
@stop