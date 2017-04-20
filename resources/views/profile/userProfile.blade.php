@extends('layouts.app')

@section('content')

{{Html::style('css/profile.css')}}

<style>
	.pic-box {
		@if($user->avatar == null)
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
				@if($user->avatar == null)
					{{ substr($user->username, 0, 1) }}
				@else 
					<img src="{{ URL::asset('images/avatars/'.$user->avatar.'') }}" style="width: 100%; height: 100%; background-size: cover; border-radius: 50%;">
				@endif
				</div>
				<div class="stat-container">
					<div class="stat-username">{{ $user->username }}</div>
					<div class="stat-stats">
						<div class="stat1">
							<div class="avg-scr">
							@if(App\Utilities::getAvgUserRating($user->id, 'movie') != null)
								{{ number_format(App\Utilities::getAvgUserRating($user->id, 'movie'), 2) }}
							@else
								N/A
							@endif
							</div>
							<div class="avg-txt">Average Movie Score</div>
						</div>
						<div class="stat2">
							<div class="avg-scr">
							@if(App\Utilities::getAvgUserRating($user->id, 'tvshow') != null)
								{{ number_format(App\Utilities::getAvgUserRating($user->id, 'tvshow'), 2) }}
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
			<a class="banner-btn c" href="{{ action('ProfileController@showProfile', $user->id) }}">{{ $user->username }}'s Likes</a>
			<a class="banner-btn b" style="width: 130px;" href="{{ action('ProfileController@userReviews', $user->id) }}">{{ $user->username }}'s Reviews</a>
		</div>
		
	</div>

	@if($ident == 'reviews')
		@include('profile.myReviews')
	@endif

	@if($ident == 'likes')
		@include('profile.myLikes')
	@endif
		
</div>
@endsection