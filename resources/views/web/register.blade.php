@extends('web.layouts.master')

@section('title','Register')

@section('head')

@endsection

@section('main-content')

<div class="login__section section--padding mb-80">
    <div class="container">
        <form action="" id="register_form">
            <div class="login__section--inner">
                <div class="">
                    <div class="col">
                        <div class="account__login register" style="max-width:500px; margin:auto;">
                            <div class="account__login--header mb-25">
                                <h2 class="account__login--header__title h3 mb-10">Create an Account</h2>
                                <p class="account__login--header__desc">Register here if you are a new customer</p>
                            </div>
                            <div class="account__login--inner">
                                <label>
                                    <input class="account__login--input" placeholder="Name" type="text" name="name">
                                </label>
                                <label>
                                    <input class="account__login--input" placeholder="Email Addres" type="email" name="email">
                                </label>
                                <label>
                                    <input class="account__login--input" placeholder="Mobile No." type="number" name="mobile">
                                </label>
                                <label>
                                    <input class="account__login--input" placeholder="Password" type="password" name="password">
                                </label>
                                <label>
                                    <input class="account__login--input" placeholder="Confirm Password" type="password" name="password_confirmation">
                                </label>
                                <button class="account__login--btn btn mb-10" type="button" id="register_btn">
                                    Register
                                    {!! Hpx::spinner() !!}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section('script')
<script>
    $(document).ready(function(){
        $('#register_btn').click(function(){
            var x = new Ajx;
            x.form = '#register_form';
            x.actionUrl("{{route('user.register')}}");
            x.ajxLoader('#register_btn .loaderx');
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

