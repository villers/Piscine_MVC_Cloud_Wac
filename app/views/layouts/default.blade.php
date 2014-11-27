<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>@yield('title') | MyDomain.com</title>

		<!-- Bootstrap core CSS -->
		{{ HTML::style('css/bootstrap.css')}}
		{{ HTML::style('css/style.css')}}
		{{ HTML::style('packages/dropzone/css/dropzone.css') }}

		{{ HTML::style('packages/fancybox/source/jquery.fancybox.css') }}
	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::to('/') }}">Blog</a>
				</div>

				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav navbar-right">
						@if(!Auth::check())
							<li>{{ HTML::link('login', 'Connexion') }}</li>
							<li>{{ HTML::link('inscription', 'Inscription') }}</li>
						@else
							<li>{{ HTML::link('#', Auth::User()->username) }}</li>
							<li>{{ HTML::link('contact', 'Contact') }}</li>
							<li>{{ HTML::link('logout', 'Déconnexion') }}</li>
						@endif
					</ul>
				</div>

			</div>
		</div>

		<div class="container">
			@if(Session::has('message'))
				<div class="alert alert-info">
					{{ Session::get('message') }}
				</div>
			@endif

			@yield('content')
		</div>

		<script>baseUrl = "{{ URL::to('/') }}";</script>
		{{ HTML::script('js/jquery-2.1.1.min.js') }}
		{{ HTML::script('js/bootstrap.min.js') }}
		{{ HTML::script('packages/dropzone/dropzone.min.js') }}

		{{ HTML::script('packages/fancybox/source/jquery.fancybox.js') }}

		{{ HTML::script('js/main.js') }}
	</body>
</html>
