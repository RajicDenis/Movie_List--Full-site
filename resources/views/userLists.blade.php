@extends('layouts.app')

@section('content')

{{Html::style('css/userlists.css')}}

<div class="userlist-box col-md-8 col-md-offset-2">
	<div class="userlists">
	@if(count($lists) != 0)
		@foreach($lists as $list)
			
			@if($list->user_id != Sentinel::getUSer()->id)
				<a href="{{ action('MovieListController@showList', ['uid' => $list->user_id, 'mid' => $list->id]) }}">
			@else
				<a href="{{ action('MovieListController@switchList', $list->id) }}">
			@endif
			<div class="single-list hs">
				<div class="list-img-box">
					@for($i = 0; $i < 4; $i++)
						<img class="list-img" src="{{ URL::asset('images/posters/'.App\Utilities::getMoviesInList($list->id)[$i].'') }}">
					@endfor
				</div>

				<div class="list-content">
					<div class="content-top"><span>{{ $list->name }}</span><span class="top-username">Created by {{ App\Utilities::getUser($list->user_id)->username }}</span></div>
					@if($list->description == null)
						<div class="content-middle">No description provided</div>
					@else
						<div class="content-middle">{{ Str::words($list->description, 70, '...') }}</div>
					@endif
					<div class="content-bottom">{{ Carbon\Carbon::parse($list->created_at)->format('d M Y') }}</div>
				</div>

			</div></a>	
			
		@endforeach
		
		<div class="list_pgn">{!! $lists->render() !!}</div>
	@else
		<style>
			.jscroll-inner {
				width: 100%;
			}
		</style>
		<h3 class="list_info">There are no public lists yet!</h3>
	@endif

	</div>

	<div class="list-stats">
		<a href="{{ action('MovieListController@index') }}" class="create-list-btn redbg">Create your own list!</a>

		<div class="stat-box">
			<div class="stat-title">LIST STATS</div>
			<div class="stat-info">Lists Created: <span>{{ count($allLists) }}</span></div>
			<div class="stat-info">Public Lists: <span>{{ count($publicLists) }}</span></div>
		</div>
	</div>

</div>

@endsection