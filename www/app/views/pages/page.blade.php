@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
<div class="page-content" style="padding-top:8px;min-height:600px;">
	@if(isset($page_content))
		@foreach ($page_content as $content)
			<h3>{{ $content->content_title}}</h3>
			<p>{{ $content->content_body}}</p>
		@endforeach
	@endif
</div>
@stop