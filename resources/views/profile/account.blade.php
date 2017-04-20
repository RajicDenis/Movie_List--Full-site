{{Html::style('css/account.css')}}

<div class="col-md-8 col-md-offset-2">
	
	<div class="account-form">
		<div class="form-left">
			
			<div class="fl-title">Account Settings</div>

			<form class="acc-form" action="{{ action('ProfileController@updateAccount') }}" role="form" method="POST">
				
        		@if(Session::has('account'))
        		<div class="center">
					<div class="alert {{ Session::get('alert_type') }} fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{ Session::get('account') }}
					</div>
				</div>
				@endif

				<input type="hidden" name="_token" value="{{ csrf_token() }}">	

        		<div class="form-group">
				    <label class="control-label col-sm-3 w100" for="username">Username</label>
				        <input type="text" class="form-control wa" name="username" value="{{ Sentinel::getUser()->username }}" required>

				        @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    	@endif

				</div>

				<div class="form-group flex">
					<div class="form-group w45">
					    <label class="control-label col-sm-3 w100" for="first_name">First Name</label>
					      <input type="text" class="form-control wa" name="first_name" value="{{ Sentinel::getUser()->first_name }}">

					        @if ($errors->has('first_name'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('first_name') }}</strong>
	                        </span>
	                    	@endif

					</div>	

					<div class="form-group w45">
					    <label class="control-label col-sm-3 w100" for="last_name">Last Name</label>
					      <input type="text" class="form-control wa" name="last_name" value="{{ Sentinel::getUser()->last_name }}">

					        @if ($errors->has('last_name'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('last_name') }}</strong>
	                        </span>
	                    	@endif

					</div>  
				</div>

				<div class="form-group">
				    <label class="control-label col-sm-3 w100" for="email">E-Mail</label>
				        <input type="text" class="form-control wa" name="email" value="{{ Sentinel::getUser()->email }}" required>

				        @if ($errors->has('email'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('email') }}</strong>
	                    </span>
	                	@endif

				</div> 
				 
				<div class="form-group"> 
				    <button type="submit" class="btn btn-success">Save Changes</button>
				</div>
				
        	</form>
		</div>

		<div class="form-avatar">
			
			@if(Sentinel::getUser()->avatar == null)
				<div class="avatar"><img class="avatar-img" src="{{ URL::asset('images/avatars/blank.png') }}"></div>
			@else
				<div class="avatar"><img class="avatar-img" src="{{ URL::asset('images/avatars/'.Sentinel::getUser()->avatar.'') }}"></div>
			@endif
			

			<div class="avatar-form">

				<form class="acc-form" action="{{ action('ProfileController@uploadAvatar') }}" role="form" files="true" enctype="multipart/form-data" method="POST">

					@if(Session::has('avatar'))
		        		<div class="center">
							<div class="alert {{ Session::get('alert_type') }} fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								{{ Session::get('avatar') }}
							</div>
						</div>
					@endif

					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					@if(Sentinel::getUser()->avatar != null)

					<div class="form-group">
						<a class="remove-avatar red del" href="{{ action('ProfileController@removeAvatar') }}"><span class="glyphicon glyphicon-remove ra" aria-hidden="true"></span><span class="remove-txt">Remove</span></a>
					</div>

					@endif

					<div class="form-group">
					    <label class="control-label col-sm-3 w100 avatar-label" for="avatar">Choose Avatar</label>
					    
					    <input type="file" id="avatar" name="avatar" class="hidden">
					    
					</div>

					<div class="form-group"> 
					    <button type="submit" class="btn redbg avatar-btn">Upload</button>
					</div>

				</form>

			</div>

		</div>
	</div>

</div>