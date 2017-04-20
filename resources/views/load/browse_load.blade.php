@foreach($movies as $movie)
					
	<div class="srch-box">
		<div class="search-item">					
			<div class="title"><a href="{{ action('BrowseController@showMovie', $movie->id) }}"><span class="title-txt">{{ $movie->title }}</span></a></div>
			<img class="item-img" src="{{ asset('images/posters/'.$movie->poster) }}">
			@if(Sentinel::check())
				<a class="heart" href="#" data-id="{{ $movie->id }}" data-toggle="modal" data-target="#addMovieModal_{{$movie->id}}"><div class="addmovie" data-toggle="tooltip" data-placement="top" title="Add movie to list!"><i class="fa fa-heart" aria-hidden="true"></i></div></a>
			@else
				<a class="heart" href="#"><div class="addmovie" data-toggle="tooltip" data-placement="top" title="Sign in to add movie to list!"><i class="fa fa-heart" aria-hidden="true"></i></div></a>
			@endif

			@include('layouts.listModal')
			
		</div>

		<div class="search-item-desc">
			
			<div class="sid-top">
				<div class="st-title">
					<div class="st-txt">{{ $movie->title }}</div>		
					<div class="st-star">
					@if(App\Utilities::getRating($movie->id) != null)
						<span class="star-txt">{{ App\Utilities::getRating($movie->id) }}</span><span class="glyphicon glyphicon-star red cal ml" aria-hidden="true"></span>
					@else
						<span class="star-txt">N/A</span><span class="glyphicon glyphicon-star red cal ml" aria-hidden="true"></span>		
					@endif	
					</div>			
				</div>
				<div class="st-genre">
					<div class="st-year"><span class="glyphicon glyphicon-calendar cal red" aria-hidden="true"></span><span class="movie_year">{{ $movie->year }}</span>
					</div>
					<div class="st-gnr-box">
						@foreach($movie->genres as $m)	
							<div class="st-gnr">{{ $m->name }}</div>
						@endforeach	
					</div>
				</div>
			</div>

			<div class="sid-middle"><span class="sm-rev">{!! Str::words($movie->summary, 45, '...')  !!}</span></div>

			<a href="{{ action('BrowseController@showMovie', $movie->id) }}" class="sid-bottom"><span class="more-info">More info...</span></a>

		</div>
	</div>
				
@endforeach