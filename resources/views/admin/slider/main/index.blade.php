@extends('admin.layouts.admin_layout')

@section('title', env('APP_NAME'))

@section('head')

@endsection


@section('main-content')


    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Slider List';
            $tbx['btn-name'] = 'Add';
            $tbx['btn-link'] = route('admin.mslider.create');
            $tbx['search-bar'] = true;
            
            $route_name = 'slider';
            $dir_name = 'slider';
            $dummy_image = asset('assets/img/other/select-image.jpg');
        @endphp
        @include('admin.includes.title-bar')

        <div class="cart__table">
            <table class="cart__table--inner">
                <thead class="cart__table--header">
                    <tr class="cart__table--header__items">
                        <th class="cart__table--header__list">Slider</th>
                        <th class="cart__table--header__list">Status</th>
                        <th class="cart__table--header__list text-center">Reorder</th>
                        <th class="cart__table--header__list text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="cart__table--body" id="slider-list">
                    @foreach ($datalist as $data)
                        <tr class="cart__table--body__items">
                            <td class="cart__table--body__list">
                                <div class="cart__product d-flex align-items-center">
                                    <div class="cart__thumbnail">
                                        <a href="#"><img class="border-radius-5"
                                                src="{{ url('') . '/' . $data->img_sm }}" alt="thumbnail"></a>
                                    </div>
                                    <div class="cart__content">
                                        <h3 class="cart__content--title h4">
                                            <a href="#">{{ Str::words($data->slider_name, 7, '...') }}</a>
                                        </h3>
                                        <span class="cart__content--variant">{{ Str::words($data->title, 7, '...') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="cart__table--body__list">
                                <span class="cart__price">
                                    <span class="cart__price">
                                        <label class="switchz">
                                            <input type="checkbox" onclick="status({{ $data->id }})"
                                                {{ $data->status == 1 ? 'checked' : null }}>
                                            <span class="sliderz round"></span>
                                        </label>
                                    </span>
                                </span>
                            </td>
                            <td class="cart__table--body__list text-center">
                                <span>
                                    <div class="input-group mb-3" style="width:70px">
                                        <input type="number" class="form-control fs-4" value="{{ $data->order_no }}"
                                            onkeypress="reorder(event,{{ $data->id }})" min="1">

                                    </div>
                                </span>
                            </td>

                            <td class="cart__table--body__list text-right">
                                <div class="btn-groupx" role="group" aria-label="Action">
                                    <a class="btn btn-sm fs-4 btn-outline-secondary"
                                        href="{{ route('admin.mslider.edit', $data->id) }}">Edit</a>
                                    <a id="{{ $data->id }}" class="btn btn-sm btn-outline-danger fs-4"
                                        onclick="deleteItem(this.id)">Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection


@section('script')
    <script>
        let api = new ApiService();

        function status(id) {
            var data = {
                "_token": "{{ csrf_token() }}",
                "id": id
            };
            let req = api.setData("{{ route('admin.mslider.status') }}", data);
            req.then((res) => {
                if (res.status == true) {

                    alert(res.message);
                    location.reload();

                } else {
                    alert(res.message);
                    location.reload();
                }
            });
        }

        function reorder(event, id) {
            if (event.keyCode == 13) {

                var data = {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "order_no": event.target.value
                };
                let req = api.setData("{{ route('admin.mslider.reorder') }}", data);
                req.then((res) => {
                    if (res.status == true) {

                        alert(res.message);
                        location.reload();
                    } else {
                        alert(res.message);
                        location.reload();
                    }
                });
            }

        }

        function deleteItem(id) {
            var data = {
                "_token": "{{ csrf_token() }}",
                "id": id
            };
            $("#" + id).html(
                `<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span> Delete`
            );


            let req = api.setData("{{ route('admin.mslider.delete') }}", data);
            $("#" + id).attr("disabled", true);
            req.then((res) => {
                if (res.status == true) {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message);
                    location.reload();
                }
            });
        }
    </script>
@endsection
