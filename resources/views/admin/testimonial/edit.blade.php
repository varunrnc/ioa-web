@extends('admin.layouts.admin_layout')
@section('title','IOA')
@section('main-content')

<div class="admin-container">
    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Edit Testimonial';
        $route_name = 'testimonial';
        $dir_name = 'testimonial';
        $dummy_image = 'assets/img/other/testimonial.jpg';
        $exist_image = 'assets/img/'.$dir_name.'/'.$data->image;
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="{{route($route_name.'.store')}}" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="UPDATE" name="action">
	<input type="hidden" value="{{$data->id}}" name="id">
	<div class="col-md-7">
		<div class="col-12">
			<label for="" class="form-label">Name</label>
			<input type="text" class="form-control" value="{{$data->name}}" name="name">
		</div>
		<div class="col-12">
			<label for="" class="form-label">Place</label>
			<input type="text" class="form-control" value="{{$data->place}}" name="place">
		</div>
		<div class="col-12">
			<label class="form-label">Message</label>
			<textarea class="form-control" name="message">{{$data->message}}</textarea> 
		</div>
		<div class="col-12">
			<label for="" class="form-label">Status</label>
			<select id="" class="form-select" name="status">
				<option value="1" {{$data->status == 1 ? 'selected' : null}}>Active</option>
				<option value="0" {{$data->status == 0 ? 'selected' : null}}>Deactive</option>
			</select>
		</div>
	</div>

	<div class="col-sm-5">
		<img src="{{ Hpx::image_src($exist_image,$dummy_image) }}" id="showBanner" class="show-banner img-hover" data-dummy-image="{{asset($dummy_image)}}">
		<input accept="image/*" type='file' name="image" id="inputBanner" class="invisible" />
	</div>
	
	<div class="col-12">
		<button type="button" class="btn btn-primary fs-4 mt-4 disable_btn" onclick="submit_form()">
			Save {!! Hpx::spinner('none') !!}
		</button>
	</div>
</form>

</div>
@endsection


@section('script')
<script type="text/javascript">

	$(document).ready(function(){
		image_edit('#showBanner','{{route($route_name.".store")}}','DELETE_IMAGE',{{$data->id}},'image');
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

</script>
@endsection

