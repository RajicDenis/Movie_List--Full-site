@extends('layouts.app')

@section('content')

{{ Html::style('css/reviews.css') }}

<style>
	.tvshow-review { 
	    width: 70%;
	}
	.glyphicon-star, .glyphicon-star-empty {
		font-size: 15px;
	}
	.user-rating {
		pointer-events: none;
	}
	.red {
	    font-size: 30px;
	    font-family: 'Amaranth', sans-serif;
    	padding-bottom: 20px;
	}
	.switch-btn {
		width: 220px;
	}
	.info {
		text-align: center;
		font-family: 'Amaranth', sans-serif;
	}

	@media screen and (max-width: 1300px) {
		.rev-stats {
			display: none;
		}
		.tvshow-review {
			width: 100%;
		}
	}
</style>

<div class="review-box col-md-10 col-md-offset-1"> 
	<div class="tvshow-review">
		<h4 class="red">TV Show Reviews</h4>
		<div class="tvrev-box">
		@if(count($tv_rev) != 0)
			@foreach($tv_rev as $review)
						
				<a href="{{ action('ReviewController@showReview', [$review->movie_id, $review->user_id]) }}">
					<div class="review hs" style="position: relative; @if(App\Utilities::getMovie($review->movie_id)->banner != null) background-image: url({{ URL::asset('images/banners/'.App\Utilities::getMovie($review->movie_id)->banner.'') }}); @endif"> 
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
				
			@endforeach	

			<div class="tvrev_pgn">{!! $tv_rev->render() !!}</div>

		@else
			<h3 class="info">No reviews added yet!</h3>
		@endif

		</div>

	</div>

	<div class="rev-stats">
			<a href="{{ action('ReviewController@index') }}" class="switch-btn redbg">Switch to Movies!</a>

			<div class="stat-box">
				<div class="stat-title">REVIEW STATS</div>
				<div class="stat-info">Total Reviews: <span>{{ App\Utilities::getReviewStat('total') }}</span></div>
				<div class="stat-info">Movie Reviews: <span>{{ App\Utilities::getReviewStat('movies') }}</span></div>
				<div class="stat-info">TV Show Reviews: <span>{{ App\Utilities::getReviewStat('tvshows') }}</span></div>
				<div class="stat-info">AVG review score: <span>{{ number_format(App\Utilities::getReviewStat('avg'), 2) }}</span></div>
			</div>
		</div>

</div>


@endsection