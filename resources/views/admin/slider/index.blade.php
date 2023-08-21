@extends('admin.layouts.admin_layout')

@section('title',env('APP_NAME'))

@section('head')

@endsection


@section('main-content')


<div class="admin-container">
    
    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Slider List';
        $tbx['btn-name'] = 'Add';
        $tbx['btn-link'] = route('slider.create');
        $tbx['search-bar'] = true;

        $route_name = 'slider';
        $dir_name = 'slider';
        $dummy_image = asset('assets/img/other/select-image.jpg');
    @endphp
    @include('admin.includes.title-bar')
    
    <div class="cart__table">
        <table class="cart__table--inner">
            <thead class="cart__table--header">
                <tr class="cart__table--header__items">
                    <th class="cart__table--header__list">Slider</th>
                    <th class="cart__table--header__list">Status</th>
                    <th class="cart__table--header__list text-center">Reorder</th>
                    <th class="cart__table--header__list text-right">Action</th>
                </tr>
            </thead>
            <tbody class="cart__table--body" id="slider-list">
                @foreach($data_list as $data)
                <tr class="cart__table--body__items">                    
                    <td class="cart__table--body__list">
                        <div class="cart__product d-flex align-items-center">
                            <div class="cart__thumbnail">
                                <a href="#"><img class="border-radius-5" src="{{Hpx::image_src('assets/img/slider/thumbnail/'.$data->image,$dummy_image)}}" alt="thumbnail"></a>
                            </div>
                            <div class="cart__content">
                                <h3 class="cart__content--title h4">
                                    <a href="#">{{Str::words($data->slider_name,7,'...')}}</a>
                                </h3>
                                <span class="cart__content--variant">{{Str::words($data->title,7,'...')}}</span>
                            </div>
                        </div>
                    </td>
                    <td class="cart__table--body__list">
                        <span class="cart__price">
                            <span class="cart__price">
                                <label class="switchz">
                                  <input type="checkbox" onclick="change_status(this,{{$data->id}})" {{ $data->status == 1 ? 'checked' : null}}>
                                  <span class="sliderz round"></span>
                                </label>
                            </span>
                        </span>
                    </td> 
                    <td class="cart__table--body__list text-center">
                        <span>
                            <div class="input-group mb-3" style="width:70px">
                              <input type="text" class="form-control fs-4 re_ord{{$data->id}}" value="{{$data->order_no}}" aria-label="Order_no" aria-describedby="basic-addon1">
                              <span class="input-group-text set-ord" onclick="reorder_slider('.re_ord{{$data->id}}',{{$data->id}})" id="basic-addon1"><i class="icofont-rounded-right fs-5"></i></span>
                            </div>
                        </span>
                    </td>
                                     
                    <td class="cart__table--body__list text-right">
                        <div class="btn-groupx" role="group" aria-label="Action">
                           <a class="btn btn-sm fs-4 btn-outline-secondary" href="{{route($route_name.'.edit',$data->id)}}">Edit</a>
                          <a class="btn btn-sm btn-outline-danger fs-4" onclick="delete_id({{$data->id}})">Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach             
            </tbody>
        </table>
        <div class="col-12 links-border"> 
            {{$data_list->OnEachSide(5)->links()}}
        </div>                            
    </div> 
</div>

@endsection


@section('script')
<script type="text/javascript">

function change_status(selector,id){
    var status = $(selector).prop('checked') == true ? 1 : 0;
    var x = new Ajx;
    x.actionUrl('{{route($route_name.".store")}}');
    x.passData('id',id);
    x.passData('action','UPDATE_STATUS');
    x.passData('status',status);
    x.globalAlert(true);
    x.start();
}

function delete_id(id){
    if (confirm("Are you sure want to delete..!") == true) {
        var x = new Ajx;
        x.actionUrl('{{route($route_name.".store")}}');
        x.passData('id',id);
        x.passData('action','DELETE');
        x.globalAlert(true);
        x.start(function(response){
            if(response.status == true){
                location.reload();
            }
        });
    }
}

function reorder_slider(selector,id){
    var order_no = $(selector).val();
    var x = new Ajx;
    x.actionUrl('{{route($route_name.".store")}}');
    x.passData('id',id);
    x.passData('action','REORDER_SLIDER');
    x.passData('order_no',order_no);
    x.globalAlert(true);
    x.start(function(response){
        if(response.status == true){
            location.reload();
        }
    });
}

</script>
@endsection

