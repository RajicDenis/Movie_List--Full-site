<style>
	.scorebox {
	    display: flex;
    	align-items: center;
		margin-top: 20px;
	}
	.l {
		margin-right: 15px;
	}
</style>

<!-- Modal -->
<div class="modal fade" id="addMovieModal_{{$movie->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Choose List</h5>
        	<button type="button" class="glyphicon glyphicon-off" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

	      	<form class="form movie-form list-frm" action="{{ action('MovieListController@addMovie') }}" role="form" method="POST">

	      		<input type="hidden" name="_token" value="{{ csrf_token() }}">	
	      		<input type="hidden" id="mid" name="mid" value="">

				<div class="scorebox">
					<label class="control-label l" for="lid">List: </label>
			    	<select class="form-control w300" name="lid">
					
					@php $i = 0; $nolist = false; @endphp
			    	@if(count($allLists) != null)
				    	@foreach($allLists as $l)
				    		@if(App\Utilities::listHasMovie($l->id, $movie->id) == false)
				    			<option value="{{ $l->id }}" required>{{ $l->name }}</option>
				    			@php $i += 1; @endphp
				    		@endif
			    		@endforeach
			    		@if($i == 0)
							<option>This movie is already added to all your lists!</option>
							@php $nolist = true; @endphp
			    		@endif
			    	@else
			    		<option>You have not created a list yet</option> 
			    	@endif	
			    	
			    	</select>
			    </div>

				<div class="scorebox">
			    	<label class="control-label l" id="l_title" for="score">Score: </label>
					<input type="number" id="score" name="score" min=1 max=10 step=0.1 value="" required>
				</div>
				
				@if(count($allLists) != null) 
					
					@if($nolist == true)
						<div class="add-box">
							<button type="submit" class="btn add redbg" disabled>Add to List</button>
						</div>
					@else
						<div class="add-box">
							<button type="submit" class="btn add redbg">Add to List</button>
						</div>
					@endif

				@else 
					<div class="add-box">
						<button type="submit" class="btn add redbg" disabled>Add to List</button>
					</div>
		        @endif
	      	</form>

        </div>
    </div>
  </div>
</div>