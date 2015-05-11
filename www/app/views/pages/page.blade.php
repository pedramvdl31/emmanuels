@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
<div class="" style="padding-top:8px;">
	@foreach ($page_content as $content)
		<h3>{{ $content->content_title}}</h3>
		<p>{{ $content->content_body}}</p>
	@endforeach
</div>
@stop