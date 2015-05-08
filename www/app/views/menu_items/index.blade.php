@section('stylesheets')
{{ HTML::style('packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') }}
@stop
@section('scripts')
{{ HTML::script('js/menu_items_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Menu-Items</h1>
	<ol class="breadcrumb">
		<li class="active">Menu-Items Overview</li>
		<li><a href="{{ action('MenuItemsController@getAdd') }}">Add Menu Item</a></li>
	</ol>
</div>

<div class="table-responsive">
	<table id="menu-item_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Menu Name</th>
				<th>Page Name</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="menu-item_table_body">
			@foreach($menu_items as $menu_item)
			<tr> 
				<td>{{ $menu_item->id }}</td>
				<td>{{ $menu_item->name }}</td>
				<td>{{ $menu_item->menu_name }}</td>
				<td>{{ isset($menu_item->page_id)?$menu_item->page_id:""  }}</td>
				<td>{{  $menu_item->status_html }}</td>
				<td><a href="{{ action('MenuItemsController@getEdit',$menu_item->id) }}">Edit</a>/
					{{ Form::open(array('action' => 'MenuItemsController@postDelete', 'class'=>'remove-form','id'=>'form-'.$menu_item->id,'role'=>"form",'files'=> true)) }}
					{{ Form::hidden('menu-item_id', $menu_item->id) }}
					<a class="remove"  data-toggle="modal" data-target="#myModal" menu-item-id="{{$menu_item->id}}" >Remove</a></td>
					{{ Form::close() }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header alert alert-warning">
						Warnning!
					</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-danger remove-btn">Remove</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	@stop