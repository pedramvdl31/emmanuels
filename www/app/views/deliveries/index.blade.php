@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Deliveries</h1>
		<ol class="breadcrumb">
			<li class="active">Deliveries Overview</li>
			<li><a href="{{ action('DeliveriesController@getAdd') }}">Add an Inventory</a></li>
		</ol>
	</div>
	
@stop