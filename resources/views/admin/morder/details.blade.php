@extends('admin.layouts.admin_layout')
@section('title', env('APP_NAME'))
@section('head')
@endsection


@section('main-content')

<div class="admin-container">

    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Orders Details';
        $tbx['search-bar'] = false;
        $route_name = 'order';
        $dir_name = 'order';
        $dummy_image = asset('assets/img/other/order-list-2.png');
    @endphp
    @include('admin.includes.title-bar-I')

    <div class="container">

        <div class="row justify-content-between mb-5">
            <div class="col-md-3">

                <p>
                    <span class="fw-bold">Invoice To :</span>
                     <br>
                    Mr / Mrs {{$datalist->address->name}} <br>
                    {{$datalist->address->mobile}} <br>
                    {{$datalist->address->address_line_1}} <br>
                    {{$datalist->address->address_line_1}} <br>
                    {{$datalist->address->state}},
                    {{$datalist->address->city}},
                    {{$datalist->address->pincode}}
                </p>
            </div>
            <div class="col-md-3">

                <p><span class="fs-2 text-info">{{$datalist->orderid}}</span> <br> Order Date : {{date('d-m-Y', strtotime($datalist->created_at))}}</p>
            </div>
        </div>
        <h3 class="text-center mb-4">INVOICE </h3>
        <table class="table table-striped">

            <tr>
                <td class="bg-info text-center text-white px-4 py-2">#</td>
                <td class="px-4 py-2">Item Name</td>
                <td class="px-4 py-2">Unit Price</td>
                <td class="px-4 py-2">Discount</td>
                <td class="px-4 py-2">Qty</td>
                <td class="bg-info text-white px-4 py-2">Total</td>
            </tr>
            @foreach ($datalist->items as $key => $item)
                <tr>
                    <td class="bg-info text-center text-white px-4 py-2">{{ $key + 1 }}</td>
                    <td class=" px-4 py-2">{{ $item->plant->title }}</td>
                    <td class="px-4 py-2">{{ $item->plant->regular_price }}</td>
                    <td class="px-4 py-2">
                        {{ number_format($item->plant->regular_price - $item->plant->selling_price, 2) }}</td>
                    <td class="px-4 py-2">{{ $item->qty }}</td>
                    <td class="bg-info text-white px-4 py-2">
                        {{ number_format($item->qty * $item->plant->selling_price, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2 fw-bold">Sub Total</td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2">
                    {{ number_format($datalist->total_amt - $datalist->shipping_charges, 2) }}</td>
            </tr>
            <tr>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2 fw-bold">Shipping Charges</td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2">
                    {{ number_format($datalist->shipping_charges,2) }}</td>
            </tr>
            <tr>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2 fw-bold">Total Amount</td>
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2">
                    {{ number_format($datalist->total_amt,2) }}</td>
            </tr>

        </table>




    </div>
</div>


<!-- Status Modal -->
<div class="modal" id="modal1" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper" style="padding-bottom: 10px;">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close="">✕ </button>
        </header>
        <div class="quickview__inner">
            <div class="row row-cols-lg-2 row-cols-md-2">
                <div class="col">
                    <div class="quickview__info">
                        <form id="status_form">
                            <input type="hidden" name="action" value="UPDATE_STATUS">
                            <input type="hidden" name="id" value="" id="order_id">
                            <div class="product__variant">
                                <div class="product__variant--list mb-15">
                                    <fieldset class="variant__input--fieldset">
                                        <legend class="product__variant--title mb-8">
                                            Change Status :
                                        </legend>
                                        <ul class="variant__size">
                                            <li class="variant__size--list">
                                                <input id="status1" name="status" type="radio" value="placed">
                                                <label class="variant__size--value red" for="status1">Placed</label>
                                            </li>
                                            <li class="variant__size--list my-2">
                                                <input id="status2" name="status" type="radio" value="dispatched">
                                                <label class="variant__size--value red"
                                                    for="status2">Dispatched</label>
                                            </li>
                                            <li class="variant__size--list">
                                                <input id="status3" name="status" type="radio" value="completed">
                                                <label class="variant__size--value red" for="status3">Completed</label>
                                            </li>
                                            <li class="variant__size--list my-2">
                                                <input id="status4" name="status" type="radio" value="cancelled">
                                                <label class="variant__size--value red" for="status4">Cancelled</label>
                                            </li>
                                            <li class="variant__size--list">
                                                <input id="status5" name="status" type="radio" value="refunded">
                                                <label class="variant__size--value red"
                                                    for="status5">Refunded</label>
                                            </li>
                                            <li class="variant__size--list my-2">
                                                <input id="status6" name="status" type="radio"
                                                    value="payment pending">
                                                <label class="variant__size--value red" for="status6">Payment
                                                    Pending</label>
                                            </li>
                                            <li class="variant__size--list">
                                                <input id="status7" name="status" type="radio"
                                                    value="payment failed">
                                                <label class="variant__size--value red" for="status7">Payment
                                                    Failed</label>
                                            </li>
                                        </ul>
                                        <button type="button" id="save_sts_btn"
                                            class="btn btn-primary fs-4 mt-2 w-100" style="width: 14rem">
                                            Save
                                            {!! Hpx::spinner() !!}
                                        </button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Status Modal -->


@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.edit-status', function() {
            var id_is = $(this).attr('data-id');
            $('#order_id').val(id_is);
        });

        $(document).on('click', '#save_sts_btn', function() {
            var x = new Ajx;
            x.form = '#status_form';
            x.actionUrl('{{ route($route_name . '.store') }}');
            x.globalAlert(true);
            x.disableBtn('#save_sts_btn');
            x.ajxLoader('#save_sts_btn .loaderx');
            x.start(function(response) {
                if (response.status == true) {
                    location.reload();
                }
            });
        });

        // Refresh Payment Status
        $(document).on('click', '.payment-refresh', function() {
            var payment_id = $(this).attr('data-payment-id');
            var refresh_icon = $(this);
            var loader = $(this).parent().find('.loaderx');
            var payment_status = $(this).closest('td').find('.payment-status');
            console.log(payment_status);
            refresh_icon.hide();
            loader.show();
            var x = new Ajx;
            x.actionUrl('{{ route($route_name . '.store') }}');
            x.passData('action', 'PAYMENT_STATUS');
            x.passData('payment_id', payment_id);
            x.globalAlert(true);
            x.start(function(response) {
                refresh_icon.show();
                loader.hide();
                if (response.status == true) {
                    payment_status.html(response.data);
                    payment_status.addClass('py-' + response.data);
                }
            });
        });
    });

    // function change_status(selector,id){
    //     var status = $(selector).prop('checked') == true ? 1 : 0;
    //     var x = new Ajx;
    //     x.actionUrl('{{ route($route_name . '.store') }}');
    //     x.passData('id',id);
    //     x.passData('action','UPDATE_STATUS');
    //     x.passData('status',status);
    //     x.globalAlert(true);
    //     x.start();
    // }

    function delete_id(id) {
        if (confirm("Are you sure want to delete..!") == true) {
            var x = new Ajx;
            x.actionUrl('{{ route($route_name . '.store') }}');
            x.passData('id', id);
            x.passData('action', 'DELETE');
            x.globalAlert(true);
            x.start(function(response) {
                if (response.status == true) {
                    location.reload();
                }
            });
        }
    }
</script>
@endsection

@section('style')
<style type="text/css">
    .btn-stx {
        padding: 0.25rem 0.8rem;
        color: #0d6efd;
        font-size: 1.5rem;
        border: 0;
        border-radius: 3px;
    }

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

    .edit-status {
        cursor: pointer;
    }

    .edit-status:hover {
        box-shadow: 2px 2px 3px #ddd;
    }

    .edit-status:active {
        box-shadow: 1px 1px 1px #ddd;
    }

    .modal-dialog .variant__size--value {
        width: 14rem;
    }

    .modal-dialog .variant__size--list {
        margin: 0;
    }

    .modal {
        background-color: #0000006b !important;
    }

    .payment-refresh:hover {
        color: #0d6efd;
        cursor: pointer;
    }

    .py-created {
        color: black;
    }

    .py-authorized {
        color: #072791;
    }

    .py-captured {
        color: #036d11;
    }

    .py-refunded {
        color: #6d6e03;
    }

    .py-failed {
        color: #a10000;
    }
</style>
@endsection
