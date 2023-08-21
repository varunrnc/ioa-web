@extends('web.layouts.master')
@section('title','IOA')
@section('head')
@endsection
@section('main-content')
@include('web.includes.home.slider')
@include('web.includes.home.shipping')
@include('web.includes.home.category')
@include('web.includes.home.trending_products')
@include('web.includes.home.products')
@include('web.includes.home.blog')
@include('web.includes.home.testimonials')
<div class="col-12 mt-1"></div>
@endsection


@section('style')
<style type="text/css">
@media only screen and (min-width: 1600px){
	.section--padding {
	    padding-top: 2rem;
	    padding-bottom: 2rem;
	}
}	
</style>
@endsection

