@extends('layouts.app')

@section('content')

{{ Html::style('css/left-header.css') }}
{{ Html::style('css/login-page.css') }}

<style>
	.top-header {
		display: none;
	}
	.main {
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-pack: center;
		    -ms-flex-pack: center;
		        justify-content: center;
		-webkit-box-align: center;
		    -ms-flex-align: center;
		        align-items: center;
		min-height: 100vh;
		overflow-y: hidden;
		background-image: url({{ URL::asset('images/movie-bg.jpg') }});
		background-size: cover;
	}
	.main:after {
		position: absolute;
		content: "";
		width: 100%;
		height: calc(100% + 50px);
		background: rgba(8,8,8,0.8);
		z-index: 2;
		top: 0;
		left: 0;
	}
	
</style>

<div class="col-md-2">

	<img class="login-logo" src="{{ URL::asset('images/logo-clear.png') }}">

	@if(Session('error'))
			<div class="error-login">{{ Session('error') }}</div>
	@endif

	<form action="{{ route('user-login') }}" class="form-signin" method="POST">

		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<input id="login-mail" class="form-control" type="text" name="email" placeholder="E-Mail" required>

		<input id="login-pass" class="form-control" type="password" name="password" placeholder="Password" required>

		<input id="login-btn" type="submit" name="login" value="Login"> 

		<div class="input-group"><input type="checkbox" name="rememberMe"> Remember Me</div>

	</form>	
</div>



@endsection