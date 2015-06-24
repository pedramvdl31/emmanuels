@section('stylesheets')
@stop
@section('scripts')
{{ HTML::script('js/schedules_preview.js') }}
@stop
@section('content')

<div class="jumbotron">
	<h1>Schedules Preview</h1>
	<ol class="breadcrumb">
		<li class="active">Schedules Preview</li>
	</ol>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-md-3 col-lg-3 pull-left">
                    <div class="panel panel-default height">
                        <div class="panel-heading">Customer Details</div>
                        <div class="panel-body">
                            @if(isset($input_all))
								{{$input_all['name']}}<br>
								{{$input_all['email']}}<br>
								{{$input_all['phone']}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="panel panel-default height">
                        <div class="panel-heading">Billing address</div>
                        <div class="panel-body">
							<strong>{{$input_all['name']}}</strong><br>
                            {{$input_all['unit']}} {{$input_all['street']}}<br>
                            {{$input_all['city']}}<br>
                            {{$input_all['state']}}<br>
                            <strong>{{$input_all['zipcode']}}</strong><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td class="text-center"><strong>Type</strong></td>
                                    <td class="text-center"><strong>Height</strong></td>
                                    <td class="text-center"><strong>Length</strong></td>
                                    <td class="text-center"><strong>Price</strong></td>
                                    <td class="text-center"><strong>Quantity</strong></td>
                                    <td class="text-right"><strong>Total</strong></td>
                                </tr>
                            </thead>
                            <tbody>	
                            	<!-- FILL THE TABLE -->
                            	@if(isset($input_all))
                            		<!-- SERVICES -->
									@if(isset($input_all['service_order']))
										@foreach($input_all['service_order'] as $skey => $s_o)
											<tr>	
			                                    <td>{{$s_o['name']}} ({{$s_o['item_name']}})</td>
			                                    <td class="text-center">Services</td>
			                                    <td class="text-center">{{$s_o['height']}}</td>
			                                    <td class="text-center">{{$s_o['length']}}</td>
			                                    <td class="text-center">${{$s_o['rate']}}</td>
			                                    <td class="text-center"></td>
			                                    <td class="text-right">${{$s_o['rate']}}</td>
			                                </tr>
										@endforeach
									@endif
			
									<!-- ITEMS -->
									@if(isset($input_all['item_order']))
										@foreach($input_all['item_order'] as $ikey => $i_o)
											<tr>	
			                                    <td>{{$i_o['name']}}</td>
			                                    <td class="text-center">Items</td>
			                                    <td class="text-center">-</td>
			                                    <td class="text-center">-</td>
			                                    <td class="text-center">${{$i_o['price']}}</td>
			                                    <td class="text-center">{{$i_o['qty']}}</td>
			                                    <td class="text-right">${{$i_o['total']}}</td>
			                                </tr>
										@endforeach
									@endif
								@endif
                                <tr>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow"></td>
                                    <td class="highrow text-center"><strong>Subtotal</strong></td>
                                    <td class="highrow text-right">${{$input_all['subtotal']}}</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Tax rate</strong></td>
                                    <td class="emptyrow text-right">{{$input_all['tax_rate']}}%</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Tax due</strong></td>
                                    <td class="emptyrow text-right">${{$input_all['tax']}}</td>
                                </tr>
                                <tr>
                                    <td class="emptyrow"><i class="fa fa-barcode iconbig"></i></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow"></td>
                                    <td class="emptyrow text-center"><strong>Total</strong></td>
                                    <td class="emptyrow text-right">${{$input_all['total_after_tax']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
	            <div class="panel-footer">
					<button type="button" class="previous btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
					<button type="button" class="btn btn-primary pull-right submit-btn">Confirm</button>
				</div>
            </div>
        </div>
    </div>
</div>

<style>
.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>
@stop