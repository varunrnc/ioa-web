@extends('admin.layouts.admin_layout')
@section('title','IOA')
@section('main-content')

<div class="admin-container">

	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Edit Category';
        $route_name = 'category';
        $dummy_image = asset('assets/img/other/select-image.jpg');
        $exist_image = 'assets/img/category/'.$data->image;
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="{{route('category.store')}}" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="UPDATE" name="action">
	<input type="hidden" value="{{$data->id}}" name="id">
	<div class="col-md-8">
		<div class="col-12">
			<label for="" class="form-label">Name</label>
			<input type="text" class="form-control" value="{{$data->name}}" name="name">
		</div>
		<div class="col-12">
			<label for="" class="form-label">Slug</label>
			<input type="text" class="form-control" value="{{$data->slug}}" disabled>
		</div>
		<div class="col-12">
			<label class="form-label">Description</label>
			<textarea class="form-control" name="description">{{$data->description}}</textarea> 
		</div>
		<div class="col-12">
			<label for="" class="form-label">Status</label>
			<select id="" class="form-select" name="status">
				<option value="1" {{$data->status == 1 ? 'selected' : null}}>Active</option>
				<option value="0" {{$data->status == 0 ? 'selected' : null}}>Deactive</option>
			</select>
		</div>
	</div>
	<div class="col-sm-4 position-relative">
		@if(file_exists($exist_image) and !empty($data->image))
		<button type="button" class="btn btn-sm btn-danger del_icon_btn" onclick="delete_image('{{$data->image}}',this)">	
			<i class="icofont-ui-delete"></i>
		</button>		
		<img src="{{ asset($exist_image) }}?{{rand()}}" id="showBanner" class="show-banner img-hover" onclick="document.getElementById('inputBanner').click()">
		@else
		<button type="button" class="btn btn-sm btn-danger del_icon_btn hideit" onclick="delete_image('{{$data->image}}',this)">	
			<i class="icofont-ui-delete"></i>
		</button>
		<img src="{{$dummy_image}}" id="showBanner" class="show-banner img-hover" onclick="document.getElementById('inputBanner').click()">
		@endif
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
		image_edit('#showBanner','{{route($route_name.".store")}}','DELETE_IMAGE',{{$data->id}},'image');
	});

</script>
@endsection

