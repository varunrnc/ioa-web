@extends('admin.layouts.admin_layout')
@section('title', 'IOA')
@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Edit Shipping Charge';
            $route_name = 'category';
            $dummy_image = asset('assets/img/other/select-image.jpg');
        @endphp
        @include('admin.includes.title-bar')

        <form id="frm" class="row" action="{{ route('admin.shipping.update') }}" method="POST">
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
                <input type="text" hidden name="id" value="{{ $data->id }}">
                <div class="col-12">
                    <label for="" class="form-label">Product</label>
                    <select class="form-select" name="product">
                        <option value="">Select</option>
                        <option value="Fertilizer" {{ $data->category == 'Fertilizer' ? 'selected' : '' }}>Fertilizer
                        </option>
                        <option value="Plant" {{ $data->category == 'Plant' ? 'selected' : '' }}>Plant</option>
                    </select>
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="" class="form-label">Shipping Charges</label>
                    <input type="number" class="form-control" name="shipping_charges" value="{{ $data->amount }}">
                    @error('shipping_charges')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="" class="form-label">Status</label>
                    <select id="" class="form-select" name="status">
                        <option value="1" selected>Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
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
        });
    </script>

@endsection
