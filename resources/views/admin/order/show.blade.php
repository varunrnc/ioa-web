@extends('admin.layouts.admin_layout')
@section('title',env('APP_NAME'))
@section('main-content')

<div class="admin-container pb-3">

	@php
		$tbx['tb'] = 1;
		$tbx['title'] = 'Order Details';
		$route_name = 'order';
		$dummy_image = asset('assets/img/other/order-list-2.png');
		$cart_id = $order_list->first()->cart_id;
	@endphp

	<!-- title-bar -->
	@include('admin.includes.title-bar')

	<div class="row">
        <div class="col-md-3">
        	<div class="title-card">
	            <form action="{{route($route_name.'.store')}}" id="tracking_form">
	               <input type="hidden" name="action" value="TRACKING_ID">
	               <input type="hidden" name="id" value="{{$order->id}}">
	                <h1>Tracking ID</h1>
	                <div class="mb-3">
	                    <input type="text" class="form-control" value="{{$order->tracking_id}}" name="tracking_id" placeholder="######" style="text-transform:uppercase" >
	                    <button type="button" id="tracking_btn" class="btn btn-primary fs-4 ups-btn mt-3">
	                        Update & Send Mail
	                        {!! Hpx::spinner() !!}
	                    </button>
	                </div>
	            </form>
	        </div>
        </div>


        <div class="col-md-3">
        	<div class="title-card">
	            <form action="{{route($route_name.'.store')}}" id="status_form">
	               <input type="hidden" name="action" value="UPDATE_STATUS">
	               <input type="hidden" name="id" value="{{$order->id}}">
	                <h1>Order Status</h1>
	                <div class="mb-3">
	                    <select class="form-select" name="status">
	                    	@php $status_list = Hpx::order_status_list(); @endphp
	                    	<option value="">Select</option>
	                    	@foreach($status_list as $status)
	                    	<option value="{{$status}}" class="text-capitalize btn-{{ str_replace(' ', '_', $status) }}" {{$order->status == $status ? 'selected':null}}>{{ucfirst($status)}}</option>
	                    	@endforeach
	                    </select>
	                    <button type="button" id="status_btn" class="btn btn-primary fs-4 ups-btn mt-3">
	                        Update & Send Mail
	                        {!! Hpx::spinner() !!}
	                    </button>
	                </div>
	            </form>
	        </div>
        </div>

        <div class="col-md-3">
        	<div class="title-card">
	            <form action="{{route($route_name.'.store')}}" id="payment_status_form">
	               <input type="hidden" name="action" value="PAYMENT_STATUS">
	               <input type="hidden" name="payment_id" value="{{$order->payment_id}}">
	                <h1>Payment Status</h1>
	                <div class="mb-3">
	                    <input type="text" class="form-control py-{{$order->payment_status}}" value="{{$order->payment_status}}" name="payment_status" style="text-transform:capitalize;" readonly>
	                    <button type="button" id="payment_status_btn" class="btn btn-primary fs-4 ups-btn mt-3">
	                        Refresh
	                        {!! Hpx::spinner() !!}
	                    </button>
	                </div>
	            </form>
	        </div>
        </div>

        <div class="col-md-3">
        	<div class="title-card">
	            <form action="{{route($route_name.'.store')}}" id="invoice_form">
	               <input type="hidden" name="id" value="{{$order->id}}">
	                <h1>Order Invoice</h1>
	                <div class="mb-3">
	                    <select class="form-select" name="invoice_action">
	                    	<option value="stream">Open</option>
	                    	<option value="download">Download</option>
	                    	<option value="send_to_user">Send to User</option>
	                    </select>
	                    <button type="button" id="invoice_btn" class="btn btn-primary fs-4 ups-btn mt-3">
	                        Proceed
	                        {!! Hpx::spinner() !!}
	                    </button>
	                </div>
	            </form>
	        </div>
        </div>
    </div>


<!-- Order Details -->

