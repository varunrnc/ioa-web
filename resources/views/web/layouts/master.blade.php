<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>@yield('title') - Inovative Organic Agri</title>
  <meta name="description" content="Morden Bootstrap HTML5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{csrf_token()}}">

  <!-- ============== favicons =========== -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/img/favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/img/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/favicon/favicon-16x16.png')}}">

   <!-- ========= IconFont CSS ===========-->
  <link rel="stylesheet" href="{{asset('assets/web/css/icofont.min.css')}}">

   <!-- ======= All CSS Plugins here ======== -->
  <link rel="stylesheet" href="{{asset('assets/web/css/plugins/swiper-bundle.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/web/css/plugins/glightbox.min.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&amp;family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

  <!-- =========== Plugin css =============== -->
  <link rel="stylesheet" href="{{asset('assets/web/css/vendor/bootstrap.min.css')}}">

  <!-- =========== Custom Style CSS ========= -->
  <link rel="stylesheet" href="{{asset('assets/web/css/web_style.css')}}">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <style type="text/css">
    .swiper__nav--btn::after {
        background: url('{{asset("assets/web/icon/left-arrow-angle.png")}}');
    }
    .swiper__nav--btn.swiper-button-next::after {
        background: url('{{asset("assets/web/icon/right-arrow-angle.png")}}');
    }
  </style>
  @yield('style')
</head>

<body>
    @include('web.layouts.header')

    <!-- ====== Main Content Start ===== -->
       <main class="main__content_wrapper">
             @yield('main-content')
        </main>
    <!-- ====== Main Content End ===== -->

    @include('web.layouts.footer')


   <input type="hidden" id="is_login" value="{{ auth()->check() ? 1 : 0 }}">
   <!-- All Script JS Plugins here  -->
   <script src="{{asset('assets/web/js/vendor/popper.js')}}" defer="defer"></script>
   <script src="{{asset('assets/web/js/vendor/bootstrap.min.js')}}" defer="defer"></script>
   <script src="{{asset('assets/web/js/plugins/swiper-bundle.min.js')}}"></script>
   <script src="{{asset('assets/web/js/plugins/glightbox.min.js')}}"></script>

  <!-- Customscript js -->
  <script src="{{asset('assets/web/js/script.js')}}"></script>
  <script src="{{asset('assets/web/js/classes.js')}}"></script>
<!--   <script src="{{asset('assets/web/js/main.js')}}"></script> -->


<script type="text/javascript">

    // Add to cart
    $(document).on('click','.add__to--cart__btn',function(){
        if($('#is_login').val()==1){
            var btn = $(this);
            id = btn.attr('data-id');
            btn.html(`{!!Hpx::spinner('block')!!}`);
            var x = new Ajx;
            x.actionUrl("{{route('order.post')}}");
            x.globalAlert(true);
            x.passData('action','ADD_TO_CART')
            x.passData('id',id);
            x.start(function(response) {
                var msg = response.message;
                if(response.status == true){
                    btn.addClass('added');
                    btn.html('✓ Added');
                }else{
                    if(msg.search('added') > -1){
                        btn.addClass('added');
                        btn.html('✓ Added');
                    }else{
                        btn.html('+ Add to cart');
                    }
                }
                getCartCount();
            });
        }else{
            location.href = "{{route('login')}}";
        }
    });


    $(document).ready(function(){
        getCartCount();
    });

    // Get Cart Count
    function getCartCount(){
        if($('#is_login').val()==1){
            var x = new Ajx;
            x.actionUrl("{{route('order.get')}}");
            x.globalAlert(false);
            x.errorMsg(false);
            x.passData('action','CART_COUNT')
            x.start(function(response) {
                if(response.status == true){
                    $('.minicart__icon--btn .items__count').remove();
                    $('.minicart__icon--btn').append('<span class="items__count">'+response.data+'</span>');
                }
            });
        }
    }
</script>

@yield('script')

</body>
</html>
