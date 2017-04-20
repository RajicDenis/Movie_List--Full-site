@extends('layouts.app')

@section('content')

{{Html::style('css/modal.css')}}
{{Html::style('css/showMovie.css')}}

<div class="col-md-8 col-md-offset-2">
	<div class="show-box">
		
		<div class="show-banner">
			<img class="banner-img" src="{{ URL::asset('images/banners/'.$movie->banner) }}"> 
			<img class="backdrop" src="{{ URL::asset('images/backdrop.png') }}">
		</div>

		<div class="show-content">
			<div class="content-left">
				<img class="content-poster" src="{{ URL::asset('images/posters/'.$movie->poster) }}">

				<div class="panel">
					<div class="panel-heading">More details</div>
					<div class="panel-body">
					    <a href="{{ $movie->imdb }}"><div class="link1"><img style="width: 25px; height: 15px; margin-right: 10px;" src="{{ URL::asset('images/icons/imdb.png') }}">IMDb</div></a>
					    <a href="{{ $movie->tmdb }}"><div class="link2"><img style="width: 25px; height: 25px; margin-right: 10px;" src="{{ URL::asset('images/icons/tmdb.jpg') }}">TMDb</div></a>
					</div>
				</div>
			</div> 

			<div class="content-right">
				<div class="content-box">
					<div class="box-upper">

						<div class="b-left">
							<div class="content-title">{{ $movie->title }}</div>
							<div class="summary-box">{{ $movie->summary }}</div>

							<div class="content-details">
								<div class="dtl-text">Details</div>
								<div class="dtl">
									<div class="flex-row"><span>Country</span><span class="row2">{{ $movie->country }}</span></div>
									<div class="flex-row"><span>Language</span><span class="row2">{{ $movie->language }}</span></div>
									<div class="flex-row"><span>Release Year</span><span class="row2">{{ $movie->year }}</span></div>
									<div class="flex-row"><span>Genres</span><span class="row2">
										@foreach($movie->genres as $m)
											<span class="dtl-gnr">{{ $m->name }}</span>
										@endforeach
									</span></div>
								</div>
							</div>

						</div>

						<div class="b-right">

							<div class="action-box">
								
								@if(count($movie->users) != null)
																		
									@if($movie->users->contains('id', Sentinel::getUSer()->id))
										@foreach($movie->users as $u)
											@if($u->id == Sentinel::getUser()->id)
												@if($u->pivot->likes == 0)
													<div class="b-like"><span id="like_movie" class="glyphicon glyphicon-heart-empty" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Like"></span></div>
												@else
													<div class="b-like"><span class="glyphicon glyphicon-heart red" aria-hidden="true"></span></div>
												@endif
											@endif
										@endforeach
									@else		
										<div class="b-like"><span id="like_movie" class="glyphicon glyphicon-heart-empty" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Like"></span></div>						
									@endif							
									
								@else

									<div class="b-like"><span id="like_movie" class="glyphicon glyphicon-heart-empty" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Like"></span></div>

								@endif
								
								<div class="b-rate"><input id="movie-star" type="text" class="rating" data-size="sm"></div>

								@foreach($movie->users as $u)
									@if($u->id == Sentinel::getUser()->id)								
										<div class="newRating" style="display: none">{{$u->pivot->rating}}</div>
										<div class="reviewRating" style="display: none">{{ $u->pivot->rev_rating }}</div>
									@endif					
								@endforeach

								<a class="b-rev" href="#" data-id="{{ $movie->id }}" data-toggle="modal" data-target="#reviewModal">Write review</a>
									
								<a class="b-list" href="#" data-id="{{ $movie->id }}" data-toggle="modal" data-target="#addMovieModal_{{$movie->id}}">Add to list</a> 

								@include('layouts.listModal')
							</div>

							<div class="content-rating">
								<div class="dtl-text">User Score</div>
								
								@if(App\Utilities::getRating($movie->id) != null)
									<div class="rtng"><span class="rtng-1">{{ App\Utilities::getRating($movie->id) }}</span><span class="slash">/</span><span class="rtng-2">5</span></div>
								@else
									<div class="rtng"><span class="rtng-1">N/A</span></div>
								@endif

							</div>
						</div>
						

					</div>

					<div class="box-lower">
						<div class="movie-reviews">
							<div class="dtl-text">Reviews<a href="#"><span class="pull-right" style="font-size: 13px; color: #FF003F;">More</span></a></div>

							@php $i = 0; @endphp
							@foreach($movie->users as $u)
								@if($u->pivot->review != null)
									
									<div class="rev-container" style="display: flex;">
										<div class="rev-left">
											<img src="{{ URL::asset('images/admin.jpg') }}" class="rev-profile">
										</div>

										<div class="rev-right">
											<div class="right-top">
												<span style="font-size: 13px; opacity: 0.7;">Reviewed by</span>
												<span style="font-size: 14px; margin-left: 7px;">
													@if($u->id != Sentinel::getUSer()->id)
														<a class="profile_link" href="{{ action('ProfileController@showProfile', $u->id) }}">{{ $u->username }}</a>
													@else
														<a class="profile_link" href="{{ action('ProfileController@showAccount') }}">{{ $u->username }}</a>
													@endif
												</span></div>
											<div class="right-middle">{{ $u->pivot->review }}</div>
											<div class="right-bottom"><span class="g glyphicon glyphicon-heart roh red" aria-hidden="true"></span>{{ $u->pivot->rev_total_likes.' Likes' }}</div>
										</div>
									</div>

									@php $i++; @endphp
								@endif
								@if($i == 4) @php break; @endphp @endif
							@endforeach								

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>



