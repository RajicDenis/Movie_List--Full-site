@extends('layouts.app')

@section('content')

{{ Html::style('css/reviews.css') }}
{{ Html::style('css/news.css') }}

<div class="newscontainer col-md-8 col-md-offset-2">

	<div class="newsbox"> 

		<div class="feed-box">

			<div class="pop-title red">Most Popular Movies</div>
			
			<div class="popularBox">
				
				@if($popMovie1 != null && $popMovie2 != null && $popMovie3 != null)

					<a href="{{ action('BrowseController@showMovie', $popMovie1->id) }}" class="pop_top" style="background-image: url({{ URL::asset('images/banners/'.$popMovie1->banner.'') }})"><span class="title">{{ $popMovie1->title.' ('.$popMovie1->year.')' }}</span></a>

					<div class="pop_bottom">

						<a href="{{ action('BrowseController@showMovie', $popMovie2->id) }}" class="btm-left" style="background-image: url({{ URL::asset('images/banners/'.$popMovie2->banner.'') }})"><span class="title">{{ $popMovie2->title.' ('.$popMovie2->year.')' }}</span></a>

						<a href="{{ action('BrowseController@showMovie', $popMovie3->id) }}" class="btm-right" style="background-image: url({{ URL::asset('images/banners/'.$popMovie3->banner.'') }})"><span class="title">{{ $popMovie3->title.' ('.$popMovie3->year.')' }}</span></a>

					</div>
				
				@else

					<div class="null-placeholder">Not enough movies added yet!</div>

				@endif
				
			</div>
		
		
			<div class="pop-title red">Most Popular TV Shows</div>

			<div class="popularBox">

			@if($popTV1 != null && $popTV2 != null && $popTV3 != null)

				<a href="{{ action('BrowseController@showMovie', $popTV1->id) }}" class="pop_top" style="background-image: url({{ URL::asset('images/banners/'.$popTV1->banner.'') }})"><span class="title">{{ $popTV1->title.' ('.$popTV1->year.')' }}</span></a>

				<div class="pop_bottom">

					<a href="{{ action('BrowseController@showMovie', $popTV2->id) }}" class="btm-left" style="background-image: url({{ URL::asset('images/banners/'.$popTV2->banner.'') }})"><span class="title">{{ $popTV2->title.' ('.$popTV2->year.')' }}</span></a>

					<a href="{{ action('BrowseController@showMovie', $popTV3->id) }}" class="btm-right" style="background-image: url({{ URL::asset('images/banners/'.$popTV3->banner.'') }})"><span class="title">{{ $popTV3->title.' ('.$popTV3->year.')' }}</span></a>

				</div>

			@else

				<div class="null-placeholder">Not enough TV Shows added yet!</div>

			@endif

			</div>		

		</div>
		

		<div class="infofeed">

			<div class="newmovies">
				<div class="infotitle">New Movies</div>	
				<div class="thumb-box">
					@if(count($newMovies) != null)

						@foreach($newMovies as $m)
							@if($m->poster != null)
								<a href="{{ action('BrowseController@showMovie', $m->id) }}"><img class="thumb h" src="{{ URL::asset('images/posters/'.$m->poster.'') }}" /></a>
							@else
								<a href="{{ action('BrowseController@showMovie', $m->id) }}"><img class="thumb h" src="{{ URL::asset('images/posters/noposter.jpg') }}" /></a>
							@endif
						@endforeach

					@else
						<h3 style="font-family: 'Amaranth'; font-weight: 600; font-style: italic;">No Movies added yet</h3>
					@endif
				</div>
			</div>

			<div class="newtv">
				<div class="infotitle">New TV Shows</div>	
				<div class="thumb-box">
					@if(count($newTV) != null)

						@foreach($newTV as $tv)
							@if($m->poster != null)
								<a href="{{ action('BrowseController@showMovie', $tv->id) }}"><img class="thumb h" src="{{ URL::asset('images/posters/'.$tv->poster.'') }}" /></a>
							@else
								<a href="{{ action('BrowseController@showMovie', $tv->id) }}"><img class="thumb h" src="{{ URL::asset('images/posters/noposter.jpg') }}" /></a>
							@endif
						@endforeach

					@else
						<h3 style="font-family: 'Amaranth'; font-weight: 600; font-style: italic;">No TV Shows added yet</h3>
					@endif
				</div>
			</div>

			<div class="latest-reviews">
				<div class="infotitle">Latest Reviews</div>	
				<div class="rev">
				@if(count($newReviews) != null)
					@foreach($newReviews as $r)
						<a href="{{ action('ReviewController@showReview', [$r->movie_id, $r->user_id]) }}"><div class="review hs" style="background-image: url({{ URL::asset('images/banners/'.$r->banner.'') }});">
							<div class="desc">
								<div class="desc-box">
									<span class="review-title">{{ $r->title }}</span>
									<p class="recap">{{ $r->rev_recap }}</p>
								</div>
							</div>
							<div class="rating">
								<div class="user-rating"><input class="rev-star" id="{{ $r->rev_rating }}" type="text" class="rating" data-size="xxs"></div>
								<div class="review-by"><span class="reviewed-by-text">Reviewed by {{ $r->username }}</span></div>
							</div>
						</div></a>
					@endforeach

				@else
					<h3 style="font-family: 'Amaranth'; font-weight: 600; font-style: italic; text-align: center;">No Reviews added yet</h3>
				@endif

				</div>
			</div>

		</div>
	</div>

	<div class="highlights">
		
		<div class="hb1">
			<div class="hb-top"><span class="fa fa-th-list fa-2x red hli" aria-hidden="true"></span> Create and share Lists!</div>
			<div class="hb-bottom">Compile a list of your favorite movies and TV shows and share it with other users!</div>
		</div>

		<div class="hb1">
			<div class="hb-top"><span class="fa fa-star-half-o fa-2x red hli" aria-hidden="true"></span> Rank your Movies!</div>
			<div class="hb-bottom">Rank your favorite movies and shows using our 10-point system!</div>
		</div>

		<div class="hb1">
			<div class="hb-top"><span class="fa fa-pencil-square-o fa-2x red hli" aria-hidden="true"></span> Write Reviews!</div>
			<div class="hb-bottom">Read movie reviews of other users, score them or write a review of your favorite movies and share it with others!</div>
		</div>

	</div>


	@if(count($lists) != 0)

		<div class="listbox">
			<div class="pop-title red">New Lists</div>	

			<div class="newlists">

				@foreach($lists as $list)
					@if(App\Utilities::hasFourPosters($list->id) == true)
						@if($list->user_id != Sentinel::getUSer()->id)
							<a class="lnk" href="{{ action('MovieListController@showList', ['uid' => $list->user_id, 'mid' => $list->id]) }}">
						@else
							<a class="lnk" href="{{ action('MovieListController@switchList', $list->id) }}">
						@endif
						<div class="single-list hs">
				
							<div class="content-top">{{ $list->name }}</div>			
							
							<div class="list-img-box">
								@for($i = 0; $i < 4; $i++)
									<img class="list-img" src="{{ URL::asset('images/posters/'.App\Utilities::getMoviesInList($list->id)[$i].'') }}">
								@endfor
							</div>					

						</div></a>	
					@endif
				@endforeach

			</div>

		</div>

	@endif

</div>

@endsection