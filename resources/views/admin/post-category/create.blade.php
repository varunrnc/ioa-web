@extends('admin.layouts.admin_layout')

@section('title','IOA')

@section('main-content')

<div class="admin-container">

	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Add Category';
        $dummy_image = asset('assets/img/other/select-image.jpg');
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="{{route('post-category.store')}}" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="CREATE_CATEGORY" name="action">
	<div class="col-md-8">
		<div class="col-12">
			<label for="" class="form-label">Name</label>
			<input type="text" class="form-control" name="name">
		</div>
		<div class="col-12">
			<label for="" class="form-label">Slug</label>
			<input type="text" class="form-control" name="slug" readonly>
		</div>
		<div class="col-12">
			<label class="form-label">Description</label>
			<textarea class="form-control" name="description"></textarea> 
		</div>
		<div class="col-12">
			<label for="" class="form-label">Status</label>
			<select id="" class="form-select" name="status">
				<option value="1" selected>Publish</option>
				<option value="0">Not Publish</option>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<img src="{{asset('assets/img/other/select-image.jpg')}}" id="showBanner" class="show-banner img-hover" data-dummy-image="{{$dummy_image}}">
		<input accept="image/*" type='file' name="image" id="inputBanner" class="invisible" />
	</div>
	<div class="col-12">
		<button type="button" class="btn btn-primary fs-4 mt-4 disable_btn" onclick="submit_form()">
			Save 
			{!! Hpx::spinner() !!}
		</button>
	</div>
</form>

</div>
@endsection


@section('script')
<script type="text/javascript">
	
	$(document).ready(function(){
		image_edit('#showBanner');
	});

	function submit_form(){
		var x = new Ajx;
		x.form = '#myForm';
		x.ajxLoader('#myForm .loaderx');
		x.disableBtn('#myForm .disable_btn');
		x.globalAlert(true);
		x.reset = true;
		x.start(function(response){
			if(response.status == true){
				showBanner.src = "{{asset('assets/img/other/category.jpg')}}";
			}
		});
	}
</script>

@endsection

