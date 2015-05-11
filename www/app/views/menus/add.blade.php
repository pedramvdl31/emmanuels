@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('packages/riverside-friendurl-e3d8b63/jquery.friendurl.js') }}
{{ HTML::script('js/menus_add.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Menus Add</h1>
	<ol class="breadcrumb">
		<li class="active">Menus Add</li>
		<li><a href="{{ action('MenusController@getIndex') }}">Menus Overview</a></li>
	</ol>
</div>
{{ Form::open(array('action' => 'MenusController@postAdd', 'class'=>'','role'=>"form")) }}
<div  class="panel panel-success">
	<div class="panel-body">
		<div class="form-group {{ $errors->has('name') ? 'has-error' : false }}">
			<label class="control-label" for="name">Name</label>
			{{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Name','id'=>'name')) }}
			@foreach($errors->get('name') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group {{ $errors->has('kind') ? 'has-error' : false }}">
			<label class="control-label" for="kind">Kind</label>
			{{ Form::select('kind', $prepared_select, null, array('class'=>'form-control kind','not_empty'=>'true','id'=>false)); }}
			@foreach($errors->get('keyword') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
		<div class="form-group page-field {{ $errors->has('page_id') ? 'has-error' : false }}">
			<label class="control-label" for="page_id">Page_id</label>
			{{ Form::select('page_id', $pages_prepared, null, array('class'=>'form-control page_id','not_empty'=>'true','page_id'=>false)); }}
			@foreach($errors->get('page_id') as $message)
			<span class='help-block'>{{ $message }}</span>
			@endforeach
		</div>
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