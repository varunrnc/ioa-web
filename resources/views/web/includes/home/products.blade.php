<style type="text/css">
    .tpro-section .swiper-slide{ width: 200px !important; }
    .tpro-section .swiper-slide img{ border-radius: 4px; }
</style>

<!-- Start deal product section -->
<section class="product__section tpro-section section--padding">
    <div class="container">
        <div class="section__heading text-center mb-40">
            <h2 class="section__heading--maintitle">Top Rated Products</h2>
            <span class="section__heading--subtitle">Recently added our store</span>
        </div>
        <div class="product__section--inner product__swiper--activation swiper">
            <div class="swiper-wrapper">
                @foreach($products as $data)
                <div class="swiper-slide">
                    <div class="product__items">
                        <div class="product__items--thumbnail">
                            <a class="product__items--link" href="product-details.html">
                                <img class="product__items--img product__primary--img rounded bg-light" src="{{Hpx::image_src('assets/img/product/thumbnail/'.$data->image1,'assets/img/product/thumbnail/dummy.png')}}" alt="{{$data->title}}" title="{{$data->title}}">
                            </a>                
                        </div>
                        <div class="product__items--content text-center">
                            <a class="add__to--cart__btn fs-4" href="javascript:void(0)" data-id="{{$data->id}}">+ Add to cart</a>
                            <h3 class="product__items--content__title h6">
                                <a href="product-details.html">{{$data->title}}</a>
                            </h3>
                            <div class="product__items--price">
                                <span class="current__price">₹{{$data->selling_price}}</span>
                                <span class="old__price">₹{{$data->regular_price}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper__nav--btn swiper-button-next"></div>
            <div class="swiper__nav--btn swiper-button-prev"></div>
        </div>
    </div>
    <div class="container text-end mt-2">
        <a href="#" class="btnx-outline fs-4">View All <i class="icofont-arrow-right"></i></a>
    </div>
</section>
<!-- End deal product section -->