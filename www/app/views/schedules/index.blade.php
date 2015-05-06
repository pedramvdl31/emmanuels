/vagrant/www/app/views/schedules/index.blade.php@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Schedules</h1>
		<ol class="breadcrumb">
			<li class="active">Schedules Overview</li>
			<li><a href="{{ action('SchedulesController@getAdd') }}">Set an Schedule</a></li>
		</ol>
	</div>
	
@stop