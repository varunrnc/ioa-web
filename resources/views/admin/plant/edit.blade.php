@extends('admin.layouts.admin_layout')
@section('title', env('APP_NAME'))
@section('main-content')

    <div class="admin-container">
        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Edit Product';
            $route_name = 'product';
            $dummy_image = asset('assets/img/other/select-image.jpg');
            // $exist_image1 = $data->imgmd[0]->image;
            // $exist_image2 = $data->imgmd[1]->image;
            // $exist_image3 = $data->imgmd[2]->image;
        @endphp
        @include('admin.includes.title-bar')

        <form id="frm" class="row" action="{{ route('admin.plant.update') }}" enctype="multipart/form-data"
            method="POST">
            @csrf
            @if (Session::has('success'))
                <div class="row justify-content-end">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span> {!! Session::get('success') !!}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                {{ Session::forget('success') }}
            @endif
            @if (Session::has('error'))
                <div class="row justify-content-end">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span> {!! Session::get('error') !!}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                {{ Session::forget('error') }}
            @endif
            <input type="hidden" value="{{ $data->id }}" name="id">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $data->title }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="" class="form-label">Short Description</label>
                        <textarea class="form-control" rows="4" name="short_description">{{ $data->short_description }}</textarea>
                        @error('short_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="" class="form-label">Long Description</label>
                        <textarea class="form-control" id="html_content" name="long_description" hidden>{{ $data->long_description }}</textarea>
                        @error('long_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Regular Price</label>
                        <input type="text" class="form-control" name="regular_price" value="{{ $data->regular_price }}">
                        @error('regular_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Selling Price</label>
                        <input type="text" class="form-control" name="selling_price" value="{{ $data->selling_price }}">
                        @error('selling_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Discount</label>
                        <input type="text" id="disc" class="form-control" value="{{ $data->discount }} %" readonly>
                        <input type="text" name="discount" value="{{ $data->discount }}" hidden>
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Category</label>
                        <select class="form-select" name="category">
                            <option value="">Select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}"
                                    {{ $data->category == $category->name ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Sub Category</label>
                        <select class="form-select" name="sub_category">
                            <option value="">Select</option>
                            @foreach ($subCat as $item)
                                <option value="{{ $item->name }}"
                                    {{ $data->sub_category == $item->name ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sub_category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Rating</label>
                        <input type="number" class="form-control" name="rating" min="1" max="5"
                            value="{{ $data->rating }}">
                        @error('rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="unit-set" class="row">
                        <div class="col-sm-4">
                            <label for="" class="form-label">Unit</label>
                            <select class="form-select" name="unit">
                                <option value="KG" {{ $data->unit == 'KG' ? 'selected' : '' }}>KG</option>
                                <option value="GM" {{ $data->unit == 'GM' ? 'selected' : '' }}>GM</option>
                                <option value="Ltr" {{ $data->unit == 'Ltr' ? 'selected' : '' }}>Ltr</option>
                                <option value="ML" {{ $data->unit == 'ML' ? 'selected' : '' }}>ML</option>
                                <option value="Combo" {{ $data->unit == 'Combo' ? 'selected' : '' }}>Combo</option>
                            </select>
                            @error('unit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="form-label">Weight in Unit</label>
                            <input type="number" class="form-control" name="weight" value="{{ $data->weight }}">
                            @error('weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="" class="form-label">Status</label>
                        <select id="" class="form-select" name="status">
                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>
                </div>
            </div>
            @if (count($data->imgmd) == 1)
                <div class="col-sm-4 position-relative">
                    <img src="{{ Hpx::image_src($data->imgmd[0]->image, $dummy_image) }}" id="showBanner1"
                        class="show-banner img-hover" data-dummy-image="{{ $dummy_image }}">
                    <input accept="image/*" type='file' name="image1" id="inputBanner1" class="invisible" />
                </div>
            @else
                <div class="col-sm-4 position-relative">
                    <img src="{{ Hpx::image_src('', $dummy_image) }}" id="showBanner1" class="show-banner img-hover"
                        data-dummy-image="{{ $dummy_image }}">
                    <input accept="image/*" type='file' name="image1" id="inputBanner1" class="invisible" />
                </div>
            @endif

            @if (count($data->imgmd) == 2)
                <div class="col-sm-4 position-relative">
                    <img src="{{ Hpx::image_src($data->imgmd[1]->image, $dummy_image) }}" id="showBanner2"
                        class="show-banner img-hover" data-dummy-image="{{ $dummy_image }}">
                    <input accept="image/*" type='file' name="image2" id="inputBanner2" class="invisible" />
                </div>
            @else
                <div class="col-sm-4 position-relative">
                    <img src="{{ Hpx::image_src('', $dummy_image) }}" id="showBanner2" class="show-banner img-hover"
                        data-dummy-image="{{ $dummy_image }}">
                    <input accept="image/*" type='file' name="image2" id="inputBanner2" class="invisible" />
                </div>
            @endif
            @if (count($data->imgmd) == 3)
                <div class="col-sm-4 position-relative">
                    <img src="{{ Hpx::image_src($data->imgmd[2]->image, $dummy_image) }}" id="showBanner3"
                        class="show-banner img-hover" data-dummy-image="{{ $dummy_image }}">
                    <input accept="image/*" type='file' name="image3" id="inputBanner3" class="invisible" />
                </div>
            @else
                <div class="col-sm-4 position-relative">
                    <img src="{{ Hpx::image_src('', $dummy_image) }}" id="showBanner3" class="show-banner img-hover"
                        data-dummy-image="{{ $dummy_image }}">
                    <input accept="image/*" type='file' name="image3" id="inputBanner3" class="invisible" />
                </div>
            @endif




            <div class="row justify-content-center mt-5">
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary fs-4 mt-4 w-100 shadow-lg disable_btn">
                        Save

                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection


@section('script')
    <script>
        let api = new ApiService();
        $(document).ready(function() {
            Laraberg.init('html_content');
            $('#unit-set').hide();
            $('.alert').alert();
            setTimeout(() => {
                $('.alert').alert('close')
            }, 2000)


            $('input[name="regular_price"]').on('input', function(e) {
                if ($('input[name="selling_price"]').val() != 0) {
                    let sellPrice = $('input[name="selling_price"]').val();
                    discountCalc(this.value, sellPrice)
                }


            });
            $('input[name="selling_price"]').on('input', function(e) {
                if ($('input[name="regular_price"]').val() != 0) {
                    let regularPrice = $('input[name="regular_price"]').val();
                    discountCalc(regularPrice, this.value)
                }


            });

            function discountCalc(regular, sell) {
                if (regular != "0" && sell != "0") {
                    let cal = 0;
                    cal = Math.round(((regular - sell) / (regular)) * 100);

                    $("#disc").val(cal + "%");
                    $('input[name="discount"]').val(cal);

                }
            }


            $('#frm').submit(function(e) {
                // e.preventDefault();
                $('button[type=submit]').html(
                    `<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span> Save`
                );

            });


        });



        $(document).ready(function() {
            if ("{{ $data->category }}" == "Fertilizer") {
                $('#unit-set').show();
            }
            image_edit('#showBanner1', '{{ route($route_name . '.store') }}', 'DELETE_IMAGE', {{ $data->id }},
                'image1');
            image_edit('#showBanner2', '{{ route($route_name . '.store') }}', 'DELETE_IMAGE', {{ $data->id }},
                'image2');
            image_edit('#showBanner3', '{{ route($route_name . '.store') }}', 'DELETE_IMAGE', {{ $data->id }},
                'image3');
        });

        $('[name="category"]').on('change', function(e) {
            $('[name="sub_category"]').empty()
            if ($('[name="category"]').val() == "Fertilizer") {
                $('#unit-set').show();
            } else {
                $('#unit-set').hide();
            }
            let req = api.getData("{{ url('admin/sub-category') }}" + "/" + this.value);
            req.then((res) => {
                if (res.status == true) {
                    $.each(res.data, function(index, item) {
                        $('[name="sub_category"]').append(new Option(item.name, item.name));
                    });
                } else {
                    alert(res.message);
                    // location.reload();
                }
            });
        });
    </script>
@endsection
