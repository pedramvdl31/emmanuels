@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('packages/riverside-friendurl-e3d8b63/jquery.friendurl.js') }}
{{ HTML::script('js/menu_items_add.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Menu-Items Add</h1>
	<ol class="breadcrumb">
		<li class="active">Menu-Items Add</li>
		<li><a href="{{ action('MenuItemsController@getIndex') }}">Menu-Items Overview</a></li>
	</ol>
		@if(isset($menus))
			@if(count($menus) == 0)
			<div class="alert alert-warning" role="alert">
				<h5 href="#" class="alert-link">There is no menu group. Click on the button bellow to add a menu group</h5>
				<a this-url="{{ action('MenusController@getAdd') }}" id="add-menu-group" class="alert-link btn btn-default" ><i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add Menu Group</a>
				<button type="button" class="btn btn-primary reload-page" ><i class="glyphicon glyphicon-refresh"></i>&nbsp;Reload</button> 
			</div>
			@endif
		@endif
</div>
{{ Form::open(array('action' => 'MenuItemsController@postAdd', 'class'=>'','role'=>"form")) }}
<div  class="panel panel-success">
	<div class="panel-body">
		<div class="form-group {{ $errors->has('name') ? 'has-error' : false }}">
			<label class="control-label" for="name">Name</label>
			{{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name','id'=>'name')) }}
			@foreach($errors->get('name') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('menus') ? 'has-error' : false }}" style="margin-bottom: 10px;">
			<label class="control-label" for="menus">Menus</label>
			{{ Form::select('menus', $menus_prepared, isset($id)?$id:null, array('class'=>'form-control menus_select menus','not_empty'=>'true','menus'=>false)); }}
			@foreach($errors->get('menus') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<p>&nbsp;
			<i class="glyphicon glyphicon-info-sign"style="color:#5bc0de;"></i>&nbsp;Click here to add or change the statuses
			<i class="btn btn-sm btn-default" id="menu-index" this-url="{{ action('MenusController@getIndex') }}" href="#">Menus</i>
			<button type="button" class="btn btn-primary btn-sm" id="reload-menus-select"><i class="glyphicon glyphicon-refresh"></i>&nbsp;Reload Menus</button> 
		</p>
		<div class="form-group {{ $errors->has('page_id') ? 'has-error' : false }}" style="margin-bottom: 10px;">
			<label class="control-label" for="page_id">Page_id</label>
			{{ Form::select('page_id', $pages_prepared, null, array('class'=>'form-control page_id','not_empty'=>'true','page_id'=>false)); }}
			@foreach($errors->get('page_id') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<p>&nbsp;
			<i class="glyphicon glyphicon-info-sign"style="color:#5bc0de;"></i>&nbsp;Click here to add or change the statuses
			<i class="btn btn-sm btn-default" id="page-index" this-url="{{ action('PagesController@getIndex') }}" href="#">Pages</i>
			<button type="button" class="btn btn-primary btn-sm " id="reload-pages-select"><i class="glyphicon glyphicon-refresh"></i>&nbsp;Reload Pages</button> 
		</p>
		<div class="form-group {{ $errors->has('url') ? 'has-error' : false }}">
			<label class="control-label" for="url">Url</label>
			{{ Form::text('url', isset($form_data['url'])?$form_data['url']:null, array('readonly'=>'readonly' ,'class'=>'form-control','placeholder'=>'Url','id'=>'url')) }}
			@foreach($errors->get('url') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" class="btn btn-primary pull-right">Submit</button>
	</div>
</div>
{{Form::close()}}
@stop