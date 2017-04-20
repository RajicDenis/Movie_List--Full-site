@extends('layouts.app')

@section('content')

{{Html::style('css/profile.css')}}

<style>
	.pic-box {
		@if(Sentinel::getUser()->avatar == null)
		background: #FF003F;
		color: white;
		font-size: 65px;
		font-family: 'Amaranth', sans-serif;
		@endif
	}
	.banner:after {
		background-image: url({{ URL::asset('images/redbg.png') }});
	}

</style>

<div class="profile-container">

	<div class="banner-container">

		<div class="banner">
			<div class="col-md-8 col-md-offset-2 userinfo-box">
				<div class="pic-box">
				@if(Sentinel::getUser()->avatar == null)
					{{ substr(Sentinel::getUser()->username, 0, 1) }}
				@else 
					<img src="{{ URL::asset('images/avatars/'.Sentinel::getUser()->avatar.'') }}" style="width: 100%; height: 100%; background-size: cover; border-radius: 50%;">
				@endif
				</div>
				<div class="stat-container">
					<div class="stat-username">{{ Sentinel::getUser()->username }}</div>
					<div class="stat-stats">
						<div class="stat1">
							<div class="avg-scr">
							@if(App\Utilities::getAvgUserRating(Sentinel::getUser()->id, 'movie') != null)
								{{ number_format(App\Utilities::getAvgUserRating(Sentinel::getUser()->id, 'movie'), 2) }}
							@else
								N/A
							@endif
							</div>
							<div class="avg-txt">Average Movie Score</div>
						</div>
						<div class="stat2">
							<div class="avg-scr">
							@if(App\Utilities::getAvgUserRating(Sentinel::getUser()->id, 'tvshow') != null)
								{{ number_format(App\Utilities::getAvgUserRating(Sentinel::getUser()->id, 'tvshow'), 2) }}
							@else
								N/A
							@endif
							</div>
							<div class="avg-txt">Average TV Score</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="banner-links">
			<a class="banner-btn a" href="{{ action('ProfileController@showAccount') }}">Account</a>
			<a class="banner-btn b" href="{{ action('ProfileController@showReviews') }}">My Reviews</a>
			<a class="banner-btn c" href="{{ action('ProfileController@showLikes') }}">My Likes</a>
		</div>

	</div>

	@if($ident == 'account')
		@include('profile.account')
	@endif

	@if($ident == 'reviews')
		@include('profile.myReviews')
	@endif

	@if($ident == 'likes')
		@include('profile.myLikes')
	@endif

</div>
@endsection