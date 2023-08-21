@extends('admin.layouts.admin_layout')
@section('title',env('APP_NAME'))
@section('head')
@endsection

@section('main-content')

<div class="admin-container">
    
    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Videos List';
        $tbx['btn-name'] = 'Add';
        $tbx['btn-link'] = route('webinar.create');
        $tbx['search-bar'] = true;
        $route_name = 'webinar';
        $dir_name = 'webinar';
        $dummy_image = asset('assets/img/other/select-image.jpg');
        $img_dir = 'assets/img/webinar/';
    @endphp
    @include('admin.includes.title-bar')
    
    <div class="cart__table">
        <table class="cart__table--inner">
            {!! Hpx::table_headings(['Video','Type','status','action:text-right']) !!}
            <tbody class="cart__table--body" id="slider-list">
                @foreach($data_list as $data)
                <tr class="cart__table--body__items">
                    <td class="cart__table--body__list">
                        <div class="cart__product d-flex align-items-center">
                            <div class="cart__thumbnail">
                                <img src="{{Hpx::image_src($img_dir.$data->image,$dummy_image)}}?{{rand()}}" class="border-radius-5" alt="image">
                            </div>
                            <div class="cart__content">
                                <span class="cart__content--variant fw-bold">
                                    <h3 class="cart__content--title">
                                        <a href="{{$data->link}}">{{Str::words($data->title,7,'...')}}</a>
                                    </h3>
                                    <span class="text-black fs-5 me-1"> 
                                        {{Hpx::mydate_month($data->created_at,'date-time')}} 
                                    </span>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="cart__table--body__list text-capitalize">
                        {{$data->type}}
                    </td>
                    <td class="cart__table--body__list text-capitalize">
                        {{$data->status}}
                    </td>
                    <td class="cart__table--body__list text-right">
                        {!! Hpx::edit_btn(route($route_name.'.edit',$data->id)) !!}
                        {!! Hpx::delete_btn($data->id) !!}
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

</script>
@endsection

