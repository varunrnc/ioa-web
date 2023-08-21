<!-- Start product section -->
<section class="product__section section--padding">
    <div class="container">
        <div class="section__heading text-center mb-25">
            <span class="section__heading--subtitle">Recently added our store</span>
            <h2 class="section__heading--maintitle">Trending Products</h2>
        </div>               
        <div class="tab_content">
            <div id="product_all" class="tab_pane active show">
                <div class="product__section--inner">
                    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n28">
                        @foreach($products as $data)
                        <div class="col mb-28">
                            <div class="product__items">
                                <div class="product__items--thumbnail">
                                    <a class="product__items--link" href="product-details.html">
                                        <img class="product__items--img product__primary--img rounded bg-light" src="{{Hpx::image_src('assets/img/product/thumbnail/'.$data->image1,'assets/img/product/thumbnail/dummy.png')}}" alt="{{$data->title}}">
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
                </div>
            </div>
        </div>
    </div>
    <div class="container text-end mt-2">
        <a href="#" class="btnx-outline fs-4">View All <i class="icofont-arrow-right"></i></a>
    </div>
</section>
<!-- End product section -->