<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content t100">
    	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Review</h5>
        	<button type="button" class="glyphicon glyphicon-off" data-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">

	      	<div class="modal-cont">
	      		<div class="modal-left">
	      			<img src="{{ URL::asset('images/posters/'.$movie->poster) }}" class="modal-img">
	      		</div>

	      		<div class="modal-right">
	      			
	      			<form class="review-form" action="{{ action('ReviewController@addReview') }}" role="form" method="POST">

	      				<div class="movie-title">{{ $movie->title.' ('.$movie->year.')' }}</div>

			      		<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			      		<input type="hidden" id="mid2" name="mid2" value="">

						@php $e=0; $i=0; @endphp
						@if(count($movie->users) != null)

							@if($movie->users->contains('id', Sentinel::getUSer()->id))
								@foreach($movie->users as $u)
									@if($u->id == Sentinel::getUser()->id)
										@if($u->pivot->review != null)
											<textarea class="rev-textbox" rows="9" name="review" placeholder="Write review..." required>{{ $u->pivot->review }}</textarea>
										@else
											<textarea class="rev-textbox" rows="9" name="review" placeholder="Write review..." required></textarea>
										@endif
									@endif
								@endforeach
							@else		
								<textarea class="rev-textbox" rows="9" name="review" placeholder="Write review..." required></textarea>						
							@endif

						@else 
							<textarea class="rev-textbox" rows="9" name="review" placeholder="Write review..." required></textarea>
						@endif

						@if(count($movie->users) != null)

							@if($movie->users->contains('id', Sentinel::getUSer()->id))
								@foreach($movie->users as $u)
									@if($u->id == Sentinel::getUser()->id)
										@if($u->pivot->rev_recap != null)
											<textarea class="rev-textbox" rows="3" name="recap" placeholder="Write short recap..." maxlength="250" required>{{ $u->pivot->rev_recap }}</textarea>
										@else
											<textarea class="rev-textbox" rows="3" name="recap" placeholder="Write short recap..." maxlength="250" required></textarea>
										@endif
									@endif
								@endforeach
							@else		
								<textarea class="rev-textbox" rows="3" name="recap" placeholder="Write short recap..." maxlength="250" required></textarea>						
							@endif

						@else 
							<textarea class="rev-textbox" rows="3" name="recap" placeholder="Write short recap..." maxlength="250" required></textarea>
						@endif
				    	
				    	<input name="rating" id="review-star" type="text" class="rating" data-size="sm" >

				    	<button type="submit" class="btn add redbg">Save</button>

			      	</form>

	      		</div>
	      	</div>

        </div>
  
    </div>
  </div>
</div>


@endsection