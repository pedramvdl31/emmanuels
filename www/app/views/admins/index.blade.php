@section('stylesheets')
{{ HTML::style('packages/DataTables-Bootstrap3/BS3/assets/css/datatables.css') }}
@stop
@section('scripts')
{{ HTML::script('js/users_index.js') }}
@stop
@section('content')
<div class="jumbotron">
	<h1>Admins</h1>
	<ol class="breadcrumb">
		<li class="active">Admins</li>
		<li><a href="{{ action('AdminsController@getAdd') }}"></a></li>
	</ol>
</div>
@stop