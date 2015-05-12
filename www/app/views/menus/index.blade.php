@section('stylesheets')
{{ HTML::style('packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') }}
@stop
@section('scripts')
{{ HTML::script('js/menus_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Menus</h1>
	<ol class="breadcrumb">
		<li class="active">Menus Overview</li>
		<li><a href="{{ action('MenusController@getAdd') }}">Add Menu</a></li>
		<li><a href="{{ action('MenusController@getOrder') }}">Page Order</a></li>
	</ol>
</div>

<div class="table-responsive">
	<table id="menu_table" class="table table-striped table-bordered table-hover table-responsive">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Order</th>
				<th>Page Id</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="menu_table_body">
			@foreach($menus as $menu)
			<tr> 
				<td>{{ $menu->id }}</td>
				<td>{{ $menu->name }}</td>
				<td>{{ $menu->order }}</td>
				<td>{{ $menu->page_title }}</td>
				<td>{{ $menu->status_html }}</td>
				<td><a href="{{ action('MenusController@getEdit',$menu->id) }}">Edit</a>/
					{{ Form::open(array('action' => 'MenusController@postDelete', 'class'=>'remove-form','id'=>'form-'.$menu->id,'role'=>"form",'files'=> true)) }}
					{{ Form::hidden('menu_id', $menu->id) }}
					<a class="remove"  menu-id="{{$menu->id}}" >Remove</a></td>
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