@extends('layouts.app')

@section('content')

{{Html::style('css/showReview.css')}}

<div class="col-md-8 col-md-offset-2">
	<div class="rev-container">

		<div class="rev-left">
		
			<img class="content-poster" src="{{ URL::asset('images/posters/'.$movie->poster) }}">

			<div class="panel">
				<div class="panel-heading">More details</div>
				<div class="panel-body">
				    <a href="{{ $movie->imdb }}"><div class="link1"><img style="width: 25px; height: 15px; margin-right: 10px;" src="{{ URL::asset('images/icons/imdb.png') }}">IMDb</div></a>
				    <a href="{{ $movie->tmdb }}"><div class="link2"><img style="width: 25px; height: 25px; margin-right: 10px;" src="{{ URL::asset('images/icons/tmdb.jpg') }}">TMDb</div></a>
				</div>
			</div>
		
		</div>

		<div class="rev-right">
			@foreach($review as $u)

				<div class="rev-by">
					<span class="rev-by-box"><img src="{{ URL::asset('images/admin.jpg') }}" class="rev-profile">
						<span class="rev-by-txt">Reviewed by 
							@if($u->id != Sentinel::getUSer()->id)
								<a class="profile_link" href="{{ action('ProfileController@showProfile', $u->id) }}">{{ $u->username }}</a>
							@else
								<a class="profile_link" href="{{ action('ProfileController@showAccount') }}">{{ $u->username }}</a>
							@endif
						</span>
					</span>
					<span class="rev-date">{{ date('d F Y', strtotime($u->pivot->rev_date)) }}</span>
				</div>

				<div class="rev-title-box">
					<div class="total-likes"><span class="g glyphicon glyphicon-heart roh red" aria-hidden="true"></span>{{ $u->pivot->rev_total_likes.' Likes' }}</div>
					<div class="rev-title">{{ $movie->title.' ('.$movie->year.')' }}</div>
					@if($u->id != Sentinel::getUser()->id) 
						@if(count($revLike) != null)
							@if($revLike->contains('user_id', Sentinel::getUser()->id))
								@foreach($revLike as $like)
									
									@if($like->user_id == Sentinel::getUser()->id && $like->review_id == $u->pivot->id) 
										@if($like->likes == 0)                               
											<div class="rev-like"><span id="like_review" class="glyphicon glyphicon-heart-empty" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Like"></span></div>
										@else
											<div class="rev-like"><span class="g glyphicon glyphicon-heart red" aria-hidden="true"></span></div>
										@endif
									@endif
								
								@endforeach
							@else
								<div class="rev-like"><span id="like_review" class="g glyphicon glyphicon-heart-empty" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Like"></span></div>
							@endif
						@else
							<div class="rev-like"><span id="like_review" class="g glyphicon glyphicon-heart-empty" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Like"></span></div>
						@endif
					@endif
				</div>

				<div class="rev-text">{!! nl2br(e($u->pivot->review)) !!}</div>

				<div class="star_rating" data-mid="{{ $movie->id }}" data-uid="{{ $u->id }}" data-rid="{{ $u->pivot->id }}" style="display: none;">{{ $u->pivot->rev_rating }}</div>
				<div class="rev-stars"><input id="review_rate" type="text" class="rating" data-size="lg"></div>

			@endforeach
		</div>

	</div>
</div>

@endsection