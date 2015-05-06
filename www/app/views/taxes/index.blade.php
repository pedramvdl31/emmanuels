@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Taxes</h1>
		<ol class="breadcrumb">
			<li class="active">Taxes Overview</li>
			<li><a href="{{ action('TaxesController@getAdd') }}">Add Tax</a></li>
		</ol>
	</div>
	
@stop