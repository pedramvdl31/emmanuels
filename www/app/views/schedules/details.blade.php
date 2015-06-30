@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/schedules_new_frontend.js') }}
@stop

@section('content')
<div class="well" style="min-height:500px;">

	<h4 class="group-title">Type</h4>
	<hr class="title-hr">

	<div class="form-group">
		<div class="radio">
			<label>
				<input type="radio" name="estimate_or_order" id="order" value="2"> 
				Schedule an Estimate &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
			</label>
		</div>
	</div>
	<div class="form-group">
		<div class="radio">
			<label>
				<input type="radio" name="estimate_or_order" id="order" value="2"> 
				Schedule a cleaning &nbsp<i class="glyphicon glyphicon-info-sign" style="color:#337ab7;"></i>
			</label>
		</div>
	</div>
</div>
<style>
.title-hr{
margin-top: 10px;
margin-bottom: 10px;
}
.group-title{
margin-top: 25px;
}
.main-group-title{
margin-top: 0px;
}
</style>
@stop