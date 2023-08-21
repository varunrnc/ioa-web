@extends('admin.layouts.admin_layout')
@section('title', env('APP_NAME'))
@section('head')
@endsection

@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Customer List';
            $tbx['search-bar'] = true;
            $route_name = 'customer';
            $dir_name = 'customer';
            $dummy_image = asset('assets/img/other/user.png');
        @endphp
        @include('admin.includes.title-bar')

        <div class="cart__table">
            <table class="cart__table--inner">
                {!! Hpx::table_headings(['Customer', 'Gender', 'Mobile', 'City', 'Status', 'action:text-right']) !!}
                <tbody class="cart__table--body">
                    @foreach ($data_list as $data)
                        <tr class="cart__table--body__items">
                            <td class="cart__table--body__list">
                                <div class="cart__product d-flex align-items-center">
                                    <div class="cart__thumbnail">
                                        <img src="{{Hpx::image_src('assets/img/'.$dir_name.'/'.$data->image,$dummy_image)}}">
                                    </div>
                                    <div class="cart__content">
                                        <span class="cart__content--variant">
                                            <h3 class="cart__content--title text-capitalize fw-bold">
                                                {{ strtolower($data->name) }}
                                            </h3>
                                            <span class="text-black fs-4 me-1">
                                                {{ $data->email }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="cart__table--body__list">
                                {{ $data->gender }}
                            </td>
                            <td class="cart__table--body__list">
                                {{ $data->mobile }}
                            </td>
                            <td class="cart__table--body__list">
                                {{ $data->city }}
                            </td>
                            <td class="cart__table--body__list">
                                {!! Hpx::status_btn($data->id,$data->status) !!}
                            </td>
                            <td class="cart__table--body__list text-right">
                                {!! Hpx::view_btn(route($route_name . '.show', $data->id)) !!}
                                {!! Hpx::delete_btn($data->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12 links-border">
                {{ $data_list->OnEachSide(5)->links() }}
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

        function change_status(selector,id){
            var status = $(selector).prop('checked') == true ? 1 : 0;
            var x = new Ajx;
            x.actionUrl('{{ route($route_name . '.store') }}');
            x.passData('id',id);
            x.passData('action','UPDATE_STATUS');
            x.passData('status',status);
            x.globalAlert(true);
            x.start();
        }

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
        .cart__content--title{
            margin-bottom: 0;
        }
    </style>
@endsection
