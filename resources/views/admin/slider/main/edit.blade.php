@extends('admin.layouts.admin_layout')
@section('title', 'IOA')
@section('main-content')

    <div class="admin-container">
        @php
            $tbx['tb'] = 1;
            $tbx['title'] = 'Edit Slider';
            $route_name = 'slider';
            $dir_name = 'slider';
            $dummy_image = 'assets/img/other/select-image.jpg';
            $exist_image = 'assets/img/' . $dir_name . '/' . $data->image;
        @endphp
        @include('admin.includes.title-bar')

        <form id="frm" class="row" action="{{ route('admin.mslider.update') }}" method="POST"
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
            <input type="text" name="id" value="{{ $data->id }}" hidden>
            <div class="col-md-7">
                <div class="col-12">
                    <label for="" class="form-label">Slider Name</label>
                    <input type="text" class="form-control" name="slider_name" value="{{ $data->slider_name }}">
                    @error('slider_name')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{ $data->title }}">
                    @error('title')
                        <span class="text-danger">* {{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description">{{ $data->description }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Button Name</label>
                    <input type="text" class="form-control" name="button_name" value="{{ $data->button_name }}">

                </div>
                <div class="col-12">
                    <label class="form-label">Button Link</label>
                    <input type="text" class="form-control" name="button_link" value="{{ $data->button_link }}">
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Status</label>
                    <select id="" class="form-select" name="status">
                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Deactive</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-5">
                <img src="{{ url('') . '/' . $data->img_sm }}" id="showBanner" class="show-banner img-hover"
                    data-dummy-image="{{ asset($dummy_image) }}">
                <input accept="image/*" type='file' name="image" id="inputBanner" class="invisible" />
                @error('image')
                    <span class="text-danger">* {{ $message }}</span>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary fs-4 mt-4 ">
                    Save
                </button>
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
            image_edit('#showBanner', '{{ route($route_name . '.store') }}', 'DELETE_IMAGE', {{ $data->id }},
                'image');

            $('#frm').submit(function(e) {

                $('button[type=submit]').html(
                    `<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span> Save`
                );

            });
        });
    </script>
@endsection
