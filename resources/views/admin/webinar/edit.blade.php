@extends('admin.layouts.admin_layout')
@section('title',env('APP_NAME'))
@section('main-content')

<div class="admin-container">
	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Edit Webinar';
        $route_name = 'webinar';
        $dummy_image = 'assets/img/other/select-image.jpg';
        $exist_image = 'assets/img/webinar/'.$data->image;
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="{{route($route_name.'.store')}}" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="UPDATE" name="action">
	<input type="hidden" value="{{$data->id}}" name="id">
	<div class="col-md-7">
		<div class="col-12">
			<label for="" class="form-label">Title</label>
			<input type="text" class="form-control" name="title" value="{{$data->title}}">
		</div>
		<div class="col-12">
			<label for="" class="form-label">Date</label>
			<input type="datetime-local" class="form-control" name="date" value="{{$data->date}}">
		</div>			
		<div class="col-12">
			<label for="" class="form-label">Link</label>
			<input type="text" class="form-control" name="link" value="{{$data->link}}">
		</div>
		<div class="col-12">
			<label for="" class="form-label">Type</label>
			<select id="" class="form-select" name="type">
				<option value="free" {{$data->type == 'free' ? 'selected' : null}}>Free</option>
				<option value="paid" {{$data->type == 'paid' ? 'selected' : null}}>Paid</option>
			</select>
		</div>
		<div class="col-12">
			<label for="" class="form-label">Status</label>
			<select id="" class="form-select" name="status">
				<option value="upcoming" {{$data->status == 'upcoming' ? 'selected' : null}}>Upcomming</option>
				<option value="live" {{$data->status == 'live' ? 'selected' : null}}>Live</option>
				<option value="completed" {{$data->status == 'completed' ? 'selected' : null}}>Completed</option>
			</select>
		</div>
	</div>
	<div class="col-md-5">
		<img src="{{Hpx::image_src($exist_image,$dummy_image)}}" id="showBanner" class="show-banner img-hover" data-dummy-image="{{asset($dummy_image)}}">
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
<script>

	function submit_form(){
		var x = new Ajx;
		x.form = '#myForm';
		x.ajxLoader('#myForm .loaderx');
		x.disableBtn('#myForm .disable_btn');
		x.globalAlert(true);
		x.start(function(response){
			if(response.status == true){
			}
		});
	}

	$(document).ready(function(){
		image_edit('#showBanner','{{route($route_name.".store")}}','DELETE_IMAGE',{{$data->id}},'image');
	});

</script>
@endsection


