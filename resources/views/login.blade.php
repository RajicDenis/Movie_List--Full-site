@extends('layouts.app')

@section('content')

{{ Html::style('css/left-header.css') }}
{{ Html::style('css/login.css') }}

<style>
	.top-header {
		display: none;
	}
	.movie-banner {
		background: url({{ URL::asset('images/movie-bg.jpg')  }});
	}
	
	/* Custom left header*/
	.main {
		padding-bottom: 50px !important;
	}
	.main:after {
        content: "";
		position: absolute;
        width: 100%;
        height: 50px;
	    background: white;
    }
	.site-motto {
		text-align: center;
	}

	
</style>

<div class="login-container">
	
	<div class="movie-banner">
		<div class="site-logo"><img class="logo-img" src="{{ URL::asset('images/logo.png') }}"></div>
		<div class="site-motto">Track and Discover Movies, Create Your Own Lists and Share Them With Others!</div>
	</div>

	<div class="register">

		<div class="reg-title">Register for free!</div>

		<div class="reg-form">
			<form action="{{ route('register') }}" class="form" method="POST" >

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<input type="text" name="username" placeholder="Username" required>

				<input type="text" name="email" placeholder="E-Mail" required>

				<input type="password" name="password" placeholder="Password" required>

				<!--<input type="password" name="password" placeholder="Repeat Password" required>-->

				<input type="submit" name="register" value="Register">
			</form>
		</div>

		<img class="film-img" src="{{ URL::asset('images/film.png') }}">

	</div>

	<div class="login">

		<div class="log-title">Already have an account?</div>

		<div class="reg-form">
			<form action="{{ route('user-login') }}" class="form" method="POST">

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<input id="login-mail" type="text" name="email" placeholder="E-Mail" required>

				<input id="login-pass" type="password" name="password" placeholder="Password" required>

				<input id="login-btn" type="submit" name="login" value="Login"> 

				@if(Session('error'))
					<div class="error-login">{{ Session('error') }}</div>
				@endif
			</form>
		</div>
	</div>

	<div class="features">
		<div class="row1">
			<div class="ftr">
				<div class="ftr-box">
					<div class="ftr-title">Custom Lists</div>
					<div class="ftr-desc">Create your own list of your favorite movies and TV shows!</div>
				</div>
				<div class="ftr-icon"><i class="fa fa-th-list fa-4x" aria-hidden="true"></i></div>
			</div>
			<div class="ftr">
				<div class="ftr-box">
					<div class="ftr-title">Join the Forum</div>
					<div class="ftr-desc">With forums and personal messages you'll always be able to find other movie fans to chat with!</div>
				</div>
				<div class="ftr-icon"><i class="fa fa-comments fa-4x" aria-hidden="true"></i></div>
			</div>
			<div class="ftr">
				<div class="ftr-box">
					<div class="ftr-title">Scoring system</div>
					<div class="ftr-desc">Rank your favorite movies and shows using our 10-point system!</div>
				</div>
				<div class="ftr-icon"><i class="fa fa-star-half-o fa-4x" aria-hidden="true"></i></div>
			</div>
		</div>
		
		<div class="row2">
			<div class="ftr">
				<div class="ftr-box">
					<div class="ftr-title">Reviews</div>
					<div class="ftr-desc">Read movie reviews of other users, score them or write a review of your favorite movies and share it with others!</div>
				</div>
				<div class="ftr-icon"><i class="fa fa-pencil-square-o fa-4x" aria-hidden="true"></i></div>
			</div>
			<div class="ftr">
				<div class="ftr-box">
					<div class="ftr-title">Search</div>
					<div class="ftr-desc">Search for movies and TV shows using our detailed search bar!</div>
				</div>
				<div class="ftr-icon"><i class="fa fa-search fa-4x" aria-hidden="true"></i></div>
			</div>
			<div class="ftr">
				<div class="ftr-box">
					<div class="ftr-title">Coming Soon</div>
					<div class="ftr-desc">Achievements, Blogs, even more Statistics/Graphs, and lots of other improvements are coming soon!</div>
				</div>
				<div class="ftr-icon"><i class="fa fa-wrench fa-4x" aria-hidden="true"></i></div>
			</div>
		</div>
	</div>

</div>

@endsection