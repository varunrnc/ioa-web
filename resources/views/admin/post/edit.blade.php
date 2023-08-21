@extends('admin.layouts.admin_layout')
@section('title',env('APP_NAME'))
@section('main-content')

<div class="admin-container">
	
	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Edit Post';
        $route_name = 'post';
        $dummy_image = asset('assets/img/other/select-image.jpg');
        $exist_image = 'assets/img/post/'.$data->image;
        $thumbnail = 'assets/img/post/thumbnail/'.$data->thumbnail;
    @endphp
    @include('admin.includes.title-bar')

	<form class="row" action="{{route($route_name.'.store')}}" enctype="multipart/form-data" id="myForm">
		<input type="hidden" value="UPDATE" name="action">
		<input type="hidden" value="{{$data->id}}" name="id">
		<div class="col-md-12">
			<div class="row">
				<div class="col-12">
					<label for="" class="form-label">Title</label>
					<input type="text" class="form-control" name="title" value="{{$data->title}}">
				</div>				
				<div class="col-12">
					<label for="" class="form-label">Slug</label>
					<input type="text" class="form-control" readonly value="{{$data->slug}}">
				</div>
				<div class="col-12">
					<label for="" class="form-label">Meta Title</label>
					<input type="text" class="form-control" name="meta_title" value="{{$data->meta_title}}">
				</div>
				<div class="col-12">
					<label for="" class="form-label">Meta Description</label>
					<textarea class="form-control" rows="2" name="meta_description">{{$data->meta_description}}</textarea>
				</div>
				<div class="col-12">
					<label for="" class="form-label">Meta Keywords</label>
					<input type="text" class="form-control" name="meta_keywords" value="{{$data->meta_keywords}}">
				</div>
				<div class="col-12">
					<label for="" class="form-label">Meta Author Name</label>
					<input type="text" class="form-control" name="author_name" value="{{$data->author_name}}">
				</div>
				<div class="col-12">
					<label for="" class="form-label">Content</label>
					<textarea class="form-control" id="html_content" name="content" hidden>{{$data->content}}</textarea>
				</div>
	
				<div class="col-sm-4">
					<label for="" class="form-label">Category</label>
					<select class="form-select" name="category">
						<option value="">Select</option>
						@foreach($categories as $category)
					  		<option value="{{$category->name}}" {{$data->category == $category->name ? 'selected':null}}>
					  			{{$category->name}}
					  		</option>
					  	@endforeach
					</select>
				</div>
				<div class="col-sm-4">
					<label class="form-label">Status</label>
					<select class="form-select" name="status">
						<option value="1" {{$data->status == 1 ? 'selected' : null}}>Active</option>
						<option value="0" {{$data->status == 0 ? 'selected' : null}}>Deactive</option>
					</select>
				</div>
				<div class="col-md-6">
					<label class="form-label">Featured Image</label>
					<img src="{{ Hpx::image_src($exist_image,$dummy_image) }}" id="showBanner" class="show-banner img-hover mt-1" data-dummy-image="{{$dummy_image}}">
					<input accept="image/*" type="file" name="image" id="inputBanner" class="invisible" />
				</div>
				<!-- <div class="col-md-4">
					<label class="form-label">Thumbnail Image (270x249)</label>
					<img src="{{ Hpx::image_src($thumbnail,$dummy_image) }}" id="showBanner2" class="show-banner img-hover mt-1" data-dummy-image="{{$dummy_image}}">
					<input accept="image/*" type="file" name="thumbnail" id="inputBanner2" class="invisible" />
				</div> -->

			</div>	
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
		image_edit('#showBanner','{{route($route_name.".store")}}','DELETE_IMAGE',{{$data->id}},'image');
		// image_edit('#showBanner2','{{route($route_name.".store")}}','DELETE_THUMBNAIL',{{$data->id}},'thumbnail');
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
				location.reload();
			}
		});
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

