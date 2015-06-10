@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/schedules_add.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Schedules Add</h1>
	<ol class="breadcrumb">
		<li class="active">Schedules Add</li>
		<li><a href="{{ action('SchedulesController@getIndex') }}">Schedules Overview</a></li>
	</ol>
</div>
{{ Form::open(array('action' => 'SchedulesController@postAdd', 'class'=>'','role'=>"form")) }}

<div class="row" id="this-body"> 
	<div class="col-md-3" style="margin-bottom:5px;">
		<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
			<li class="active " role="presentation"><a href="#search"><span class="badge">1</span> User Search</a></li>
			<li class="" role="presentation"><a href="#information"><span class="badge">2</span> User Information</a></li>
			<li class="content-step disabled" role="presentation"><a href="#content"><span class="badge">3</span> Order</a></li>
		</ul>
	</div>
	<div class="col-md-9 pull-right">


		<div id="search" class="steps panel panel-success">
			<div class="panel-heading" style="font-size:17px;"><strong>Search</strong></div>
			<div class="panel-body">

				<div id="customerMembers" class="">
					<div class="form-group">
						<label class="control-label" for="id">Find By:</label>
						{{ Form::select('search',$search_by ,'username', ['id'=>'searchBy','class'=>'form-control','status'=>false]) }}
						@foreach($errors->get('id') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div id="searchBy-id" class="searchByFormGroup form-group {{ $errors->has('id') ? 'has-error' : false }} well well-sm hide">
						<label class="control-label" for="id">User Id</label>
						<div class="input-group">
							{{ Form::text('id', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'user id','status'=>false)) }}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('id') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>	
					<div id="searchBy-username" class="searchByFormGroup form-group {{ $errors->has('username') ? 'has-error' : false }} well well-sm">
						<label class="control-label" for="email">Username</label>
						<div class="input-group">
							{{ Form::text('username', "pedram", array('class'=>'form-control searchInputItem', 'placeholder'=>'username','status'=>false)) }}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('email') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>	
					<div id="searchBy-phone" class="searchByFormGroup clearfix well well-sm hide">	
						<label class="col-md-12">Phone Number</label>
						<div class="input-group" style="">

							{{ Form::text('phone', null, array('class'=>'form-control search-phone searchInputItem', 'placeholder'=>'eg ### ### ####')) }}				    	
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
					</div> 
					<div id="searchBy-email" class="searchByFormGroup form-group {{ $errors->has('email') ? 'has-error' : false }} well well-sm hide">
						<label class="control-label" for="email">Email</label>
						<div class="input-group">
							{{ Form::text('email', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'(ex: example@example.com)','status'=>false)) }}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('email') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>	
					<div id="searchBy-name" class="searchByFormGroup well well-sm hide">
						<div class="form-group {{ $errors->has('firstname') ? 'has-error' : false }}">
							<label class="control-label" for="firstname">First Name</label>
							{{ Form::text('first_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'First Name')) }}
							@foreach($errors->get('firstname') as $message)
							<span class='help-block'>{{ $message }}</span>
							@endforeach
						</div>	
						<div class="form-group {{ $errors->has('last_name') ? 'has-error' : false }}">
							<label class="control-label" for="last_name">Last Name</label>
							{{ Form::text('last_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'Last Name')) }}
							@foreach($errors->get('last_name') as $message)
							<span class='help-block'>{{ $message }}</span>
							@endforeach
						</div>	
						<div class="form-group">
							<button type="button" class="searchByButton btn btn-info"><i class="glyphicon glyphicon-search"></i> Search</button>
						</div>			
					</div>
				</div>


			</div>
			<table id="userSearchTable" class="table table-hover hide" style="margin-bottom:20px;">
				<thead>
					<tr>
						<th>Id</th>
						<th>Username</th>
						<th>First</th>
						<th>Last</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<div class="panel-footer clearfix">
				<button type="button" id="first-next" class="btn btn-primary pull-right submit-btn next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>

		<div id="information" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>User Information</strong></div>
			<div class="panel-body">
				<ul id="searchCustomerNavTabs" class="nav nav-tabs">
					<li class="active" role="presentation" type="members"><a href="#address">Address</a></li>
					<li role="presentation" type="guests"><a href="#newaddress">New Address</a></li>
				</ul>
				<br/>

				<div id="address" class="customerListDiv">
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="info_radio" id="estimate" value="1">
								ESTIMATE
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="info_radio" id="order" value="1" checked>
								WORK ORDER
							</label>
						</div>
					</div>

					<div class="form-group  {{ $errors->has('name') ? 'has-error' : false }}">
						<label class="control-label" for="name">Name&nbsp;&nbsp;</label>
						{{ Form::text('name', isset($form_data['name'])?$form_data['name']:null, array('class'=>'form-control', 'placeholder'=>'Name','id'=>'name')) }}
						  	<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
  							<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
							<span class='help-block val-help hide'></span>
						@foreach($errors->get('name') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('telephone') ? 'has-error' : false }}">
						<label class="control-label" for="telephone">Telephone&nbsp;&nbsp;</label>
						{{ Form::text('telephone', isset($form_data['telephone'])?$form_data['telephone']:null, array('class'=>'form-control', 'placeholder'=>'Telephone','id'=>'telephone')) }}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('telephone') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('email') ? 'has-error' : false }}">
						<label class="control-label" for="email">Email&nbsp;&nbsp;</label>
						{{ Form::text('email', isset($form_data['email'])?$form_data['email']:null, array('class'=>'form-control', 'placeholder'=>'Email','id'=>'email')) }}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('email') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					

					<hr>
					<div class="form-group {{ $errors->has('street') ? 'has-error' : false }}">
						<label class="control-label" for="street">Street&nbsp;&nbsp;</label>
						{{ Form::text('street', isset($form_data['street'])?$form_data['street']:null, array('class'=>'form-control', 'placeholder'=>'Street','id'=>'street')) }}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('street') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('unit') ? 'has-error' : false }}">
						<label class="control-label" for="unit">Unit&nbsp;&nbsp;</label>
						{{ Form::text('unit', isset($form_data['unit'])?$form_data['unit']:null, array('class'=>'form-control', 'placeholder'=>'Unit','id'=>'unit')) }}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('unit') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('city') ? 'has-error' : false }}">
						<label class="control-label" for="city">City&nbsp;&nbsp;</label>
						{{ Form::text('city', isset($form_data['city'])?$form_data['city']:null, array('class'=>'form-control', 'placeholder'=>'City','id'=>'city')) }}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>						
						@foreach($errors->get('city') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('state') ? 'has-error' : false }}">
						<label class="control-label" for="state">State&nbsp;&nbsp;</label>
						{{ Form::text('state', isset($form_data['state'])?$form_data['state']:null, array('class'=>'form-control', 'placeholder'=>'State','id'=>'state')) }}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>
						@foreach($errors->get('state') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('zipcode') ? 'has-error' : false }}">
						<label class="control-label" for="zipcode">Zipcode&nbsp;&nbsp;</label>
						{{ Form::text('zipcode', isset($form_data['zipcode'])?$form_data['zipcode']:null, array('class'=>'form-control', 'placeholder'=>'Zipcode','id'=>'zipcode')) }}
						<span class="glyphicon glyphicon-remove form-control-feedback val-error hide" aria-hidden="true"></span>
						<span class="glyphicon glyphicon-ok form-control-feedback val-success hide" aria-hidden="true"></span>
						<span class='help-block val-help hide'></span>						
						@foreach($errors->get('zipcode') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<hr>
					<div class="form-group {{ $errors->has('will_phone') ? 'has-error' : false }}">
						<div class="checkbox">
							<label>
								<input type="checkbox" value="1" name="will_phone">
								WILL PHONE
							</label>
						</div>
					</div>
				</div><!-- Addess END -->
				<div id="newaddress" class="customerListDiv hide">
					<div class="form-group {{ $errors->has('new_street') ? 'has-error' : false }}">
						<label class="control-label" for="new_street">Street&nbsp;&nbsp;</label>
						{{ Form::text('new_street', isset($form_data['new_street'])?$form_data['new_street']:null, array('class'=>'form-control', 'placeholder'=>'Street','id'=>'new_street')) }}
						<span class='help-block hide' id="new_street-duplicate">This is a protected new_street please choose another new_street</span>
						@foreach($errors->get('new_street') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('new_unit') ? 'has-error' : false }}">
						<label class="control-label" for="new_unit">Unit&nbsp;&nbsp;</label>
						{{ Form::text('new_unit', isset($form_data['new_unit'])?$form_data['new_unit']:null, array('class'=>'form-control', 'placeholder'=>'Unit','id'=>'new_unit')) }}
						<span class='help-block hide' id="new_unit-duplicate">This is a protected new_unit please choose another new_unit</span>
						@foreach($errors->get('new_unit') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('new_city') ? 'has-error' : false }}">
						<label class="control-label" for="new_city">City&nbsp;&nbsp;</label>
						{{ Form::text('new_city', isset($form_data['new_city'])?$form_data['new_city']:null, array('class'=>'form-control', 'placeholder'=>'City','id'=>'new_city')) }}
						<span class='help-block hide' id="new_city-duplicate">This is a protected new_city please choose another new_city</span>
						@foreach($errors->get('new_city') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('new_state') ? 'has-error' : false }}">
						<label class="control-label" for="new_state">State&nbsp;&nbsp;</label>
						{{ Form::text('new_state', isset($form_data['new_state'])?$form_data['new_state']:null, array('class'=>'form-control', 'placeholder'=>'State','id'=>'new_state')) }}
						<span class='help-block hide' id="new_state-duplicate">This is a protected new_state please choose another new_state</span>
						@foreach($errors->get('new_state') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
					<div class="form-group {{ $errors->has('new_zipcode') ? 'has-error' : false }}">
						<label class="control-label" for="new_zipcode">Zipcode&nbsp;&nbsp;</label>
						{{ Form::text('new_zipcode', isset($form_data['new_zipcode'])?$form_data['new_zipcode']:null, array('class'=>'form-control', 'placeholder'=>'Zipcode','id'=>'new_zipcode')) }}
						<span class='help-block hide' id="new_zipcode-duplicate">This is a protected new_zipcode please choose another new_zipcode</span>
						@foreach($errors->get('new_zipcode') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach
					</div>
				</div>
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" id="next-btn" class="btn btn-primary pull-right next disabled" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>
		<div id="content" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Content Management</strong></div>
			<div class="panel-body">
				<button type="button" id="add-content" class=" btn btn-success btn-block" >Add Order&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
				<div class="content-area">
					<div class="content-area-session  {{isset($form_data['html'])?'':'hide'}}">
						@if(!empty($form_data['html']))
						@foreach($form_data['html'] as $data)
						{{$data}}
						@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
			</div>
		</div>
	</div>
</div>
{{ Form::hidden('content_count',null,['id'=>'content_count'])}}
{{ Form::hidden('user_id',null,['id'=>'user_id'])}}
{{ Form::hidden('checklist', null,array('id'=>'checklist')) }}
{{ Form::hidden('tabs_checklist', "address",array('id'=>'tabs_checklist')) }}

{{ Form::hidden('service_count', 0,array('id'=>'service_count')) }}
{{ Form::hidden('item_count', 0,array('id'=>'item_count')) }}

{{ Form::close() }}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				Loading &nbsp;&nbsp; <img src="/img/gif/ajax-loader.gif">
			</div>
		</div>
	</div>
</div>
@stop