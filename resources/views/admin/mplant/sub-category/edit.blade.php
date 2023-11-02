@extends('admin.layouts.admin_layout')
@section('title', 'IOA')
@section('main-content')

    <div class="admin-container">

        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Edit Category';
            $route_name = 'category';
            $dummy_image = asset('assets/img/other/select-image.jpg');
            // $exist_image = 'assets/img/category/' . $data->img_sm;
        @endphp
        @include('admin.includes.title-bar')

        <form id="frm" class="row" action="{{ route('admin.mplant.subcategory.update') }}" method="POST"
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
            <input type="hidden" value="{{ $data->id }}" name="id">
            <div class="col-md-8">


                <div class="col-12">
                    <label for="" class="form-label">Category</label>
                    <select class="form-select" name="category">
                        <option value="">Select</option>
                        @foreach ($cat as $item)
                            <option value="{{ $item->category }}"
                                {{ $data->category == $item->category ? 'selected' : '' }}>
                                {{ $item->category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Sub Category</label>
                    <input type="text" class="form-control" name="sub_category" value="{{ $data->sub_category }}"
                        onkeyup="this.value = this.value.toUpperCase();">
                    @error('sub_category')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description">{{ $data->description }}</textarea>
                    @error('description')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Status</label>
                    <select id="" class="form-select" name="status">
                        <option value="1" {{ $data->status == 1 ? 'selected' : null }}>Active</option>
                        <option value="0" {{ $data->status == 0 ? 'selected' : null }}>Deactive</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 position-relative">

                <img src="{{ url($data->img_sm) }}" id="showBanner" class="show-banner img-hover"
                    data-dummy-image="{{ $dummy_image }}">
                <input accept="image/*" type='file' name="image" id="inputBanner" class="invisible" />
                @error('image')
                    <span class="text-danger">* {{ $message }}</span>
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
        $(document).ready(function() {
            image_edit('#showBanner');
            $('.alert').alert();
            setTimeout(() => {
                $('.alert').alert('close')
            }, 3000)
        });
        $('#frm').submit(function(e) {
            // e.preventDefault();
            $('button[type=submit]').html(
                `<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span> Save`
            );

        });
    </script>
@endsection
