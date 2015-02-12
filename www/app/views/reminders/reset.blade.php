@section('stylesheets')

@stop

@section('content')
<div class="jumbotron">
<h1>Password Reset</h1>
</div>
<div id="admin-info" class="panel panel-info">
	<div class="panel-heading">Password Reset</div>
	<div class="panel-body">	

	{{ Form::open(array('action' => 'RemindersController@postReset', 'class'=>'','role'=>"form")) }}
		<input type="hidden" name="token" value="{{ $token }}">
	  	<div class="form-group {{ $errors->has('email') ? 'has-error' : false }}">
	    	<label class="control-label" for="email">Email</label>
	    	{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'(ex: example@example.com) ')) }}
	        @foreach($errors->get('email') as $message)
	        <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>	
		<div class="form-group {{ $errors->has('password') ? 'has-error' : false }}">
			<label class="control-label" for="password">New Password</label>
			{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
			@foreach($errors->get('password') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>	
		<div class="form-group {{ $errors->has('password') ? 'has-error' : false }}">
				<label class="control-label" for="password_confirmation">Re-enter New Password</label>
				{{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
				@foreach($errors->get('password_confirmation') as $message)
				<span class='help-block'>{{ $message }}</span>
				@endforeach
		</div>
		<div class="panel-footer">
			{{ Form::submit('Reset Password', array('class'=>'btn btn-large btn-warnning'))}}
			{{ Form::close() }}
		</div>	
	</div>
</div>

@stop

@stop