<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title') - Inovative Organic Agri</title>
    <meta name="description" content="Morden Bootstrap HTML5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ============== favicons =========== -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">

    <!-- ======= All CSS Plugins here ======== -->
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/plugins/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/plugins/glightbox.min.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&amp;family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <!-- =========== Plugin CSS =============== -->
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/vendor/bootstrap.min.css') }}">

    <!-- ========= IconFont CSS ===========-->
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/icofont.min.css') }}">

    <!-- =========== Custom Style CSS ========= -->
    <link rel="stylesheet" href="{{ asset('/assets/admin/css/style.css') }}">

    @yield('style')

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="{{ asset('/assets/admin/js/jquery-3.6.0.min.js') }}"></script>

    <!-- Html Editor -->
    <script src="https://unpkg.com/react@17.0.2/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@17.0.2/umd/react-dom.production.min.js"></script>
    <link rel="stylesheet" href="{{ asset('public/vendor/laraberg/css/laraberg.css') }}">
    <script src="{{ asset('public/vendor/laraberg/js/laraberg.js') }}"></script>
    <!-- End Html Editor -->

    <script type="text/javascript">
        $(document).ready(function() {
            if ($(window).width() > 570) {
                $('.header__section').css('margin-bottom', $('.header__sticky').height() + 40 + 'px');
            } else {
                $('.header__section').css('margin-bottom', $('.header__sticky').height() + 20 + 'px');
            }

            if ($(window).width() > 570) {
                $('.shop__sidebar--widget').css('top', $('.header__sticky').height() + 40 + 'px');
            }

            $('a[href="http://' + location.host + location.pathname + '"]')
                .closest('.drop_menu')
                .find('label.widget__categories--menu__label').click();

        });
    </script>
</head>

<body class="admin-bg">

    <audio id="myAudio">
        <source src="{{ asset('assets/chat/notification.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Start offcanvas filter sidebar -->
    <div class="offcanvas__filter--sidebar widget__area">
        <button type="button" class="offcanvas__filter--close" data-offcanvas>
            <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="32" d="M368 368L144 144M368 144L144 368"></path>
            </svg> <span class="offcanvas__filter--close__text">Close</span>
        </button>
        <div class="offcanvas__filter--sidebar__inner">
            <div class="single__widget widget__bg">
                <h2 class="widget__title h3">Admin Controllers</h2>
                @include('admin.layouts.admin_menu')
            </div>
        </div>
    </div>
    <!-- End offcanvas filter sidebar -->


    <!-- Start header area -->
    <header class="header__section border-bottom">

        <div class="main__header header__sticky sticky"
            style="background-color:white; box-shadow: 0 0 7px rgb(0 0 0 / 15%);">
            <div class="container-fluid">
                <div class="main__header--inner position__relative d-flex justify-content-between align-items-center">

                    <button class="widget__filter--btn d-flex d-lg-none align-items-center border-0" data-offcanvas="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg"
                            viewBox="0 0 512 512">
                            <path fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352" />
                        </svg>
                    </button>

                    <div class="main__logo">
                        <h1 class="main__logo--title"><a class="main__logo--link" href="{{ route('home.page') }}">
                                <img class="main__logo--img" src="{{ asset('assets/img/logo/logo.png') }}"
                                    style="max-height: 55px;" alt="logo-img"></a>
                        </h1>
                    </div>
                    <div class="header__account header__sticky">
                        <ul class="d-flex">

                            <li class="header__account--items">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <i class="icofont-logout"></i>
                                        {{ __('Logout') }}
                                    </x-dropdown-link>
                                </form>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>


        <!-- Start serch box area -->
        <div class="predictive__search--box ">
            <div class="predictive__search--box__inner">
                <form class="predictive__search--form" action="{{ url()->current() }}">
                    <label>
                        <input class="predictive__search--input" name="q" placeholder="Search Here"
                            type="text">
                    </label>
                    <button type="submit" class="predictive__search--button" aria-label="search button"><svg
                            class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="30.51"
                            height="25.443" viewBox="0 0 512 512">
                            <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32" />
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                stroke-width="32" d="M338.29 338.29L448 448" />
                        </svg> </button>
                </form>
            </div>
        </div>
        <!-- End serch box area -->

    </header>
    <!-- End header area -->


    <!-- ====== Main Content Start ===== -->
    <main class="main__content_wrapper">
        <section class="shop__section mt-sm-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="shop__sidebar--widget widget__area d-none d-lg-block">
                            <div class="single__widget widget__bg bg-white">
                                <h2 class="widget__title h3">Admin Control</h2>
                                @include('admin.layouts.admin_menu')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 pp-sm mm-top">
                        @yield('main-content')
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- ====== Main Content End ===== -->

    <!-- Start footer section -->
    <footer class="footer__section footer__bg" style="margin-top: 200px;">
        <img class="footer__position--shape__one" src="{{ asset('assets/img/other/footer-shape1.png') }}"
            alt="footer-shape" style="z-index:-1; position: fixed; top: 50%;">
        <img class="footer__position--shape__two" src="{{ asset('assets/img/other/footer-shape2.png') }}"
            alt="footer-shape" style="z-index:-1; position: fixed; top: 50%;">
        <div class="container">

            <div class="py-4">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="copyright__content">Copyright © 2022 <a
                                class="copyright__content--link text__primary" href="index.html">IOA</a> . All Rights
                            Reserved.</p>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- End footer section -->



    <!-- Scroll top bar -->
    <button id="scroll__top"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="48" d="M112 244l144-144 144 144M256 120v292" />
        </svg></button>

    <!-- All Script JS Plugins here  -->
    <script src="{{ asset('/assets/admin/js/vendor/popper.js') }}" defer="defer"></script>
    <script src="{{ asset('/assets/admin/js/vendor/bootstrap.min.js') }}" defer="defer"></script>
    <script src="{{ asset('/assets/admin/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/plugins/glightbox.min.js') }}"></script>
    <!-- kk js -->
    <script src="{{ asset('/assets/admin/js/script.js') }}"></script>
    <!-- Customscript js -->
    <script src="{{ asset('/assets/js/service.js') }}"></script>

    <!-- ======== My JS Classes ========== -->
    <script src="{{ asset('/assets/admin/js/classes.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/main.js') }}"></script>

    <script>
        var Notify = document.getElementById("myAudio");

        function playAudio() {
            Notify.play();
        }

        function pauseAudio() {
            Notify.pause();
        }

        $(document).ready(function() {
            var x = new Ajx;
            x.actionUrl("{{ route('admin.totalMsgCount') }}");
            x.globalAlert(false);
            x.start(function(response) {
                if (response.status == true) {
                    if (response.data > 0) {
                        $('.msg_menu_count').show();
                        $('.msg_menu_count').html(response.data);
                        // $(document).click();
                        // playAudio();
                    }
                }
            });
        });
    </script>

    @yield('script')

</body>

</html>
