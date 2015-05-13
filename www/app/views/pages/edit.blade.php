@section('stylesheets')

{{ HTML::style('packages/fileupload-9.8.0/css/jquery.fileupload.css') }}
{{ HTML::style('packages/fileupload-9.8.0/css/jquery.fileupload-ui.css') }}
{{ HTML::style('packages/Nestable-master/css.nestable.css') }}


@stop
@section('scripts')

{{ HTML::script('packages/fileupload-9.8.0/js/vendor/jquery.ui.widget.js') }}
{{ HTML::script('packages/blueimp-templates/js/tmpl.min.js') }}
{{ HTML::script('packages/blueimp-loadimage/js/load-image.all.min.js') }}
{{ HTML::script('packages/blueimp-canvastoblob/js/canvas-to-blob.min.js') }}
{{ HTML::script('packages/blueimp-gallery/js/jquery.blueimp-gallery.min.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.iframe-transport.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.fileupload.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.fileupload-process.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.fileupload-image.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.fileupload-audio.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.fileupload-video.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.fileupload-validate.js') }}
{{ HTML::script('packages/fileupload-9.8.0/js/jquery.fileupload-ui.js') }}
{{ HTML::script('packages/Nestable-master/jquery.nestable.js') }}
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
			@if(isset($page_id))
			@if($page_id == 1)
			<li class="content-step" role="presentation"><a href="#slider"><span class="badge">3</span> Slider Image</a></li>
			@endif
			@endif
			@if(isset($form_data['page_id']))
			@if($form_data['page_id'] == 1)
			<li class="content-step" role="presentation"><a href="#slider"><span class="badge">3</span> Slider Image</a></li>
			@endif
			@endif

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
				@if(isset($form_data['page_id']))
				@if($form_data['page_id'] != 1)
				<div class="form-group {{ $errors->has('status') ? 'has-error' : false }}">
					<label class="control-label" for="status">Status</label>
					{{ Form::select('status', $prepared_status, isset($form_data['status'])?$form_data['status']:$status, array('class'=>'form-control status','not_empty'=>'true','status'=>false)); }}
					@foreach($errors->get('keyword') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>
				@endif
				@endif
				@if(isset($page_id))
				@if($page_id != 1)
				<div class="form-group {{ $errors->has('status') ? 'has-error' : false }}">
					<label class="control-label" for="status">Status</label>
					{{ Form::select('status', $prepared_status, isset($form_data['status'])?$form_data['status']:$status, array('class'=>'form-control status','not_empty'=>'true','status'=>false)); }}
					@foreach($errors->get('keyword') as $message)
					<span class='help-block'>{{ $message }}</span>
					@endforeach
				</div>
				@endif
				@endif
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
				@if(isset($page_id))
				@if($page_id == 1)
				<button type="button" class="btn btn-primary pull-right submit-btn next" >Next</button>
				@else
				<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
				@endif
				@endif
				@if(isset($form_data['page_id']))
				@if($form_data['page_id'] == 1)
				<button type="button" class="btn btn-primary pull-right submit-btn next" >Next</button>
				@else
				<button type="submit" class="btn btn-primary pull-right submit-btn">Preview</button>
				@endif
				@endif
			</div>
		</div>

		<div id="slider" class="steps panel panel-success hide">
			<div class="panel-heading" style="font-size:17px;"><h3>Slider Image</h3></div>
			<div class="panel-body">
				<div class="row fileupload-buttonbar">
					<div class="col-lg-7">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="btn btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Add files...</span>
							<input type="file" name="files[]" multiple>
						</span>
						<button type="submit" class="btn btn-primary start">
							<i class="glyphicon glyphicon-upload"></i>
							<span>Start upload</span>
						</button>
						<button type="reset" class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancel upload</span>
						</button>
						<button type="button" class="btn btn-danger delete">
							<i class="glyphicon glyphicon-trash"></i>
							<span>Delete</span>
						</button>
						<input type="checkbox" class="toggle">
						<!-- The global file processing state -->
						<span class="fileupload-process"></span>
					</div>
					<!-- The global progress state -->
					<div class="col-lg-5 fileupload-progress fade">
						<!-- The global progress bar -->
						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar progress-bar-success" style="width:0%;"></div>
						</div>
						<!-- The extended global progress state -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				<!-- The table listing the files available for upload/download -->
				<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
				<div class="content-area-slider">
					<div class="dd" id="nestable3" style="width:50% !important;max-width:none !important">
						<ol class="dd-list">
							<li class="dd-item dd3-item" data-id="1">
								<input type="hidden" class="menu menu-link" name="1" value="">
								<input type="hidden" class="menu-order" name="menu['.$value->id.'][order]" value="">
								<div class="dd-handle dd3-handle">Drag</div>
								<div class="dd3-content " style="display:table !important">

									<div class="row-fluid" style="">
										<div class="col-md-12" >
											<a href="#" class="thumbnail">
												<img src="/img/slider-image/home/IMG_3134.jpg" alt="...">
											</a>
											<div class="caption">
												<button type="button" class="btn btn-danger pull-right">Remove <i class="glyphicon glyphicon-trash"></i></button>	
											</div>
										</div>
									</div>	
									<div class="image-info pull-right" style="">

									</div>


								</div>
							</li>
						</ol>
					</div>



					<div class="content-area-session-slider  {{isset($form_data['html-slider'])?'':'hide'}}">
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