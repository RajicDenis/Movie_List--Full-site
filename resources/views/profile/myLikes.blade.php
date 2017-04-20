{{ Html::style('css/reviews.css') }}

<style>
	.like-box {
		display: flex;
		flex-direction: column;
	}
	.movie-likes {
		display: flex;
		flex-direction: column;
		width: 100%;
	}
	.thumb {
		height: 150px;
		width: 100px;
		margin-right: 30px;
		cursor: pointer;
	    box-shadow: 5px 5px 8px rgba(8,8,8,0.5);
    	border-radius: 15px;
	}
	.m_likes {
		display: flex;
		justify-content: center;
		align-items: center;
		flex-wrap: wrap;
	}
	.likes-title {
		text-align: center;
		font-family: 'Amaranth', sans-serif;
		font-size: 25px;
		color: white;
		font-style: italic;
		margin: 40px 0;
	}
	h3 {
		font-family: 'Amaranth', sans-serif;
	}
	.single-img {
		margin-bottom: 25px;
	}
	.c {
		color: #080808;
		background: #EF3051;
		-webkit-transition: all 0.2s ease-in-out;
		transition: all 0.2s ease-in-out;
	}
</style>

@php $countM = 0; $countTV = 0; $countRev = 0; $userid = ''; @endphp

@if(!isset($user))
	{{ $userid = Sentinel::getUser()->id }}
@else
	{{ $userid = $user->id }}
@endif

<div class=" like-box col-md-8 col-md-offset-2">
	
	<div class="movie-likes">
		<h2 class="likes-title">Liked Movies</h2>

		<div class="m_likes">
		
			@foreach($movies as $movie)
				@foreach($movie->users as $m)
				
					@if($m->pivot->user_id == $userid)
						@if($m->pivot->likes == 1)
							@if($countM < 45)
								<a class="single-img" href="{{ action('BrowseController@showMovie', $m->pivot->movie_id) }}"><img class="thumb h" src="{{ URL::asset('images/posters/'.$movie->poster.'') }}" /></a>

								@php $countM += 1; @endphp
							@endif
						@endif
					@endif

				@endforeach
			@endforeach
		
			@if($countM == 0)
				<h3>You have not liked any Movies yet!</h3>
			@endif
		</div>
	</div>

	<div class="tv-likes">
		<h2 class="likes-title">Liked TV Shows</h2>

		<div class="m_likes">
			@foreach($tvshows as $tvshow)
				@foreach($tvshow->users as $tv)
					@if($tv->pivot->user_id == $userid)
						@if($tv->pivot->likes == 1)
							@if($countTV < 45)
								<a class="single-img" href="{{ action('BrowseController@showMovie', $tv->pivot->movie_id) }}"><img class="thumb h" src="{{ URL::asset('images/posters/'.$tvshow->poster.'') }}" /></a>

								@php $countTV += 1; @endphp
							@endif
						@endif
					@endif
				@endforeach
			@endforeach

			@if($countTV == 0)
				<h3>You have not liked any TV Shows yet!</h3>
			@endif
		</div>
	</div>

	<div class="review-likes">
		<h2 class="likes-title">Liked Reviews</h2>

		<div class="m_likes">
			@foreach($allMovies as $movie)
				@foreach($movie->users as $u)
					@foreach($reviews as $r)
						@if($r->review_id == $u->pivot->id)
							@if($countTV < 45)
								<a style="width: 100%;" href="{{ action('ReviewController@showReview', [$u->pivot->movie_id, $u->id]) }}"><div class="review hs" style="position: relative; background-image: url({{ URL::asset('images/banners/'.$movie->banner.'') }});"> 
									<div class="desc">
										<div class="desc-box">
											<span class="review-title">{{ $movie->title }}</span>
											<p class="recap">{{ $u->pivot->rev_recap }}</p>
										</div>
									</div>
									<div class="rating">
										<div class="user-rating"><input class="rev-star" id="{{ $u->pivot->rev_rating }}" type="text" class="rating" data-size="xxs"></div>
										<div class="review-by"><span class="reviewed-by-text">Reviewed by {{ $u->username }}</span></div>
									</div>
								</div></a>
							
								@php $countRev += 1; @endphp
							@endif
						@endif
					@endforeach
				@endforeach
			@endforeach

			@if($countRev == 0)
				<h3>You have not liked any Reviews yet!</h3>
			@endif
		</div>
	</div>

</div>