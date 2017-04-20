{{ Html::style('css/reviews.css') }}

<style>
	.glyphicon-star, .glyphicon-star-empty {
		font-size: 15px;
	}
	.user-rating {
		pointer-events: none;
	}
	.norev-info {
		font-family: 'Amaranth', sans-serif;
		font-size: 25px;
		text-align: center;
	}
	.review-box, .movie-review, .tvshow-review {
		min-height: 200px !important;
	}
	.review-box {
		margin-bottom: 50px;
	}
	.red {
		height: 40px;
		font-size: 25px;
		font-family: 'Amaranth', sans-serif;
	}
	.b {
		color: #080808;
		background: #EF3051;
		-webkit-transition: all 0.2s ease-in-out;
		transition: all 0.2s ease-in-out;
	}

</style>

@php $countM = 0; $countTV = 0; $userid = ''; @endphp

@if(!isset($user))
	{{ $userid = Sentinel::getUser()->id }}
@else
	{{ $userid = $user->id }}
@endif

<div class="review-box col-md-8 col-md-offset-2">
	<div class="movie-review">
	<h4 class="red">Movie Reviews</h4>
		@foreach($movie_rev as $review)
			@if($review->user_id == $userid)
				
				<a href="{{ action('ReviewController@showReview', [$review->movie_id, $review->user_id]) }}">
					<div class="review hs" style="position: relative; @if(App\Utilities::getMovie($review->movie_id)->banner != null) background-image: url({{ URL::asset('images/banners/'.App\Utilities::getMovie($review->movie_id)->banner.'') }});@endif"> 
						<div class="desc">
							<div class="desc-box">
								<span class="review-title">{{ App\Utilities::getMovie($review->movie_id)->title }}</span>
								<p class="recap">{{ $review->rev_recap }}</p>
							</div>
						</div>
						<div class="rating">
							<div class="user-rating"><input class="rev-star" id="{{ $review->rev_rating }}" type="text" class="rating" data-size="xxs"></div>
							<div class="review-by"><span class="reviewed-by-text">Reviewed by {{ App\Utilities::getUser($review->user_id)->username }}</span></div>
						</div>
					</div>
				</a>

				@php $countM += 1; @endphp
				
			@endif
			
		@endforeach

		@if($countM == 0)
			<h3 class="norev-info">No reviews yet!</h3>
		@endif

	</div>
	<div class="tvshow-review">
	<h4 class="red">TV Show Reviews</h4>
		@foreach($tv_rev as $review)
			@if($review->user_id == $userid)
				
				<a href="{{ action('ReviewController@showReview', [$review->movie_id, $review->user_id]) }}">
					<div class="review hs" style="position: relative; @if(App\Utilities::getMovie($review->movie_id)->banner != null) background-image: url({{ URL::asset('images/banners/'.App\Utilities::getMovie($review->movie_id)->banner.'') }});@endif"> 
						<div class="desc">
							<div class="desc-box">
								<span class="review-title">{{ App\Utilities::getMovie($review->movie_id)->title }}</span>
								<p class="recap">{{ $review->rev_recap }}</p>
							</div>
						</div>
						<div class="rating">
							<div class="user-rating"><input class="rev-star" id="{{ $review->rev_rating }}" type="text" class="rating" data-size="xxs"></div>
							<div class="review-by"><span class="reviewed-by-text">Reviewed by {{ App\Utilities::getUser($review->user_id)->username }}</span></div>
						</div>
					</div>
				</a>

				@php $countTV += 1; @endphp
				
			@endif
			
		@endforeach
		
		@if($countTV == 0)
			<h3 class="norev-info">No reviews yet!</h3>
		@endif

	</div>
</div>
