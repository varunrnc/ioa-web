@extends('web.layouts.master')

@section('title','IOA')


@section('style')
<style type="text/css">
    .add__to--cart__btn{
        font-size: 15px !important;
        border-radius: 37px !important;
    }
    .current__price {
        color: #2e910f;
    }
    .wx-100{ width: 100%; }
    @media screen and (max-width: 990px){
        .product__view--search__form{ width: 100% !important; }
        .wx-100{ width: 62% !important; }
    }
</style>
@endsection


@section('main-content')

<!-- Start shop section -->
<section class="shop__section my-5">
    <div class="container-fluid">
        <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
            <button class="widget__filter--btn d-flex d-lg-none align-items-center me-0" data-offcanvas="">
                <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80"></path>
                    <circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle>
                    <circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle>
                    <circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle>
                </svg>
                <span class="widget__filter--btn__text">Filter</span>
            </button>
            <div class="product__view--mode d-flex justify-content-between wx-100 align-items-center">
                <div class="product__view--mode__list product__short--by">
                    <label class="product__view--label fs-3 d-none d-lg-block">Our Products</label>
                </div>
                <div class="product__view--mode__list product__view--search">
                    <form class="product__view--search__form" action="#">
                        <label>
                            <input class="product__view--search__input border-1" placeholder="Search by" type="text">
                        </label>
                        <button class="product__view--search__btn" aria-label="search btn" type="submit">
                            <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="shop__sidebar--widget widget__area d-none d-lg-block">
                    @include('web.includes.shop.filter')
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="shop__product--wrapper">
                    <div class="tab_content">
                        <div id="product_grid" class="tab_pane active show">
                            <div class="product__section--inner product__section--style3__inner">
                                <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-3 row-cols-2 mb--n30">
                                    @foreach($products as $data)
                                    <div class="col mb-30">
                                        <div class="product__items product__items2">
                                            <div class="product__items--thumbnail">
                                                <a class="product__items--link" href="product-details.html">
                                                     <img class="product__items--img product__primary--img bg-light" src="{{Hpx::image_src('assets/img/product/thumbnail/'.$data->image1,'assets/img/product/thumbnail/dummy.png')}}" alt="{{$data->title}}" title="{{$data->title}}">
                                                </a>                  
                                            </div>
                                            <div class="product__items--content pb-3 text-center">
                                                <a class="add__to--cart__btn" href="javascript:void(0)" data-id="{{$data->id}}">
                                                    + Add to cart
                                                </a>
                                                <h3 class="product__items--content__title h6">
                                                    <a href="product-details.html">{{$data->title}}</a>
                                                </h3>
                                                <div class="product__items--price">
                                                    <span class="current__price">₹{{$data->selling_price}}</span>
                                                    <span class="old__price">₹{{$data->regular_price}}</span>
                                                </div>                                                
                                                <div class="product__items--rating d-flex justify-content-center align-items-center">
                                                    <ul class="d-flex">
                                                        <li class="product__items--rating__list">
                                                            <span class="product__items--rating__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="10.105" height="9.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="product__items--rating__list">
                                                            <span class="product__items--rating__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="10.105" height="9.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="product__items--rating__list">
                                                            <span class="product__items--rating__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="10.105" height="9.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="product__items--rating__list">
                                                            <span class="product__items--rating__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="10.105" height="9.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                        <li class="product__items--rating__list">
                                                            <span class="product__items--rating__icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="10.105" height="9.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="#c7c5c2"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <span class="product__items--rating__count--number">(24)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Hpx::paginator($products) !!}
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End shop section -->


<div class="offcanvas__filter--sidebar widget__area">
        <button type="button" class="offcanvas__filter--close" data-offcanvas="">
            <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"></path></svg> <span class="offcanvas__filter--close__text">Close</span>
        </button>
        <div class="offcanvas__filter--sidebar__inner">
            @include('web.includes.shop.filter')
        </div>
    </div>
@endsection


@section('script')

@endsection