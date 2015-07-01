@section('stylesheets')
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
{{ HTML::style('packages/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}

@stop
@section('scripts')
<script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
{{ HTML::script('js/schedule_limits_index.js') }}
{{ HTML::script('packages/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Schedule Setup</h1>
	<ol class="breadcrumb">
		<li class="active">Schedule Setup</li>
		<li><a href="{{ action('ScheduleRulesController@getIndex') }}">Schedule-rules Overview</a></li>
	</ol>
</div>
<div class="row" id="this-body" style="min-height:500px;"> 
	{{ Form::open(array('action' => 'SchedulesController@postDetails', 'class'=>'','id'=>'add-form','role'=>"form")) }}
	<div class="col-md-3" style="margin-bottom:5px;">
		<ul id="stepy" class="nav nav-pills nav-stacked">
			<li id="schedule-stepy" class="active" role="presentation"><a href="#type"><span class="badge">1</span> Schedules</a></li>
			<li id="overwrite-stepy" class="" role="presentation"><a href="#place"><span class="badge">2</span> Special Dates </a></li>
			<li id="blackout-stepy" class="" role="presentation"><a href="#date"><span class="badge">3</span> Blackout Dates</a></li>
		</ul>
	</div>
	<div class="col-md-9 pull-right">


		<!-- TYPE STEP -->
		<div id="type" class="steps panel panel-success " >
			<div class="panel-heading" style="font-size:17px;"><strong>Type</strong></div>
			<div class="panel-body">
				<!-- FIRST SECTION -->
				<div class="first_section">
	            	<div class="form-group {{ $errors->has('zipcode') ? 'has-error' : false }}">
	                  <label class="control-label" for="zipcode">Zipcode</label>
	                  <input name="zipcode" class="form-control" id="zipcode"
	                  placeholder="Enter zipcode" type="zipcode">
	                    @foreach($errors->get('zipcode') as $message)
						<span class='help-block'>{{ $message }}</span>
						@endforeach                
					</div>

				</div>
				<!-- FIRST SECTION **END-->
			</div>
			<div class="panel-footer clearfix">
				<button type="button" id="first-next" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
			
		</div>

 

		<!-- PLACE STEP -->
		<div id="place" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Place</strong></div>
			<div class="panel-body">
				<!-- SECOND SECTION START -->
				<div class="second_section">
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="house_or_store" id="house_radio" value="1"> 
								In House &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="house_or_store" id="store_radio" value="2"> 
								In Store &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
							</label>
						</div>
					</div>
				</div>
				<!-- SECOND SECTION END -->
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" id="next-btn" class="btn btn-primary pull-right next" >Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
			
		</div>



		<!-- DATE STEP -->
		<div id="date" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><strong>Date</strong></div>
			<div class="panel-body">
				<div class="third_section">
					<div class="form-group hide" id="estimate_calendar">
						<label class="control-label" for="pick_up">Estimate Date&nbsp;&nbsp;</label>
						<div class="input-group ">
							<input type="text" value="" class="form-control  estimate-date " id="estimate-date" name="estimate_date" readonly="readonly" this-group="estimate" style="cursor:pointer;background-color:#fff"  placeholder="" aria-describedby="basic-addon2">
							<span class="input-group-addon calendar" style="cursor:pointer" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<!-- estimate ERROR -->
						<span class="estimate-date-error help-block hide" style="color:#a94442;">Pick-Up date is required</span>
					</div>
					<div class="form-group hide" id="cleaning_calendar">
						<label class="control-label" for="pick_up">Cleaning Date&nbsp;&nbsp;</label>
						<div class="input-group ">
							<input type="text" value="" class="form-control  cleaning-date " id="cleaning-date" name="cleaning_date" readonly="readonly" this-group="cleaning" style="cursor:pointer;background-color:#fff"  placeholder="" aria-describedby="basic-addon2">
							<span class="input-group-addon calendar" style="cursor:pointer" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
						</div>
						<!-- cleaning ERROR -->
						<span class="cleaning-date-error help-block hide" style="color:#a94442;">Pick-Up date is required</span>
					</div>
				</div>
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="1"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="submit" id="submit-btn" class="btn btn-primary pull-right" >Submit <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
			
		</div>
	</div>
	{{ Form::close() }}
</div>
	
@stop