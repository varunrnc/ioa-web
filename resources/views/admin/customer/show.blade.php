@extends('admin.layouts.admin_layout')
@section('title','IOA')
@section('main-content')

<div class="admin-container">
    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Customer Details';
        $route_name = 'customer';
        $dir_name = 'customer';
        $dummy_image = 'assets/img/other/select-image.jpg';
        $exist_image = 'assets/img/'.$dir_name.'/'.$data->image;
    @endphp
    @include('admin.includes.title-bar')

<form class="row" action="" enctype="multipart/form-data" id="myForm">
	<input type="hidden" value="{{$data->id}}" name="id">
	<div class="col-md-7">
		<div class="row">
			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>Student Name</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->name ?? 'N/A'}}</span>			
			</div>
			
			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>DOB</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->dob ?? 'N/A'}}</span>			
			</div>

			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>Gender</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->gender ?? 'N/A'}}</span>			
			</div>

			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>Mobile</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->mobile ?? 'N/A'}}</span>			
			</div>

			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>Email</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->email ?? 'N/A'}}</span>			
			</div>

		

			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>City</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->city ?? 'N/A'}}</span>			
			</div>

			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>State</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->state ?? 'N/A'}}</span>			
			</div>

			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>Pincode</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{{$data->pincode ?? 'N/A'}}</span>			
			</div>
			
			<div class="col-6 border border-end-0">
				<span class="float-end">:</span>
				<h5>Status</h5>
			</div>
			<div class="col-6 border border-start-0">
				<span>{!! $data->status == 1 ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Deactive</span>' !!}</span>			
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<img src="{{ Hpx::image_src($exist_image,$dummy_image) }}" id="showBanner" class="show-banner img-hover" style="margin-top:0;">
	</div>
</form>

</div>
@endsection


@section('script')
<script type="text/javascript">



</script>
@endsection

