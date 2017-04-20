@extends('layouts.app')

@section('content')

<style>
	.main {
		background-image: none;
	}
	.select2-results__option, .select2-selection__choice {
		color: black !important;
	}
</style>

<div class="col-md-8 col-md-offset-2">
	<form class="form-horizontal movie-form" action="{{ action('MovieController@update', $movie->id) }}" role="form" method="POST">

		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		@if($ident == 'tvshow')		
			<input type="hidden" name="type" value="tvshow">
		@else
			<input type="hidden" name="type" value="movie">
		@endif

		<div class="form-group">
		    <label class="control-label col-sm-3" for="title">Movie Title</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control" name="title" value="{{ old('title', $movie->title)}}">

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
		      <input type="number" class="form-control" name="year" value="{{ old('year', $movie->year)}}">

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
		      <textarea rows="6" class="form-control" name="summary">{{ old('summary', $movie->summary)}}</textarea>

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
		      <input type="text" class="form-control" name="language" value="{{ old('language', $movie->language)}}">

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
		      <input type="text" class="form-control" name="country" value="{{ old('country', $movie->country)}}">

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
		    	<select class="form-control select2" name="genres[]" multiple="multiple">
	    		@foreach($genres as $g)
		    		<option value="{{ $g->id }}" 
		    			@foreach($movie->genres as $m)
							@if($g->id == $m->id) {{ 'selected' }} @endif
						@endforeach>{{ $g->name }}
					</option>
				@endforeach
		    	</select>
		    </div>
		</div>

		@if($ident == 'tvshow')	
		<div class="form-group">
		    <label class="control-label col-sm-3" for="status">Status</label>
		    <div class="col-sm-4">
		    	<select class="form-control" name="status">
		    		<option value="1" @if($movie->status == 1) {{ 'selected' }} @endif>Airing</option>
		    		<option value="2" @if($movie->status == 2) {{ 'selected' }} @endif>Completed</option>
		    		<option value="3" @if($movie->status == 3) {{ 'selected' }} @endif>Canceled</option>
		    		<option value="4" @if($movie->status == 4) {{ 'selected' }} @endif>Not yet aired</option>
		    	</select>
		    </div>
		</div>
		@endif	 

		<div class="form-group">
		    <label class="control-label col-sm-3" for="imdb">IMDb Link</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control" name="imdb" value="{{ old('imdb', $movie->imdb)}}">

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
		      <input type="text" class="form-control" name="tmdb" value="{{ old('tmdb', $movie->tmdb)}}">

		        @if ($errors->has('tmdb'))
	            <span class="help-block">
	                <strong>{{ $errors->first('tmdb') }}</strong>
	            </span>
	        	@endif

		    </div>
		</div> 
		 
		<div class="form-group"> 
		    <div class="col-sm-offset-3 col-sm-4">
		      <button type="submit" class="btn btn-warning">Update</button>
		    </div>
		</div>
		
	</form>
</div>

@endsection