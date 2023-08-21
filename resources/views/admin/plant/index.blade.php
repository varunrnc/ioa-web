@extends('admin.layouts.admin_layout')
@section('title', env('APP_NAME'))
@section('head')
@endsection

@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Plant List';
            $tbx['btn-name'] = 'Add';
            $tbx['btn-link'] = route('admin.plant.create');
            $tbx['search-bar'] = true;
            
            $route_name = 'product';
            $dir_name = 'product';
            $dummy_image = asset('assets/img/other/select-image.jpg');
            $img_dir = 'assets/img/' . $dir_name . '/thumbnail/';
            $refresh = Hpx::refresh_id();
        @endphp
        @include('admin.includes.title-bar')

        <div class="cart__table">
            <table class="cart__table--inner">
                {!! Hpx::table_headings(['title', 'category', 'Sub category', 'status', 'action:text-right']) !!}
                <tbody class="cart__table--body" id="slider-list">
                    @foreach ($data_list as $data)
                        <tr class="cart__table--body__items">
                            <td class="cart__table--body__list">
                                <div class="cart__product d-flex align-items-center">
                                    <div class="cart__thumbnail">
                                        <img src="{{ url('/') . '/' . $data->img->image }}" class="border-radius-5"
                                            alt="image">
                                    </div>
                                    <div class="cart__content">
                                        <span class="cart__content--variant fw-bold">
                                            <h3 class="cart__content--title">
                                                <a href="#">{{ $data->title }}</a>
                                            </h3>
                                            <span class="text-black fs-4 me-1">
                                                ₹{{ $data->selling_price }}
                                            </span>
                                            <del class="me-1">₹{{ $data->regular_price }}</del>
                                            <span class="text-success fs-4">
                                                {{ Hpx::discount_x($data->regular_price, $data->selling_price) }}% off
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="cart__table--body__list">
                                {{ $data->category }}
                            </td>
                            <td class="cart__table--body__list">
                                {{ $data->sub_category }}
                            </td>
                            <td class="cart__table--body__list">
                                @if ($data->status == 1)
                                    <label class="switchz">
                                        <input id="{{ $data->id }}" type="checkbox" checked onclick="status(this.id)">
                                        <span class="sliderz round "></span>
                                    </label>
                                @else
                                    <label class="switchz">
                                        <input id="{{ $data->id }}" type="checkbox" onclick="status(this.id)">
                                        <span class="sliderz round "></span>
                                    </label>
                                @endif


                            </td>
                            <td class="cart__table--body__list text-right">
                                {{-- {!! Hpx::edit_btn(route($route_name . '.edit', $data->id)) !!} --}}
                                <a class="btn btn-sm fs-4 btn-outline-secondary edit__btn"
                                    href="{{ url('admin/plant/edit') . '/' . $data->id }}">Edit</a>
                                <a id="{{ $data->pid }}" href="#"
                                    class="btn btn-sm btn-outline-danger fs-4 delete__btn"
                                    onclick="deleteItem(this.id)">Delete</a>
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

@endsection

@section('script')

    <script>
        let api = new ApiService();

        function status(id) {
            var data = {
                "_token": "{{ csrf_token() }}",
                "id": id
            };
            let req = api.setData("{{ route('admin.plant.status') }}", data);
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

        function deleteItem(id) {
            var data = {
                "_token": "{{ csrf_token() }}",
                "id": id
            };
            $("#" + id).html(
                `<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span> Delete`
            );


            let req = api.setData("{{ route('admin.plant.delete') }}", data);
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
