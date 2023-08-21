 <style type="text/css">
     .testimonial__bg {
        background: url('assets/img/home-page/testimonial_bg.png');
    }
 </style>
 <!-- Start testimonial section -->
<section class="testimonial__section testimonial__bg section--padding">
    <div class="container-fluid p-0">
        <div class="section__heading text-center mb-55">
            <span class="section__heading--subtitle">Recently added our store</span>
            <h2 class="section__heading--maintitle">Our Testimonial</h2>
        </div>
        <div class="testimonial__section--inner testimonial__swiper--activation swiper">
            <div class="swiper-wrapper">
                @foreach($testimonials as $data)
                <div class="swiper-slide">
                    <div class="testimonial__items d-flex align-items-center">
                        <div class="testimonial__items--thumbnail">
                            <img class="testimonial__items--thumbnail__img rounded-circle" src="{{asset('assets/img/testimonial/'.$data->image)}}" alt="{{$data->name}}">
                        </div>
                        <div class="testimonial__items--content">
                            <h3 class="testimonial__items--title">{{$data->name}}</h3>
                            <span class="testimonial__items--subtitle">{{$data->place}}</span>
                            <p class="testimonial__items--desc">{{$data->message}} Lorem ipsum dolor sit, amet consectetur is adipisicing elit. Recusandae iusto veritatis eveniet, amet sint are suscipit!</p>
                            <div class="ratting testimonial__ratting">
                                <ul class="d-flex testimonial__ratting--inner">
                                    <li class="testimonial__ratting--list">
                                        <span class="testimonial__ratting--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15.54" height="15.555" viewBox="0 0 20.54 19.555">
                                                <path  d="M9.947,24.316c.168-.388.446-.388.616,0L13,29.9a1.447,1.447,0,0,0,1.076.783l6.067.589c.423.039.507.3.191.585L15.77,35.9a1.456,1.456,0,0,0-.411,1.267l1.315,5.95c.092.415-.134.577-.5.364L10.92,40.4a1.45,1.45,0,0,0-1.331,0L4.335,43.485c-.368.214-.589.051-.5-.364l1.315-5.95A1.462,1.462,0,0,0,4.74,35.9L.176,31.862c-.316-.281-.232-.546.191-.585l6.069-.589A1.454,1.454,0,0,0,7.513,29.9l2.434-5.589Z" transform="translate(0.015 -24.025)" fill="currentColor"/>
                                            </svg>  
                                        </span>
                                    </li>
                                    <li class="testimonial__ratting--list">
                                        <span class="testimonial__ratting--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15.54" height="15.555" viewBox="0 0 20.54 19.555">
                                                <path  d="M9.947,24.316c.168-.388.446-.388.616,0L13,29.9a1.447,1.447,0,0,0,1.076.783l6.067.589c.423.039.507.3.191.585L15.77,35.9a1.456,1.456,0,0,0-.411,1.267l1.315,5.95c.092.415-.134.577-.5.364L10.92,40.4a1.45,1.45,0,0,0-1.331,0L4.335,43.485c-.368.214-.589.051-.5-.364l1.315-5.95A1.462,1.462,0,0,0,4.74,35.9L.176,31.862c-.316-.281-.232-.546.191-.585l6.069-.589A1.454,1.454,0,0,0,7.513,29.9l2.434-5.589Z" transform="translate(0.015 -24.025)" fill="currentColor"/>
                                            </svg>  
                                        </span>
                                    </li>
                                    <li class="testimonial__ratting--list">
                                        <span class="testimonial__ratting--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15.54" height="15.555" viewBox="0 0 20.54 19.555">
                                                <path  d="M9.947,24.316c.168-.388.446-.388.616,0L13,29.9a1.447,1.447,0,0,0,1.076.783l6.067.589c.423.039.507.3.191.585L15.77,35.9a1.456,1.456,0,0,0-.411,1.267l1.315,5.95c.092.415-.134.577-.5.364L10.92,40.4a1.45,1.45,0,0,0-1.331,0L4.335,43.485c-.368.214-.589.051-.5-.364l1.315-5.95A1.462,1.462,0,0,0,4.74,35.9L.176,31.862c-.316-.281-.232-.546.191-.585l6.069-.589A1.454,1.454,0,0,0,7.513,29.9l2.434-5.589Z" transform="translate(0.015 -24.025)" fill="currentColor"/>
                                            </svg>  
                                        </span>
                                    </li>
                                    <li class="testimonial__ratting--list">
                                        <span class="testimonial__ratting--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15.54" height="15.555" viewBox="0 0 20.54 19.555">
                                                <path  d="M9.947,24.316c.168-.388.446-.388.616,0L13,29.9a1.447,1.447,0,0,0,1.076.783l6.067.589c.423.039.507.3.191.585L15.77,35.9a1.456,1.456,0,0,0-.411,1.267l1.315,5.95c.092.415-.134.577-.5.364L10.92,40.4a1.45,1.45,0,0,0-1.331,0L4.335,43.485c-.368.214-.589.051-.5-.364l1.315-5.95A1.462,1.462,0,0,0,4.74,35.9L.176,31.862c-.316-.281-.232-.546.191-.585l6.069-.589A1.454,1.454,0,0,0,7.513,29.9l2.434-5.589Z" transform="translate(0.015 -24.025)" fill="currentColor"/>
                                            </svg>  
                                        </span>
                                    </li>
                                    <li class="testimonial__ratting--list">
                                        <span class="testimonial__ratting--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15.54" height="15.555" viewBox="0 0 20.54 19.555">
                                                <path  d="M9.947,24.316c.168-.388.446-.388.616,0L13,29.9a1.447,1.447,0,0,0,1.076.783l6.067.589c.423.039.507.3.191.585L15.77,35.9a1.456,1.456,0,0,0-.411,1.267l1.315,5.95c.092.415-.134.577-.5.364L10.92,40.4a1.45,1.45,0,0,0-1.331,0L4.335,43.485c-.368.214-.589.051-.5-.364l1.315-5.95A1.462,1.462,0,0,0,4.74,35.9L.176,31.862c-.316-.281-.232-.546.191-.585l6.069-.589A1.454,1.454,0,0,0,7.513,29.9l2.434-5.589Z" transform="translate(0.015 -24.025)" fill="currentColor"/>
                                            </svg>  
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="testimonial__chat--icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="52.472" height="45.687" viewBox="0 0 52.472 45.687">
                                <path  data-name="Chat icon" d="M105.2,149.979a16.71,16.71,0,0,0,3.8-15.4,18.87,18.87,0,0,0-8.881-11.694,25.79,25.79,0,0,0-17.343-3.676,23.55,23.55,0,0,0-15.238,7.706,16.673,16.673,0,0,0-4.108,15.7,40.137,40.137,0,0,1,1.547,7.124,15.559,15.559,0,0,1-1.727,8.677c-.228.414-.486.81-.744,1.229.1.036.15.066.192.06a26.1,26.1,0,0,0,11.034-3.862.865.865,0,0,1,.983-.132A26.582,26.582,0,0,0,91,157.853a23.243,23.243,0,0,0,14.194-7.874Zm9.5,13.924a8.286,8.286,0,0,1-.911-1.3,11.272,11.272,0,0,1-.354-9.049,12.317,12.317,0,0,0-.486-9.4c-.4-.846-.935-1.625-1.493-2.591-.108.408-.162.582-.2.762a18.517,18.517,0,0,1-2.968,7.076c-4.234,6.141-10.236,9.427-17.468,10.65-1.283.216-2.591.288-3.916.432a.579.579,0,0,0,.126.168c.33.216.648.438,1,.624a19.172,19.172,0,0,0,17.037.846,1.037,1.037,0,0,1,.8,0,18.573,18.573,0,0,0,6.033,2.291,11.879,11.879,0,0,0,2.519.246C115.079,164.647,115.115,164.419,114.7,163.9Z" transform="translate(-62.5 -118.975)" fill="currentColor" opacity="0.11"/>
                                </svg>
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
</section>
<!-- End testimonial section -->