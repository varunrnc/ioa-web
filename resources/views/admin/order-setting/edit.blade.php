@extends('admin.layouts.admin_layout')
@section('title',env('APP_NAME'))
@section('main-content')

<div class="admin-container">
	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Edit Product';
        $route_name = 'product';
        $dummy_image = asset('assets/img/other/select-image.jpg');
        $exist_image1 = 'assets/img/product/'.$data->image1;
        $exist_image2 = 'assets/img/product/'.$data->image2;
        $exist_image3 = 'assets/img/product/'.$data->image3;
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="{{route($route_name.'.store')}}" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="UPDATE" name="action">
	<input type="hidden" value="{{$data->id}}" name="id">
	<div class="col-12">
		<div class="row">
			<div class="col-12">
				<label for="" class="form-label">Title</label>
				<input type="text" class="form-control" name="title" value="{{$data->title}}">
			</div>
			<div class="col-12">
				<label for="" class="form-label">Slug</label>
				<input type="text" class="form-control" name="slug" value="{{$data->slug}}" disabled>
			</div>
			<div class="col-12">
				<label for="" class="form-label">Description</label>
				<textarea class="form-control" rows="4" name="description">{{$data->description}}</textarea>
			</div>
			<div class="col-12">
				<label for="" class="form-label">Full Details</label>
				<textarea class="form-control" id="html_content" name="html_content" hidden>{{$data->html_content}}</textarea>
			</div>
			<div class="col-sm-4">
				<label for="" class="form-label">Regular Price</label>
				<input type="text" class="form-control" name="regular_price" value="{{$data->regular_price}}">
			</div>
			<div class="col-sm-4">
				<label for="" class="form-label">Selling Price</label>
				<input type="text" class="form-control" name="selling_price" value="{{$data->selling_price}}">
			</div>
			<div class="col-sm-4">
				<label for="" class="form-label">Discount</label>
				<input type="text" class="form-control" name="discount" value="{{$data->discount}}%" disabled>
			</div>
			<div class="col-sm-4">
					<label for="" class="form-label">Category</label>
					<select class="form-select" name="category">
						<option value="">Select</option>
						@foreach($categories as $category)
					  		<option value="{{$category->name}}" {{$data->category == $category->name ? 'selected':null}}>{{$category->name}}</option>
					  	@endforeach
					</select>
				</div>
			<div class="col-sm-2">
				<label for="" class="form-label">Weight</label>
				<input type="text" class="form-control" name="weight" value="{{$data->weight}}">
			</div>
			<div class="col-sm-2">
					<label for="" class="form-label">Shipping Charge</label>
					<input type="text" class="form-control" name="shipping_charge" value="{{$data->shipping_charge}}">
				</div>			
			<div class="col-sm-4">
				<label for="" class="form-label">Status</label>
				<select id="" class="form-select" name="status">
					<option value="1" {{$data->status == 1 ? 'selected' : null}}>Active</option>
					<option value="0" {{$data->status == 0 ? 'selected' : null}}>Deactive</option>
				</select>
			</div>
		</div>
	</div>

	<div class="col-sm-4 position-relative">
		<img src="{{ Hpx::image_src($exist_image1,$dummy_image) }}" id="showBanner1" class="show-banner img-hover" data-dummy-image="{{$dummy_image}}">
		<input accept="image/*" type='file' name="image1" id="inputBanner1" class="invisible" />
	</div>
	<div class="col-sm-4 position-relative">
		<img src="{{ Hpx::image_src($exist_image2,$dummy_image) }}" id="showBanner2" class="show-banner img-hover" data-dummy-image="{{$dummy_image}}">
		<input accept="image/*" type='file' name="image2" id="inputBanner2" class="invisible" />
	</div>
	<div class="col-sm-4 position-relative">
		<img src="{{ Hpx::image_src($exist_image3,$dummy_image) }}" id="showBanner3" class="show-banner img-hover" data-dummy-image="{{$dummy_image}}">
		<input accept="image/*" type='file' name="image3" id="inputBanner3" class="invisible" />
	</div>

	<div class="col-12">
		<button type="button" class="btn btn-primary fs-4 mt-4 disable_btn" onclick="submit_form()">
			Save 
			{!! Hpx::spinner('none') !!}
		</button>
	</div>
</form>

</div>
@endsection


@section('script')
<script>

	$(document).ready(function(){
		Laraberg.init('html_content');
		set_discount('[name="regular_price"]','[name="selling_price"]','[name="discount"]');
	});
	

	function submit_form(){
		var x = new Ajx;
		x.form = '#myForm';
		x.ajxLoader('#myForm .loaderx');
		x.disableBtn('#myForm .disable_btn');
		x.globalAlert(true);
		x.start(function(response){
			if(response.status == true){
				location.reload();
			}
		});
	}

	$(document).ready(function(){
		image_edit('#showBanner1','{{route($route_name.".store")}}','DELETE_IMAGE',{{$data->id}},'image1');
		image_edit('#showBanner2','{{route($route_name.".store")}}','DELETE_IMAGE',{{$data->id}},'image2');
		image_edit('#showBanner3','{{route($route_name.".store")}}','DELETE_IMAGE',{{$data->id}},'image3');
	});

</script>
@endsection


