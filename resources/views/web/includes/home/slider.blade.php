 <!-- Start slider section -->
<style type="text/css">
    .hero__slider--items{
        max-height: 500px !important;
    }
</style>
<section class="hero__slider--section">
    <div class="hero__slider--inner hero__slider--activation swiper">
        <div class="hero__slider--wrapper swiper-wrapper">
            @foreach($slider as $data)
            <div class="swiper-slide ">
                <div class="hero__slider--items bg__gray--color">
                    <div class="container slider__items--container">
                        <div class="hero__slider--items__inner">
                            <div class="row row-cols-lg-2 row-cols-md-2 row-cols-1 align-items-center">
                                <div class="col">
                                    <div class="slider__content slider__content--padding__left">
                                        <span class="slider__content--subtitle text__secondary text-capitalize">
                                            {{$data->slider_name}}
                                        </span>
                                        <h2 class="slider__content--maintitle h1 text-capitalize" id="slider_title_text">{{$data->title}}                 
                                        </h2>
                                        <p class="slider__content--desc text-capitalize">
                                            {{$data->description}}
                                        </p>    
                                        <a class="btn slider__btn text-capitalize" href="{{$data->button_link}}">
                                            {{$data->button_name}}
                                        </a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="hero__slider--layer">
                                        <img class="slider__layer--img " src="{{asset('assets/img/slider/'.$data->image)}}" alt="slider-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="slider__pagination swiper-pagination"></div>
    </div>
</section>
<!-- End slider section -->

<script type="text/javascript">
    $(document).ready(function(){
        jQuery("#slider_title_text").each(function(i, v){
            var newHTML = jQuery(this).html().split(" ");
            for (var i = 1; i < 3; i++){
                newHTML[i] = '<span class="text__secondary">' + newHTML[i] + '</span>';
            }
            jQuery(this).html(newHTML.join(" "));
        });
    });
</script>

