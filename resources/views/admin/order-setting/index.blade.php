@extends('admin.layouts.admin_layout')
@section('title',env('APP_NAME'))
@section('head')
@endsection

@section('main-content')

<div class="admin-container">
    
    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Order Settings';
        
        $route_name = 'order_setting';
        $dir_name = 'order-setting';
        $dummy_image = asset('assets/img/other/select-image.jpg');
        $img_dir = 'assets/img/'.$dir_name.'/';
        $refresh = Hpx::refresh_id();
    @endphp
    @include('admin.includes.title-bar')

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <form class="row" action="{{route($route_name.'.store')}}" id="shipping_form">
                   <input type="hidden" name="action" value="SHIPPING_CHARGE">
                    <label for="" class="form-label">Shipping Charge</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="{{$shipping->value ?? '0.00'}}" name="shipping_charge">
                        <button type="button" id="shipping_btn" class="btn btn-primary fs-4 ups-btn">
                            Update
                            {!! Hpx::spinner() !!}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function(){
    $('.ups-btn').click(function(){
        var form_id = '#'+$(this).closest('form').attr('id');
        var btn_id = '#'+$(this).attr('id');
        var loader_id = btn_id+' .loaderx';
        update_setting(form_id,btn_id,loader_id);   
    });
});

function update_setting(form_id,btn_id,loader_id){
    var x = new Ajx;
    x.form = form_id
    x.disableBtn(btn_id);
    x.ajxLoader(loader_id);
    x.globalAlert(true);
    x.start(function(response){
        if(response.status == true){
            location.reload();
        }
    });
}

</script>
@endsection

