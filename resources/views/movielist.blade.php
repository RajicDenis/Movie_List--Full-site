@extends('layouts.app')

@section('content')

{{Html::style('css/modal.css')}}
{{Html::style('css/movielist.css')}}

@if(count($listdb) == null)
	
	<div class="col-md-10 col-md-offset-1 top50">
		<h2>You have not created a list yet</h2>

		<div class="createList">
			<a href="{{ action('MovieListController@createList') }}" class="createList-btn">Create Your List</a>
		</div>
	</div>

@else


	<div class="list-container">
		<div class="movielist col-md-7 col-md-offset-2">

		@if($movielist->user_id == Sentinel::getUser()->id)
			<a href="{{ action('MovieListController@deleteList', $movielist->id) }}" class="delete_list del" data-toggle="tooltip" data-placement="top" title="Delete List"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
		@endif
		
		@if(Route::current()->getName() != 'showList')
			<div class="createList new">
				<a href="{{ action('MovieListController@createList') }}" class="createList-btn">Create New List</a>

				@if($movielist->public != 1)
					@if(count($movielist->movies) > 4)
						<a class="share-box" href="{{ action('MovieListController@shareList', $movielist->id) }}" data-toggle="tooltip" data-placement="top" title="Make Your list visible to other users!"><span class="glyphicon glyphicon-share" aria-hidden="true"></span><span class="share-txt">Share</span></a>
					@else 
						<a class="share-box" href="#" data-toggle="tooltip" data-placement="top" title="You need to add at least 5 items to your list!"><span class="glyphicon glyphicon-share" aria-hidden="true"></span><span class="share-txt">Share</span></a>
					@endif
				@else
					<div class="public" style="color: white;">Status: <span style="color: #00cc00;">Public</span></div>
				@endif
				
				@if(count($allLists) > 0) 
					<div class="dropdown">
						<button class="btn btn-list dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					    	Choose List
					    	<span class="caret"></span>
						</button>
					
						<ul class="dropdown-menu btn-list" aria-labelledby="dropdownMenu1">
						@foreach($allLists as $l)
					    	<li><a class="a-list" href="{{ action('MovieListController@switchList', $l->id) }}">{{ $l->name }}</a></li>
					    @endforeach	
						</ul>				
					</div>
				@endif

			</div>
		@endif

			@if(Route::current()->getName() != 'showList')
				<div class="form-title mt10 mb30">{{ $movielist->name }}</div>
			@else

				<style>
					.form-title {
						display: flex;
						flex-direction: row;
						justify-content: space-between;
					}
					.t-date, .t-user {
						font-size: 15px;
					}

				</style>

				<div class="form-title mt10 mb30">
					<div class="t-date">{{ Carbon\Carbon::parse($movielist->created_at)->format('d M Y') }}</div>
					<div class="t-name">{{ $movielist->name }}</div>
					<div class="t-user">Created by: {{ App\Utilities::getUser($movielist->user_id)->username }}</div>
				</div>
			@endif

			
			<div class="table-responsive">
				<table class="table list_table" id="list_table">
				
					<thead>
						<tr>
							<th></th>
							<th>#</th>
							<th class="title-cell">Title</th>
							<th class="scr">Score</th>
							<th>Type</th>
							<th></th>
							<th style="display: none;"></th>
						</tr>
						
					</thead>

					<tbody>
						@php $i=1; @endphp
					
						@if(count($movielist->movies) > 0)

							@foreach($score as $scr)
								@foreach($scr->movies as $s)
									@foreach($movielist->movies as $m)
										@if($m->id == $s->id)
											
											<tr class="movie_row" data-id="{{ $s->id }}">
												<td class="td-poster"><img class="td-poster-img" src="{{ URL::asset('images/posters/'.$s->poster.'') }}"></td>
											
												<td>{{$i}}</td>
												<td class="m_title">{{ $s->title.' ('.$s->year.')' }}</td>
												@if(Route::current()->getName() == 'showList')
													<td>{{ $s->pivot->score }}</td>
												@else	
													<td class="score" data-toggle="modal" data-target="#addScoreModal">{{ $s->pivot->score }}</td>
												@endif															
												<td>
													@if($s->type == 'movie')
														Movie																					
													@else
														TV Show
													@endif
												</td>
												<td><a class="del" href="{{ action('MovieListController@remove', [$movielist->id, $s->id]) }}"><span class="glyphicon glyphicon-remove x red" aria-hidden="true"></span></a></td>
											</tr>
											
										@php $i++; @endphp	
										@endif
									@endforeach											
								@endforeach
							@endforeach
						@else
							<script>
								$('.list_table').removeAttr('id');
							</script>
							<tr class="movie_row">
								<td colspan="4" style="text-align: center; font-size: 15px; font-family: 'Amaranth", sans-serif;>No movies added yet</td>
							</tr>
						@endif
						
					</tbody>

				</table>
			</div>

		</div>

		<div class="hover-cont">
			@foreach($movielist->movies as $m)
			<div class="hover-box h_{{$m->id}}">
				<img class="hover-poster" src="{{URL::asset('images/posters/'.$m->poster)}}">
				<div class="hover-desc">
					<div class="hover-title">Summary</div>
					<div class="hover-summary">{{ $m->summary }}</div>
				</div>
			</div>		
			@endforeach
		</div>

	</div>

@if(Route::current()->getName() != 'showList')
	<!-- Modal -->
	<div class="modal fade" id="addScoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	        <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Enter Score</h5>
	        	<button type="button" class="glyphicon glyphicon-off" data-dismiss="modal" aria-label="Close"></button>
	        </div>
	        <div class="modal-body">

		      	<form class="form-horizontal movie-form list-frm" action="{{ action('MovieListController@addScore') }}" role="form" method="POST">

		      		<input type="hidden" name="_token" value="{{ csrf_token() }}">	
		      		<input type="hidden" id="mid" name="mid" value="">

					<div class="score-box">
						<label class="control-label" id="l_title" for="score"></label>
						<input type="number" id="score" name="score" min=1 max=10 step=0.1 value="">
					</div>

					<div class="add-box">
						<button type="submit" class="btn add redbg">Save Score</button>
					</div>
			    	
		      	</form>

	        </div> 
	    </div>
	  </div>
	</div>
@endif

@endif

@endsection