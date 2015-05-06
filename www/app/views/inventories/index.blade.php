@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Inventories</h1>
		<ol class="breadcrumb">
			<li class="active">Inventories Overview</li>
			<li><a href="{{ action('InventoriesController@getAdd') }}">Add an Inventory</a></li>
		</ol>
	</div>
	
@stop