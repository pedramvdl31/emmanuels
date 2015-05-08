@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('packages/tinymce2/js/tinymce/tinymce.min.js') }}
{{ HTML::script('packages/riverside-friendurl-e3d8b63/jquery.friendurl.js') }}
{{ HTML::script('js/pages_edit.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Pages Edit</h1>
	<ol class="breadcrumb">
		<li class="active">Pages Edit</li>
		<li><a href="{{ action('PagesController@getIndex') }}">Pages Overview</a></li>
	</ol>
</div>
{{ Form::open(array('action' => 'PagesController@postEdit', 'class'=>'','role'=>"form")) }}
<div class="row">
	<div class="col-md-2">
		<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
			<li class="active " role="presentation"><a href="#marketing"><span class="badge">1</span> Marketing</a></li>
			<li class="content-step" role="presentation"><a href="#content"><span class="badge">2</span> Content</a></li>
		</ul>
	</div>
	<div class="col-md-10">
		<div id="marketing" class="steps panel panel-success">
			<div class="panel-body">
				<div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
					<label class="control-label" for="title">Title</label>
					{{ Form::text('title', isset($form_data['title'])?$form_data['title']:$title, array('class'=>'form-control', 'placeholder'=>'Title','id'=>'title')) }}
					@foreach($errors->get('title') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>
				<div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
					<label class="control-label" for="description">Description</label>
					{{ Form::textarea('description', isset($form_data['description'])?$form_data['description']:$description, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Description')) }}
					@foreach($errors->get('description') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>
				<div class="form-group {{ $errors->has('url') ? 'has-error' : false }}">
					<label class="control-label" for="url">Url</label>
					{{ Form::text('url', isset($form_data['url'])?$form_data['url']:$url, array('class'=>'form-control','readonly'=>'readonly','placeholder'=>'Url','id'=>'url')) }}
					@foreach($errors->get('url') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>
				<div class="form-group {{ $errors->has('keywords') ? 'has-error' : false }}">
					<label class="control-label" for="keywords">Keywords</label>
					{{ Form::textarea('keywords', isset($form_data['keywords'])?$form_data['keywords']:$keywords, array('class'=>'form-control','style'=>'resize: none;', 'placeholder'=>'Keywords')) }}
					@foreach($errors->get('keyword') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>
	
				<div class="form-group {{ $errors->has('status') ? 'has-error' : false }}">
					<label class="control-label" for="status">Status</label>
					{{ Form::select('status', $prepared_status, isset($form_data['status'])?$form_data['status']:$status, array('class'=>'form-control status','not_empty'=>'true','status'=>false)); }}
					@foreach($errors->get('keyword') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>


			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="btn btn-primary pull-right submit-btn next" >Next</button>
			</div>
		</div>
		<div id="content" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><h3>Content Management</h3></div>
			<div class="panel-body">
				<button type="button" id="add-content" class=" btn btn-success btn-block" >Add Section&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
				<div class="content-area">
					
					@if($content)
					@foreach($content as $data)
					@foreach($data as $collapse)
					{{$collapse}}
					@endforeach
					@endforeach
					@endif
					
					<div class="content-area-session  {{isset($form_data['html'])?'':'hide'}}">
						@if(!empty($form_data['html']))
						@foreach($form_data['html'] as $data)
						{{$data}}
						@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
			</div>
		</div>
	</div>
</div>
{{ Form::hidden('page_id',isset($form_data['page_id'])?$form_data['page_id']:$page_id,['id'=>'page_id']); }}
{{ Form::hidden('content_count',null,['id'=>'content_count']); }}
{{ Form::close() }}


@stop