<ul class="widget__categories--menu m-4">
	<li class="widget__categories--menu__list drop_menu active">
		<label class="widget__categories--menu__label d-flex align-items-center fs-4">
			<i class="icofont-cart-alt fs-1"></i>
			<span class="widget__categories--menu__text">View Order</span>
			<svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
				<path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
			</svg>
		</label>
		
		<ul class="widget__categories--sub__menu" style="display:block;">
			<iframe src="{{route('order.show',$order->id)}}?invoice=order_details" height="600px" width="100%"></iframe>
		</ul>
	</li>
</ul>


</div>
@endsection


@section('style')
<style>
	.title-card{ border: 1px solid #eee; background-color: #eee; padding: 10px; border-radius: 6px; text-align: left; }
	.title-card h1{
		font-size: 1.5rem;
		font-weight: 600;
		line-height: 0;
		margin: 15px 0;
		padding: 0;
		text-transform: capitalize;
	}

	.cart__table--body__list {
		padding: 0.5rem 1rem 0.5rem 0;
	}

	.py-created{ color: black; }
    .py-authorized{ color: #072791; }
    .py-captured{ color: #036d11; }
    .py-refunded{ color: #6d6e03; }
    .py-failed{ color: #a10000; }

	.btn-placed {
        background-color: #1da85435;
        color: #1da854;
    }

    .btn-dispatched {
        background-color: #a86a1d35;
        color: #a8501d;
    }

    .btn-completed {
        color: #1da854;
    }

    .btn-cancelled {
        color: #db0101;
    }

    .btn-refunded {
        background-color: #99a81d35;
        color: #7f8117;
    }

    .btn-payment_pending {
        background-color: #1d95a835;
        color: #176481;
    }

    .btn-payment_failed {
        color: #db0101;
    }

	@media only screen and (min-width: 992px){
		.cart__table--header__list {
			font-size: 1.3rem;
		}
	}
</style>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){

	// Change Order Status
	$(document).on('click', '#status_btn', function() {
	    var x = new Ajx;
	    x.form = '#status_form';
	    x.actionUrl('{{ route($route_name . '.store') }}');
	    x.globalAlert(true);
	    x.disableBtn('#status_btn');
	    x.ajxLoader('#status_btn .loaderx');
	    x.start(function(response) {
	        // if (response.status == true) {
	        //     location.reload();
	        // }
	    });
	});
	
	// Update Tracking ID
	$(document).on('click', '#tracking_btn', function() {
	    var x = new Ajx;
	    x.form = '#tracking_form';
	    x.actionUrl('{{ route($route_name . '.store') }}');
	    x.globalAlert(true);
	    x.disableBtn('#tracking_btn');
	    x.ajxLoader('#tracking_btn .loaderx');
	    x.start(function(response) {
	        // if (response.status == true) {
	        //     location.reload();
	        // }
	    });
	});

	// Refresh Payment Status
    $(document).on('click', '#payment_status_btn', function() {
        var x = new Ajx;
	    x.form = '#payment_status_form';
	    x.actionUrl('{{ route($route_name . '.store') }}');
	    x.globalAlert(true);
	    x.disableBtn('#payment_status_btn');
	    x.ajxLoader('#payment_status_btn .loaderx');
	    x.start(function(response) {
	        if (response.status == true) {
                $('#payment_status_form input').val(response.data);
                $('#payment_status_form input').addClass('py-'+response.data);
            }
	    });        
    });

    // Order Invoice
    $(document).on('click', '#invoice_btn', function() {
        var invoice_action = $('#invoice_form select').val();
        if(invoice_action == 'stream'){
        	location.href = '?invoice=stream';
        }
        else if(invoice_action == 'download'){
        	location.href = '?invoice=download';
        }
        else if(invoice_action == 'send_to_user'){
        	var x = new Ajx;
		    x.form = '#invoice_form';
		    x.actionUrl('{{ route($route_name . '.store') }}');
		    x.passData('action','SEND_INVOICE');
		    x.globalAlert(true);
		    x.disableBtn('#invoice_btn');
		    x.ajxLoader('#invoice_btn .loaderx');
		    x.start();  
        }

    });

});
</script>
@endsection

