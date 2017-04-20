@extends('layouts.app')

@section('content')

<style>
	input[type=checkbox] {
  		transform: scale(1.5);
  		margin: 10px 18px 0;
	}
	.left {
		text-align: left;
	}
	.saveList {
		width: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.alert {
		text-align: center;
	}

</style>

<div class="col-md-8 col-md-offset-2">

	<div class="form-title">Create List</div>

	<form class="form-horizontal movie-form" action="{{ action('MovieListController@storeList') }}" method="POST">

		@if(Session::has('status'))
			<div class="center">
				<div class="alert {{ Session::get('alert_type') }} fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ Session::get('status') }}
				</div>
			</div>
		@endif

		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="user_id" value="{{ Sentinel::getUser()->id }}">
		
		<div class="form-group">
		    <label class="control-label col-sm-3" for="name">List Name</label>
		    <div class="col-sm-4">
		      <input type="text" class="form-control" name="name" placeholder="e.g. Top 20 Action Movies">

		        @if ($errors->has('name'))
	            <span class="help-block">
	                <strong>{{ $errors->first('name') }}</strong>
	            </span>
	        	@endif

		    </div>
		</div>
		
		<div class="form-group">
		    <label class="control-label col-sm-3" for="description">Description</label>
		    <div class="col-sm-4">
		      <textarea rows="6" class="form-control" name="description"></textarea>

		        @if ($errors->has('description'))
	            <span class="help-block">
	                <strong>{{ $errors->first('description') }}</strong>
	            </span>
	        	@endif

		    </div>
		</div>

		<div class="saveList">
			<button type="submit" class="btn btn-success">Save</button>
		</div>
	
	</form>
</div>
@endsection