@extends('admin.layouts.admin_layout')
@section('title', 'IOA')
@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Add Plants';
            $route_name = 'category';
            $dummy_image = asset('assets/img/other/select-image.jpg');
        @endphp
        @include('admin.includes.title-bar')

        <form id="frm" class="row" action="{{ route('admin.mplant.save') }}" method="POST"
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

            <div class="row">
                <div class="col-12">
                    <label for="" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title"
                        onkeyup="this.value = this.value.toUpperCase();">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Category</label>
                    <select class="form-select" name="category">
                        <option value="">Select</option>
                        @foreach ($cat as $item)
                            <option value="{{ $item->category }}">{{ $item->category }}</option>
                        @endforeach


                    </select>
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="" class="form-label">Sub Category</label>
                    <select class="form-select" name="sub_category">
                        <option value="">Select</option>



                    </select>
                    @error('sub-category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Soil</label>
                    <textarea class="form-control" name="soil"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Time of Sowing</label>
                    <textarea class="form-control" name="time_of_showing"></textarea>

                </div>
                <div class="col-12">
                    <label class="form-label">Watering</label>
                    <textarea class="form-control" name="watering"></textarea>

                </div>
                <div class="col-12">
                    <label class="form-label">Fertilizer Requirement</label>
                    <textarea class="form-control" name="fertilizer_requirement"></textarea>

                </div>
                <div class="col-12">
                    <label class="form-label">Pest And Diseases</label>
                    <textarea class="form-control" name="pest_and_diseases"></textarea>

                </div>
                <div class="col-12">
                    <label class="form-label">Spacial Care</label>
                    <textarea class="form-control" name="special_care"></textarea>

                </div>
                <div class="col-12">
                    <label for="" class="form-label">Status</label>
                    <select id="" class="form-select" name="status">
                        <option value="1" selected>Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 position-relative">

                <button type="button" class="btn btn-sm btn-danger del_icon_btn" onclick="remove_image('#showBanner1')">
                    <i class="icofont-ui-delete"></i>
                </button>

                <img src="{{ $dummy_image }}" id="showBanner1" class="pimg img-hover"
                    onclick="document.getElementById('inputBanner1').click()">
                <input accept="image/*" type='file' name="image1" id="inputBanner1" class="invisible" />
                <label for="" class="form-label">Icon</label>
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
                <label for="" class="form-label">Image</label>
                @error('image2')
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
    <script type="text/javascript">
        let api = new ApiService();
        $(document).ready(function() {

            $('.alert').alert();
            setTimeout(() => {
                $('.alert').alert('close')
            }, 3000)

            // frm

            $('#frm').submit(function(e) {
                // e.preventDefault();
                $('button[type=submit]').html(
                    `<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span> Save`
                );

            });

            // image
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
            //
            function remove_image(img) {
                $(img).attr('src', '{{ $dummy_image }}');
                $(img).closest('div').find('.del_icon_btn').hide();
                $(img).closest('div').find('input[type="file"]').val(null);
            }

            $("select[name=category]").change(function(e) {


                let req = api.getData("category/" + this.value)
                req.then((res) => {
                    const dataList = res.data;

                    console.log(dataList);

                    if (res.status == true) {
                        $("select[name=sub_category]")
                            .empty()
                            .append('<option  value="">select</option>')
                        dataList.forEach(function(item) {
                            $("select[name=sub_category]").append($('<option></option>')
                                .val(item.sub_category).text(item
                                    .sub_category));
                        });


                    }
                });
            })
        });
    </script>

@endsection
