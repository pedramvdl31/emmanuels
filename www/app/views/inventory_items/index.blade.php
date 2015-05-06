@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Inventory-Items</h1>
		<ol class="breadcrumb">
			<li class="active">Inventory-Items Overview</li>
			<li><a href="{{ action('InventoryItemsController@getAdd') }}">Add an Inventory</a></li>
		</ol>
	</div>
	
@stop