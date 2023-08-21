@extends('admin.layouts.admin_layout')

@section('title','IOA')

@section('main-content')

@include('admin.includes.helper')

<div class="admin-container">

	@php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Edit Category';
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="{{route('post-category.store')}}" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="UPDATE_CATEGORY" name="action">
	<input type="hidden" value="{{$category->id}}" name="id">
	<div class="col-md-8">
		<div class="col-12">
			<label for="" class="form-label">Name</label>
			<input type="text" class="form-control" value="{{$category->name}}" name="name">
		</div>
		<div class="col-12">
			<label for="" class="form-label">Slug</label>
			<input type="text" class="form-control" value="{{$category->slug}}" name="slug" readonly>
		</div>
		<div class="col-12">
			<label class="form-label">Description</label>
			<textarea class="form-control" name="description">{{$category->description}}</textarea> 
		</div>
		<div class="col-12">
			<label for="" class="form-label">Status</label>
			<select id="" class="form-select" name="status">
				<option value="1" {{$category->status == 1 ? 'selected' : null}}>Publish</option>
				<option value="0" {{$category->status == 0 ? 'selected' : null}}>Not Publish</option>
			</select>
		</div>
	</div>
	<div class="col-md-3 upd-img">
		@if(file_exists('assets/img/post-category/'.$category->image) and !empty($category->image))
		<img src="{{ asset('assets/img/post-category/'.$category->image) }}?{{rand()}}" id="showBanner" class="mt-5 rounded img-hover w-100" onclick="document.getElementById('inputBanner').click()" style="max-width:170px;">
		@else
		<img src="{{ asset('assets/img/other/category.jpg') }}?{{rand()}}" id="showBanner" class="mt-5 rounded img-hover w-100" onclick="document.getElementById('inputBanner').click()" style="max-width:170px;">
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

