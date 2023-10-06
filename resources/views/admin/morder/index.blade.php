@extends('admin.layouts.admin_layout')
@section('title', env('APP_NAME'))
@section('head')
@endsection


@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Orders List';
            $tbx['search-bar'] = true;
            $route_name = 'order';
            $dir_name = 'order';
            $dummy_image = asset('assets/img/other/order-list-2.png');
        @endphp
        @include('admin.includes.title-bar-I')

        <div class="cart__table">
            <table class="cart__table--inner">
                {!! Hpx::table_headings(['Order', 'Payment Id', 'Total Amt', 'status']) !!}
                <tbody class="cart__table--body" id="slider-list">
                    @foreach ($datalist as $data)
                        <tr class="cart__table--body__items">
                            <td class="cart__table--body__list">
                                <div class="cart__product d-flex align-items-center">
                                    <div class="cart__thumbnail">
                                        <img src="{{ asset($dummy_image) }}">
                                    </div>
                                    <div class="cart__content">
                                        <span class="cart__content--variant fw-bold">
                                            <h3 class="cart__content--title text-capitalize">
                                                <a href="{{ url('admin/morder') . '/' . $data->orderid }}">
                                                    {{ $data->orderid }}</a>
                                            </h3>

                                            <span class="text-black fs-4 me-1">
                                                {{ Hpx::mydate_month($data->created_at) }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="cart__table--body__list">

                                <a href="{{ url('admin/payment') . '/' . $data->payment_id }}"> {{ $data->payment_id }}</a>

                            </td>

                            <td class="cart__table--body__list">
                                <span class="fw-bold"> <span class="text-danger">₹</span> {{ $data->total_amt }}</span>
                            </td>
                            <td class="cart__table--body__list">
                                <span class="blink">
                                    {{ Str::upper($data->status) }}
                                </span>


                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12 links-border">
                {!! Hpx::paginator($datalist) !!}
            </div>
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
                                                    <label class="variant__size--value red" for="status5">Refunded</label>
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
