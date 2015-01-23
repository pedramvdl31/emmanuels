@extends('layouts.admins_login')
@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	{{ Form::open(array('action'=>'AdminsController@postLogin', 'class'=>'form-signin')) }}
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert_type') }} alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message') }}
            </div>
        @endif
	    <h2 class="form-signup-heading">Admin Login</h2>

	  	<div class="form-group {{ $errors->has('username') ? 'has-error' : false }}">
	    	<div class="input-group">
	    		<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
	    		{{ Form::text('username', null, array('id'=>'username','class'=>'form-control', 'placeholder'=>'Username')) }}
	        </div>
	        @foreach($errors->get('username') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
    
	  	<div class="form-group {{ $errors->has('password') ? 'has-error' : false }}">
	    	<div class="input-group">
	    		<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
	    		{{ Form::password('password', array('id'=>'password','class'=>'form-control', 'placeholder'=>'Password')) }}
	        </div>
	        @foreach($errors->get('password') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>	

	    {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}
	{{ Form::close() }}
@stop