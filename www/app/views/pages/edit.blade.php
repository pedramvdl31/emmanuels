@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
	<div class="jumbotron">
		<h1>Pages Edit</h1>
		<ol class="breadcrumb">
			<li class="active">Pages Edit</li>
			<li><a href="{{ action('PagesController@getIndex') }}">Pages Overview</a></li>
		</ol>
	</div>
	
@stop