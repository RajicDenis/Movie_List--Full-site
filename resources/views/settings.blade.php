@extends('layouts.app')

@section('content')

{{Html::style('css/settings.css')}}

<style>
	.main {
		background-image: none;
	}
	.footer {
		display: none;
	}
</style>

<div class="top col-md-10 col-md-offset-1">

	<ul class="nav nav-tabs" id="settingsTab">
	  <li role="presentation" class="m tb active"><a class="tab-title" href="#1a" data-toggle="tab">Movies</a></li>
	  <li role="presentation" class="t tb"><a class="tab-title" href="#2a" data-toggle="tab">TVshows</a></li>
	  <li role="presentation" class="g tb"><a class="tab-title" href="#3a" data-toggle="tab">Genres</a></li>
	</ul>

	<div class="tab-content clearfix">
		<div class="tab-pane active" id="1a" class="tab1">
        	
        	<form class="form-horizontal movie-form" action="{{ action('MovieController@store') }}" role="form" files="true" enctype="multipart/form-data" method="POST">
				
        		@if(Session::has('movie'))
        		<div class="center">
					<div class="alert {{ Session::get('alert_type') }} fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{ Session::get('movie') }}
					</div>
				</div>
				@endif

				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<input type="hidden" name="type" value="movie">

        		<div class="form-group">
				    <label class="control-label col-sm-3" for="title">Movie Title</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="title" required>

				        @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="year">Release Year</label>
				    <div class="col-sm-4"> 
				      <input type="number" class="form-control" name="year" min=1800 max=3000 required>

				        @if ($errors->has('year'))
                        <span class="help-block">
                            <strong>{{ $errors->first('year') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="summary">Summary</label>
				    <div class="col-sm-4">
				      <textarea rows="6" class="form-control" name="summary"></textarea>

				        @if ($errors->has('summary'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="language">Languages</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="language">

				        @if ($errors->has('language'))
                        <span class="help-block">
                            <strong>{{ $errors->first('language') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="country">Country</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="country">

				        @if ($errors->has('country'))
                        <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="genres">Genres</label>
				    <div class="col-sm-4">
				    	<select class="form-control select2" name="genres[]" multiple="multiple" required>
				    	@foreach($genres as $g)
				    		<option value="{{ $g->id }}">{{ $g->name }}</option>
			    		@endforeach
				    	</select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="imdb">IMDb Link</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="imdb">

				        @if ($errors->has('imdb'))
                        <span class="help-block">
                            <strong>{{ $errors->first('imdb') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="tmdb">TMDb Link</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="tmdb">

				        @if ($errors->has('tmdb'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tmdb') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="poster">Movie Poster</label>
				    <div class="col-sm-4"> 
				      <input type="file" name="poster">
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="banner">Movie Banner</label>
				    <div class="col-sm-4"> 
				      <input type="file" name="banner">
				    </div>
				  </div>
				 
				  <div class="form-group"> 
				      <button type="submit" class="btn btn-success">Add Movie</button>
				  </div>
				
        	</form>
			
			@if(count($movies) != 0)

				<div class="table-name top"><h3>Added Movies</h5></div>

	        	<div class="table-responsive" id="movietable">
					<table class="table">
				    	<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Year</th>
								<th>Summary</th>
								<th>Genres</th>
								<th></th>
								<th></th>
							</tr>
							
						</thead>

						<tbody>
							@php ($i=1)
							@foreach($movies as $movie)
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $movie->title }}</td>
								<td>{{ $movie->year }}</td>
								<td>{{ $movie->summary }}</td>
								<td>@foreach($movie->genres as $g) {{ $g->name }} @endforeach</td>
								<td class="w40">
									<form action="{{ action('MovieController@edit', $movie->id) }}" method="GET">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">	
										<input type="hidden" name="type" value="movie">
										<button type="submit" class="btn btn-warning btn-xs">Edit</button>										
									</form>
								</td>
								<td class="w40">
									<form action="{{ action('MovieController@remove', $movie->id) }}" method="POST">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">	
										<input type="hidden" name="type" value="movie">
										<button type="submit" class="btn btn-danger btn-xs">Delete</button>										
									</form>
								</td>
							</tr>
							@php ($i++)
							@endforeach
						</tbody>
					</table>
				</div>
			@else
				<h4 class="info-msg">No Movies added yet</h4>
			@endif

		</div>

		<div class="tab-pane" id="2a" class="tab2">

			<form class="form-horizontal movie-form" action="{{ action('MovieController@store') }}" role="form"  files="true" enctype="multipart/form-data" method="POST">

				@if(Session::has('tv'))
				<div class="center">
					<div class="alert {{ Session::get('alert_type') }} fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{ Session::get('tv') }}
					</div>
				</div>
				@endif

				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="type" value="tvshow">

        		  <div class="form-group">
				    <label class="control-label col-sm-3" for="title">TVShow Title</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="title" required>

				        @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="year">Release Year</label>
				    <div class="col-sm-4"> 
				      <input type="number" class="form-control" name="year" min=1800 max=3000 required>

				        @if ($errors->has('year'))
                        <span class="help-block">
                            <strong>{{ $errors->first('year') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="summary">Summary</label>
				    <div class="col-sm-4">
				      <textarea rows="6" class="form-control" name="summary"></textarea>

				        @if ($errors->has('summary'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="language">Languages</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="language">

				        @if ($errors->has('language'))
                        <span class="help-block">
                            <strong>{{ $errors->first('language') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="country">Country</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="country">

				        @if ($errors->has('country'))
                        <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				   <div class="form-group">
				    <label class="control-label col-sm-3" for="genres">Genres</label>
				    <div class="col-sm-4">
				    	<select class="form-control select2" name="genres[]" multiple="multiple" required>
				    	@foreach($genres as $g)
				    		<option value="{{ $g->id }}">{{ $g->name }}</option>
			    		@endforeach
				    	</select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="status">Status</label>
				    <div class="col-sm-4">
				    	<select class="form-control" name="status">
				    		<option value="1">Airing</option>
				    		<option value="2">Completed</option>
				    		<option value="3">Canceled</option>
				    		<option value="4">Not yet aired</option>
				    	</select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="imdb">IMDb Link</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="imdb">

				        @if ($errors->has('imdb'))
                        <span class="help-block">
                            <strong>{{ $errors->first('imdb') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="tmdb">TMDb Link</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="tmdb">

				        @if ($errors->has('tmdb'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tmdb') }}</strong>
                        </span>
                    	@endif

				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="poster">TVShow Poster</label>
				    <div class="col-sm-4"> 
				      <input type="file"  name="poster">
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="control-label col-sm-3" for="banner">TVShow Banner</label>
				    <div class="col-sm-4"> 
				      <input type="file"  name="banner">
				    </div>
				  </div>
				 
				  <div class="form-group"> 
				      <button type="submit" class="btn btn-success">Add TVShow</button>
				  </div>
				
        	</form>

			@if(count($tvshows) != 0)

				<div class="table-name top"><h3>Added TV shows</h5></div>

				<div class="table-responsive" id="tvtable">
					<table class="table">
				    	<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Year</th>
								<th>Summary</th>
								<th>Genres</th>
								<th>Status</th>
								<th></th>
								<th></th>
							</tr>
							
						</thead>

						<tbody>
							@php ($i=1)
							@foreach($tvshows as $tv)
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $tv->title }}</td>
								<td>{{ $tv->year }}</td>
								<td>{{ $tv->summary }}</td>
								<td>@foreach($tv->genres as $g) {{ $g->name }} @endforeach</td>
								<td>
									@if($tv->status == 1) {{'Airing'}}
									@elseif ($tv->status == 2) {{'Completed'}}
									@elseif ($tv->status == 3) {{'Canceled'}}
									@else {{'Not yet aired'}}
									@endif
								</td>
								<td class="w40">
									<form action="{{ action('MovieController@edit', $tv->id) }}" method="GET">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">	
										<input type="hidden" name="type" value="tvshow">
										<button type="submit" class="btn btn-warning btn-xs">Edit</button>										
									</form>
								</td>
								<td class="w40">
									<form action="{{ action('MovieController@remove', $tv->id) }}" method="POST">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">	
										<input type="hidden" name="type" value="tvshow">
										<button type="submit" class="btn btn-danger btn-xs">Delete</button>										
									</form>
								</td>
							</tr>
							@php ($i++)
							@endforeach
						</tbody>
					</table>
				</div>
			@else
				<h4 class="info-msg">No TV show added yet</h4>
			@endif

        
		</div>

        <div class="tab-pane" id="3a" class="tab3">
        	<form class="form-horizontal movie-form" action="{{ action('GenreController@store') }}" id="frm3" role="form" method="POST">

				@if(Session::has('genre'))
				<div class="center">
					<div class="alert {{ Session::get('alert_type') }} fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{ Session::get('genre') }}
					</div>
				</div>
				@endif	

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

        		<div class="form-group gi">
				    <label class="control-label p col-sm-3" for="name">Genre</label>
				    <div class="col-sm-4">
				    	<input type="text" class="form-control gnr-input" name="name" id="genre" required>
				    </div>
				</div>
				 
				<div class="form-group"> 
				    	<button type="submit" class="btn btn-success">Add Genre</button>
				</div>

				@if(count($genres) != 0)
					<div class="genres-box">
						@if(is_array($genres) || is_object($genres))
						<div class="genres-title">Added Genres</div>
						<div class="genres-name" id="genrebox">
							@foreach($genres as $g)
								<span class="gnr">{{ $g->name }}<a href="{{ action('GenreController@remove', ['id' => $g->id]) }}" class="glyphicon glyphicon-remove r" aria-hidden="true"></a></span>
							@endforeach
						</div>	
						@endif
					</div>
				@else
					<h4 class="info-msg">No genre added yet</h4>
				@endif
				
        	</form>
        
		</div> 

	</div>

</div>

@endsection