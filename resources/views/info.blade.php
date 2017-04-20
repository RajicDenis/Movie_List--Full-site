@extends('layouts.app')

@section('content')

{{Html::style('css/info.css')}}

<div class="infobox col-md-8 col-md-offset-2">

	<div class="image-box">
	@if(App\Utilities::getAdmin()->avatar != null)
		<img class="admin-img" src="{{ URL::asset('images/avatars/'.App\Utilities::getAdmin()->avatar.'') }}"> 
	@else
		<img class="admin-img" src="{{ URL::asset('images/avatars/blank.png') }}"> 
	@endif
		<h5 style="text-align: center; font-size: 11px; color: ">{{ App\Utilities::getAdmin()->username}}</h5>
	</div>
	
	<div class="rules-box">
		<p>These guidelines are at the interpretation of the mods and admins of the site. Ignoring any of these guidelines may result in content being removed, locked or even your account being banned from MovieList.<br><br>

		These guidelines may be altered from time to time without an announcement. However in most circumstances any changes will be discussed with the community beforehand.</p>

		<h3>General Site Guidelines</h3>
		<ul class="info-list">
			<li class="li">Media should not contain nudity or real extreme violence. If questionable, use spoiler tags.</li>
			<li class="li">Link shorteners are not allowed. Please use markdown instead.</li>
			<li class="li">Trolling, harassing or abusing members will not be tolerated.</li>
			<li class="li">Offensive display names will be changed.</li>
			<li class="li">Linking or guiding others to copyrighted content is prohibited. This includes torrents, direct downloads, XDCC bots etc.</li>
			<li class="li">Spam: Any comment deemed as spam by a mod will be removed.</li>
		</ul>

		<h3>Profile Guidelines</h3>
		<ul>
			<li class="li">Lists should not disable navigation to the rest of the site.</li>
			<li class="li">Do not use excessively fast flashing colours or images.</li>
			<li class="li">Do not re-post messages to skew the home page feed.</li>
		</ul>
		
		<h3>Forum Guidelines</h3>
		<ul>
			<li class="li">Language: For now, all new threads and replies should be in English.</li>
			<li class="li">Please don’t post thread titles all in caps.</li>
			<li class="li">Refrain from posting ‘Where can I find/watch/read *’ threads.</li>
			<li class="li">Duplicate topics will be removed - use the search function before posting.</li>
			<li class="li">Please edit posts instead of successive posting when possible.</li>
			<li class="li">All spoilers should be contained within spoiler tags.</li>
			<li class="li">Recommendation threads should be as specific as possible and replies should be relevant.</li>
			<li class="li">Posting: Addition is not allowed. (No posting things like “I agree” or “+1”. If you agree with another user’s post expand on your contribution)</li>
			<li class="li">Quality Titles: Thread titles should be descriptive and accurate to the threads content. Users should be able to get a general understanding of the thread by it’s title alone.</li>
			<li class="li">Advertising: Any thread intended to generate traffic to external websites will be removed.</li>
		</ul>
		
		<h3>Reviews</h3>
		<ul>
			<li class="li">Show or movie should have finished airing (unless long-running)</li>
			<li class="li">For ongoing TV shows use your own judgement on whether there is enough content to create a review.</li>
			<li class="li">If your review contains spoilers, either preface the review with a warning or use spoiler tags.</li>
		</ul>
	</div>
</div>
@endsection