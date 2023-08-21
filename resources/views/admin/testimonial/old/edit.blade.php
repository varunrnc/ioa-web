@extends('admin.layouts.admin_layout')

@section('title','IOA')

@section('main-content')

@include('admin.includes.helper')

<div class="admin-container">

	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Edit Testimonial';
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="{{route('testimonial.store')}}" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="UPDATE_TESTIMONIAL" name="action">
	<input type="hidden" value="{{$testimonial->id}}" name="id">
	<div class="col-md-8">
		<div class="col-12">
			<label for="" class="form-label">Name</label>
			<input type="text" class="form-control" value="{{$testimonial->name}}" name="name">
		</div>
		<div class="col-12">
			<label for="" class="form-label">Place</label>
			<input type="text" class="form-control" value="{{$testimonial->place}}" name="place">
		</div>
		<div class="col-12">
			<label class="form-label">Message</label>
			<textarea class="form-control" name="message">{{$testimonial->message}}</textarea> 
		</div>
		<div class="col-12">
			<label for="" class="form-label">Status</label>
			<select id="" class="form-select" name="status">
				<option value="1" {{$testimonial->status == 1 ? 'selected' : null}}>Publish</option>
				<option value="0" {{$testimonial->status == 0 ? 'selected' : null}}>Not Publish</option>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		@if(file_exists('assets/img/testimonial/'.$testimonial->image) and !empty($testimonial->image))
		<img src="{{ asset('assets/img/testimonial/'.$testimonial->image) }}?{{rand()}}" id="showBanner" class="mt-5 rounded img-hover w-100" onclick="document.getElementById('inputBanner').click()" style="max-width: 124px;">
		@else
		<img src="{{ asset('assets/img/other/testimonial.jpg') }}?{{rand()}}" id="showBanner" class="mt-5 rounded img-hover w-100" onclick="document.getElementById('inputBanner').click()" style="max-width: 124px;">
		@endif
		<input accept="image/*" type='file' name="image" id="inputBanner" class="invisible" />
	</div>
	<div class="col-12">
		<button type="button" class="btn btn-primary fs-4 mt-4 disable_btn" onclick="submit_form()">
			Save 
			{!! loaderx() !!}
		</button>
	</div>
</form>
</div>
@endsection


@section('script')
<script type="text/javascript">
	
	inputBanner.onchange = evt => {
	  const [file] = inputBanner.files
	  if (file) {
	    showBanner.src = URL.createObjectURL(file)
	  }
	}

	function submit_form(){
		var x = new Ajx;
		x.form = '#myForm';
		x.ajxLoader('#myForm .loaderx');
		x.disableBtn('#myForm .disable_btn');
		x.globalAlert(true);
		x.start();
	}
</script>
@endsection

