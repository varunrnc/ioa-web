@extends('admin.layouts.admin_layout')
@section('title', 'IOA')
@section('head')
@endsection
@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Plant Category';
            $tbx['btn-name'] = 'Add';
            $tbx['btn-link'] = route('admin.mplant.category.create');
            $tbx['search-bar'] = true;

            $route_name = 'category';
            $dir_name = 'category';
            $dummy_image = asset('assets/img/other/select-image.jpg');
        @endphp

        @include('admin.includes.title-bar')

        <div class="cart__table">
            <table class="cart__table--inner">
                <thead class="cart__table--header">
                    <tr class="cart__table--header__items">

                        <th class="cart__table--header__list">Category</th>
                        <th class="cart__table--header__list">Status</th>
                        <th class="cart__table--header__list text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="cart__table--body" id="slider-list">
                    @foreach ($data as $item)
                        <tr class="cart__table--body__items">
                            <td class="cart__table--body__list">
                                <div class="cart__product d-flex align-items-center">
                                    <div class="cart__thumbnail">
                                        <img src="{{ url($item->img_lg) }}" class="border-radius-5" alt="Category">
                                    </div>
                                    <div class="cart__content">
                                        <h4>{{ $item->category }}</h4>

                                        <span
                                            class="cart__content--variant fs-5">{{ Str::words($item->description, 5) }}</span>
                                    </div>
                                </div>
                            </td>



                            <td class="cart__table--body__list">
                                <span class="cart__price">
                                    <span class="cart__price">
                                        @if ($item->status == 1)
                                            <label class="switchz">
                                                <input id="{{ $item->id }}" type="checkbox" checked
                                                    onclick="status(this.id)">
                                                <span class="sliderz round "></span>
                                            </label>
                                        @else
                                            <label class="switchz">
                                                <input id="{{ $item->id }}" type="checkbox" onclick="status(this.id)">
                                                <span class="sliderz round "></span>
                                            </label>
                                        @endif
                                    </span>
                                </span>
                            </td>
                            <td class="cart__table--body__list text-right">
                                <a class="btn btn-sm fs-4 btn-outline-secondary edit__btn"
                                    href="{{ route('admin.mplant.category.edit', $item->id) }}">Edit</a>
                                <a id="{{ $item->id }}" href="#"
                                    class="btn btn-sm btn-outline-danger fs-4 delete__btn"
                                    onclick="deleteItem(this.id)">Delete</a>
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
            let req = api.setData("{{ route('admin.mplant.category.status') }}", data);
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


            let req = api.setData("{{ route('admin.mplant.category.delete') }}", data);
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
