@extends('layouts.app')

@section('content')

{{Html::style('css/modal.css')}}
{{Html::style('css/browse.css')}}
<style>
	.filter-body1 {
		@if($year != 'all' || $order != null)
        border-bottom: 1px solid #abc;
        @endif
	}
</style>

<div class="browse-container">

	<div class="searchbar">
			<form class="search_form" action="{{ action('BrowseController@indexTV', ['year' => $year, 'order' => $order]) }}" method="GET">			
			    <div class="input-group">
			        {{ Form::text('srch_term', Request::get('srch_term'), ['class' => 'search-txt', 'placeholder' => 'Search...']) }}
			    </div>			  	
			</form>
	</div>

	<div class="search-body">
		
		<div class="filter">

			<div class="switch">
				<form class="switch-form" method="GET" action="{{ action('BrowseController@index', ['year' => 'all']) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">	
					<button class="switch-btn" type="submit">Switch to Movies</button>
				</form>
			</div>

			<div class="filter-options">

				<div class="dropdown">
					<div class="opt1" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						
						<span class="year-txt">Year</span>

					</div>

					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					@for($i = date('Y'); $i > 1950; $i--)
					    <li class="drop-year"><a class="f-year" href="{{ action('BrowseController@indexTV', ['year' => $i, 'order' => $order]) }}">{{ $i }}</a></li>
					@endfor
					</ul>
				</div>

				<div class="dropdown">
					<div class="opt2" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Sort By</div>
					<ul class="dropdown-menu dm2" aria-labelledby="dropdownMenu2">
						<li class="drop-genre"><a href="{{ action('BrowseController@indexTV', ['year' => $year, 'order' => 'popdesc']) }}">Popularity<span class="glyphicon glyphicon-chevron-down chev" aria-hidden="true"></span></a></li>
						<li class="drop-genre"><a href="{{ action('BrowseController@indexTV', ['year' => $year, 'order' => 'popasc']) }}">Popularity<span class="glyphicon glyphicon-chevron-up chev" aria-hidden="true"></span></a></li>
						<li class="drop-genre"><a href="{{ action('BrowseController@indexTV', ['year' => $year, 'order' => 'scoredesc']) }}">Score<span class="glyphicon glyphicon-chevron-down chev" aria-hidden="true"></span></a></li>
						<li class="drop-genre"><a href="{{ action('BrowseController@indexTV', ['year' => $year, 'order' => 'scoreasc']) }}">Score<span class="glyphicon glyphicon-chevron-up chev" aria-hidden="true"></span></a></li>
					</ul>
				</div>

				<div class="opt3">
					
					<div class="opt3-header">Genres</div>

					<div class="opt3-body">
						@foreach($allgenres as $g)
							<div class="genre">
								<span class="glyphicon glyphicon-plus cal ml" aria-hidden="true"></span>
								<span class="genre-name">{{ $g->name }}</span>
							</div>
						@endforeach
					</div>

				</div>
				
			</div>
		</div>

		
		<div class="filter-body">
			<div class="filter-body1">

				<div class="f-yearbox">
					@if($year != 'all') 
						<span class="f-yearboxtxt">Year: {{ $year }}</span> 
						<a href="{{ action('BrowseController@indexTV', ['year' => 'all', 'order' => $order]) }}" class="glyphicon glyphicon-remove red remove_year"></a>
					@endif
				</div>
				
				<div class="f-yearbox">
					@if($order != null) 
						<span class="f-yearboxtxt fy2">Order By: 
						@if($order == 'popdesc') Popularity (Descending) @endif
						@if($order == 'popasc') Popularity (Ascending) @endif
						@if($order == 'scoredesc') User Score (Descending) @endif
						@if($order == 'scoreasc') User Score (Ascending) @endif
						</span> 
						<a href="{{ action('BrowseController@indexTV', ['year' => $year, 'order' => null]) }}" class="glyphicon glyphicon-remove red remove_year"></a>
					@endif
				</div>

			</div>
			<div class="filter-body fb2">
			@if(count($tvshows) != 0)
				@foreach($tvshows as $movie)
						
					<div class="srch-box">
						<div class="search-item">					
							<div class="title"><a href="{{ action('BrowseController@showMovie', $movie->id) }}"><span class="title-txt">{{ $movie->title }}</span></a></div>
							@if($movie->poster == null)
								<img class="item-img" src="{{ asset('images/posters/noposter.jpg') }}">
							@else
								<img class="item-img" src="{{ asset('images/posters/'.$movie->poster) }}">
							@endif
							@if(Sentinel::check())
								<a class="heart" href="#" data-id="{{ $movie->id }}" data-toggle="modal" data-target="#addMovieModal_{{$movie->id}}"><div class="addmovie" data-toggle="tooltip" data-placement="top" title="Add TV Show to list!"><i class="fa fa-heart" aria-hidden="true"></i></div></a>
							@else
								<a class="heart" href="#"><div class="addmovie" data-toggle="tooltip" data-placement="top" title="Sign in to add TV Show to list!"><i class="fa fa-heart" aria-hidden="true"></i></div></a>
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

					<div class="browse_pgn">{!! $tvshows->links() !!}</div>
			
			@else
				<h3 style="font-family: 'Amaranth', sans-serif;">No TV Shows added yet!</h3>
			@endif

			</div>
		</div>
		
	</div>

</div>

@endsection