@extends('admin.layouts.admin_layout')
@section('title', env('APP_NAME'))
@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Add Plant';
            $route_name = 'product';
            $dummy_image = asset('assets/img/other/select-image.jpg');
        @endphp
        @include('admin.includes.title-bar')


        <form id="frm" class="row" action="{{ route('admin.plant.save') }}" method="POST"
            enctype="multipart/form-data">

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

            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="" class="form-label">Short Description</label>
                        <textarea class="form-control" rows="4" name="short_description"></textarea>
                        @error('short_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="" class="form-label">Long Description</label>
                        <textarea class="form-control" id="html_content" name="long_description" hidden></textarea>

                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Regular Price</label>
                        <input type="text" class="form-control" name="regular_price">
                        @error('regular_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Selling Price</label>
                        <input type="text" class="form-control" name="selling_price">
                        @error('selling_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Discount</label>
                        <input type="text" id="disc" class="form-control" readonly>
                        <input type="text" name="discount" hidden>

                    </div>
                    <div class="col-sm-4">
                        <label for="" class="form-label">Category</label>
                        <select class="form-select" name="category">
                            <option value="">Select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
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
                            {{-- @foreach ($subCat as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach --}}
                        </select>
                        @error('sub_category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-4">
                        <label for="" class="form-label">Rating</label>
                        <input type="number" class="form-control" name="rating" min="1" max="5"
                            value="4">
                        @error('rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="unit-set" class="row">
                        <div class="col-sm-4">
                            <label for="" class="form-label">Unit</label>
                            <select class="form-select" name="unit">
                                <option value="KG" selected>KG</option>
                                <option value="GM">GM</option>
                                <option value="Ltr">Ltr</option>
                                <option value="ML">ML</option>
                                <option value="Combo">Combo</option>
                            </select>
                            @error('unit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="form-label">Weight in Unit</label>
                            <input type="number" class="form-control" name="weight">
                            @error('weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="" class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="1" selected>Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 position-relative">
                <button type="button" class="btn btn-sm btn-danger del_icon_btn" onclick="remove_image('#showBanner1')">
                    <i class="icofont-ui-delete"></i>
                </button>
                <img src="{{ $dummy_image }}" id="showBanner1" class="pimg img-hover"
                    onclick="document.getElementById('inputBanner1').click()">
                <input accept="image/*" type='file' name="image1" id="inputBanner1" class="invisible" />
                @error('image1')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-4 position-relative">
                <button type="button" class="btn btn-sm btn-danger del_icon_btn" onclick="remove_image('#showBanner2')">
                    <i class="icofont-ui-delete"></i>
                </button>
                <img src="{{ $dummy_image }}" id="showBanner2" class="pimg img-hover"
                    onclick="document.getElementById('inputBanner2').click()">
                <input accept="image/*" type='file' name="image2" id="inputBanner2" class="invisible" />
                @error('image2')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-4 position-relative">
                <button type="button" class="btn btn-sm btn-danger del_icon_btn" onclick="remove_image('#showBanner3')">
                    <i class="icofont-ui-delete"></i>
                </button>
                <img src="{{ $dummy_image }}" id="showBanner3" class="pimg img-hover"
                    onclick="document.getElementById('inputBanner3').click()">
                <input accept="image/*" type='file' name="image3" id="inputBanner3" class="invisible" />
                @error('image3')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
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
            $('#unit-set').hide();
            $('.alert').alert();
            setTimeout(() => {
                $('.alert').alert('close')
            }, 5000)
            Laraberg.init('html_content');


            $('[name="regular_price"]').on('input', function(e) {
                if ($('[name="selling_price"]').val() != 0) {
                    let sellPrice = $('[name="selling_price"]').val();
                    discountCalc(this.value, sellPrice)
                }


            });
            $('[name="selling_price"]').on('input', function(e) {
                if ($('[name="regular_price"]').val() != 0) {
                    let regularPrice = $('[name="regular_price"]').val();
                    discountCalc(regularPrice, this.value)
                }


            });

            function discountCalc(regular, sell) {
                if (regular != "0" && sell != "0") {
                    let cal = 0;
                    cal = Math.round(((regular - sell) / (regular)) * 100);

                    $("#disc").val(cal + "%");
                    $('[name="discount"]').val(cal);

                }
            }

        });

        inputBanner1.onchange = evt => {
            const [file] = inputBanner1.files
            if (file) {
                showBanner1.src = URL.createObjectURL(file);
                $('#inputBanner1').closest('div').find('.del_icon_btn').show();
            }
        }

        inputBanner2.onchange = evt => {
            const [file] = inputBanner2.files
            if (file) {
                showBanner2.src = URL.createObjectURL(file);
                $('#inputBanner2').closest('div').find('.del_icon_btn').show();
            }
        }

        inputBanner3.onchange = evt => {
            const [file] = inputBanner3.files
            if (file) {
                showBanner3.src = URL.createObjectURL(file);
                $('#inputBanner3').closest('div').find('.del_icon_btn').show();
            }
        }

        // function submit_form() {
        //     var x = new Ajx;
        //     x.form = '#myForm';
        //     x.ajxLoader('#myForm .loaderx');
        //     x.disableBtn('#myForm .disable_btn');
        //     x.globalAlert(true);
        //     x.reset = true;
        //     x.start(function(response) {
        //         if (response.status == true) {
        //             showBanner1.src = "{{ $dummy_image }}";
        //             showBanner2.src = "{{ $dummy_image }}";
        //             showBanner3.src = "{{ $dummy_image }}";
        //         }
        //     });
        // }

        $('#frm').submit(function(e) {
            // e.preventDefault();
            $('button[type=submit]').html(
                `<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span> Save`
            );

        });

        function remove_image(img) {
            $(img).attr('src', '{{ $dummy_image }}');
            $(img).closest('div').find('.del_icon_btn').hide();
            $(img).closest('div').find('input[type="file"]').val(null);
        }
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

@section('style')
    <style type="text/css">
        .del_icon_btn {
            display: none;
        }
    </style>

@endsection
