@extends('admin.layouts.admin_layout')
@section('title',env('APP_NAME'))
@section('main-content')

<div class="admin-container">
	
	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Add Product';
        $route_name = 'product';
        $dummy_image = asset('assets/img/other/select-image.jpg');
    @endphp
    @include('admin.includes.title-bar')

	<form class="row" action="{{route($route_name.'.store')}}" enctype="multipart/form-data" id="myForm">
		<input type="hidden" value="CREATE" name="action">
		<div class="col-md-12">
			<div class="row">
				<div class="col-12">
					<label for="" class="form-label">Title</label>
					<input type="text" class="form-control" name="title">
				</div>
				<div class="col-12">
					<label for="" class="form-label">Description</label>
					<textarea class="form-control" rows="4" name="description"></textarea>
				</div>
				<div class="col-12">
					<label for="" class="form-label">Full Details</label>
					<textarea class="form-control" id="html_content" name="html_content" hidden></textarea>
				</div>
				<div class="col-sm-4">
					<label for="" class="form-label">Regular Price</label>
					<input type="text" class="form-control" name="regular_price">
				</div>
				<div class="col-sm-4">
					<label for="" class="form-label">Selling Price</label>
					<input type="text" class="form-control" name="selling_price">
				</div>
				<div class="col-sm-4">
					<label for="" class="form-label">Discount</label>
					<input type="text" class="form-control" name="discount" value="" disabled>
				</div>
				<div class="col-sm-4">
					<label for="" class="form-label">Category</label>
					<select class="form-select" name="category">
						<option value="">Select</option>
						@foreach($categories as $category)
					  		<option value="{{$category->name}}">{{$category->name}}</option>
					  	@endforeach
					</select>
				</div>
				<div class="col-sm-2">
					<label for="" class="form-label">Weight</label>
					<input type="text" class="form-control" name="weight">
				</div>
				<div class="col-sm-2">
					<label for="" class="form-label">Shipping Charge</label>
					<input type="text" class="form-control" name="shipping_charge" value="">
				</div>			
				<div class="col-sm-4">
					<label for="" class="form-label">Status</label>
					<select id="" class="form-select" name="status">
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
			<img src="{{$dummy_image}}" id="showBanner1" class="show-banner img-hover" onclick="document.getElementById('inputBanner1').click()">
			<input accept="image/*" type='file' name="image1" id="inputBanner1" class="invisible" />
		</div>
		<div class="col-sm-4 position-relative">
			<button type="button" class="btn btn-sm btn-danger del_icon_btn" onclick="remove_image('#showBanner2')">	
				<i class="icofont-ui-delete"></i>
			</button>
			<img src="{{$dummy_image}}" id="showBanner2" class="show-banner img-hover" onclick="document.getElementById('inputBanner2').click()">
			<input accept="image/*" type='file' name="image2" id="inputBanner2" class="invisible" />
		</div>
		<div class="col-sm-4 position-relative">
			<button type="button" class="btn btn-sm btn-danger del_icon_btn" onclick="remove_image('#showBanner3')">	
				<i class="icofont-ui-delete"></i>
			</button>
			<img src="{{$dummy_image}}" id="showBanner3" class="show-banner img-hover" onclick="document.getElementById('inputBanner3').click()">
			<input accept="image/*" type='file' name="image3" id="inputBanner3" class="invisible" />
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
<script>

	$(document).ready(function(){
		Laraberg.init('html_content');
		set_discount('[name="regular_price"]','[name="selling_price"]','[name="discount"]');
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

	function submit_form(){
		var x = new Ajx;
		x.form = '#myForm';
		x.ajxLoader('#myForm .loaderx');
		x.disableBtn('#myForm .disable_btn');
		x.globalAlert(true);
		x.reset = true;
		x.start(function(response){
			if(response.status == true){
				showBanner1.src = "{{$dummy_image}}";
				showBanner2.src = "{{$dummy_image}}";
				showBanner3.src = "{{$dummy_image}}";
			}
		});
	}

	function remove_image(img){
		$(img).attr('src','{{$dummy_image}}');
		$(img).closest('div').find('.del_icon_btn').hide();
		$(img).closest('div').find('input[type="file"]').val(null);
	}
</script>
@endsection

@section('style')
<style type="text/css">
	.del_icon_btn{
		display: none;
	}
</style>

@endsection

