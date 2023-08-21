@extends('web.layouts.master')

@section('title','Login - IOA')

@section('head')

@endsection

@section('main-content')

<!-- Start login section  -->
<div class="login__section section--padding mb-80">
    <div class="container">
        <form action="#" id="login_form">
            <div class="login__section--inner">
                <div class="">
                    <div class="col">
                        <div class="account__login" style="max-width:500px; margin:auto;">
                            <div class="account__login--header mb-25">
                                <h2 class="account__login--header__title h3 mb-10">Login</h2>
                                <p class="account__login--header__desc">Login if you are a returning customer.</p>
                            </div>
                            <div class="account__login--inner">
                                <label>
                                    <input class="account__login--input" placeholder="Email / Mobile" type="text" name="email_or_mobile">
                                </label>
                                <label>
                                    <input class="account__login--input" placeholder="Password" type="password" name="password">
                                </label>
                                <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                    <div class="account__login--remember position__relative">
                                        <input class="checkout__checkbox--input" id="check1" type="checkbox" name="remember">
                                        <span class="checkout__checkbox--checkmark"></span>
                                        <label class="checkout__checkbox--label login__remember--label" for="check1">
                                            Remember me</label>
                                    </div>
                                    <A href="{{route('password.request')}}" class="account__login--forgot"  type="submit">Forgot Your Password?</a>
                                </div>
                                <button class="account__login--btn btn" type="submit" id="login_btn">
                                    Login
                                    {!! Hpx::spinner() !!}
                                </button>
                                <div class="account__login--divide">
                                    <span class="account__login--divide__text">Or Login Using</span>
                                </div>
                                <div class="account__social d-flex justify-content-center mb-15">
                                    <a class="account__social--link facebook" target="_blank" href="https://www.facebook.com">Facebook</a>
                                    <a class="account__social--link google" target="_blank" href="https://www.google.com">Google</a>
                                    {{-- <a class="account__social--link twitter" target="_blank" href="https://twitter.com">Twitter</a> --}}
                                </div>
                                <p class="account__login--signup__text">Don,t Have an Account? <a href="{{route('register')}}"><button type="button">Register Now</button></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End login section  -->

@endsection


@section('script')
<script>
    $(document).ready(function(){
        $('#login_form').submit(function(e){
            e.preventDefault();
            var x = new Ajx;
            x.form = '#login_form';
            x.actionUrl("{{route('user.login')}}");
            x.ajxLoader('#login_btn .loaderx');
            x.globalAlert(true);
            x.start(function(response) {
                if(response.status == true){
                    location.replace("{{route('home.page')}}");
                }
            });
        });
    });
</script>
@endsection
