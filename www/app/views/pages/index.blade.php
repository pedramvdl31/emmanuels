@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/pages_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Pages</h1>
	<ol class="breadcrumb">
		<li class="active">Pages Overview</li>
		<li><a href="{{ action('PagesController@getAdd') }}">Add Page</a></li>
	</ol>
</div>
<div class="table-responsive">
	<table id="page_table" class="table table-striped table-bordered table-hover table-responsive {{$count != 0?'':'hide'}}" >
		<thead>
			<tr>
				<th>Id</th>
				<th>Company name</th>
				<th>Menus</th>
				<th>Menu Items</th>
				<th>Title</th>
				<th>Description</th>
				<th>Keywords</th>
				<th>Url</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="page_table_body">
			@foreach($pages as $page)
			<tr>
				<td>{{ $page->id }}</td>
				<td>{{ $page->company_name }}</td>
				<td>{{ $page->param_one }}</td>
				<td>{{ $page->param_two }}</td>
				<td>{{ $page->title }}</td>
				<td>{{ $page->description }}</td>
				<td>{{ $page->keywords }}</td>
				<td>{{ $page->url }}</td>
				<td>{{ $page->status_html }}</td>
				<td><a href="{{ action('PagesController@getEdit',$page->id) }}">Edit</a>/
					{{ Form::open(array('action' => 'PagesController@postDelete', 'class'=>'remove-form','id'=>'form-'.$page->id,'role'=>"form",'files'=> true)) }}
					{{ Form::hidden('page_id', $page->id) }}
					<a class="remove"  data-toggle="modal" data-target="#myModal" page-id="{{$page->id}}" count="{{$page->item_count}}">Remove</a></td>
					{{ Form::close() }}
				</td>
					
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