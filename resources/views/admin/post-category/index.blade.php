@extends('admin.layouts.admin_layout')

@section('title','IOA')


@section('head')

@endsection


@section('main-content')


<div class="admin-container">
	
    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Post Categories';
        $tbx['btn-name'] = 'Add';
        $tbx['btn-link'] = route('post-category.create');
        $tbx['search-bar'] = true;
    @endphp
    @include('admin.includes.title-bar')

	<div class="cart__table">
        <table class="cart__table--inner">
            
            <tbody class="cart__table--body" id="slider-list">
                @foreach($categories as $category)
                <tr class="cart__table--body__items">                    
                    <td class="cart__table--body__list">
                        <div class="cart__product d-flex align-items-center">
                            <div class="cart__thumbnail">
                                <a href="#">
                                    @if(file_exists('assets/img/post-category/'.$category->image) and !empty($category->image))
                                        <img src="{{ asset('assets/img/post-category/'.$category->image) }}?{{rand()}}" class="border-radius-5" alt="Category">
                                    @else
                                        <img src="{{ asset('assets/img/other/category.jpg') }}" class="border-radius-5" alt="Category">
                                    @endif
                                </a>
                            </div>
                            <div class="cart__content">
                                <h3 class="cart__content--title h4"><a href="#">{{$category->name}}</a></h3>
                                <span class="cart__content--variant">{{$category->slug}}</span>
                                <span class="cart__content--variant fw-bold text-truncate">{{Str::words($category->description,5)}}</span>
                            </div>
                        </div>
                    </td>                  
                    <td class="cart__table--body__list">
                        <span class="cart__price">
                        	<span class="cart__price">
                            	<label class="switchz">
								  <input type="checkbox" onclick="change_status(this,{{$category->id}})" {{ $category->status == 1 ? 'checked' : null}}>
								  <span class="sliderz round"></span>
								</label>
                        	</span>
                    	</span>
                    </td>               
                    <td class="cart__table--body__list text-right">
                        <div class="btn-groupx" role="group" aria-label="Action">
					       <a class="btn btn-sm fs-4 btn-outline-secondary" href="{{route('post-category.edit',$category->id)}}">Edit</a>
					      <a class="btn btn-sm btn-outline-danger fs-4" onclick="delete_data({{$category->id}})">Delete</a>
					    </div>
                    </td>
                </tr>
                @endforeach             
            </tbody>
        </table>                            
    </div> 
</div>


@endsection


@section('script')
<script type="text/javascript">
function change_status(selector,id){
    var status = $(selector).prop('checked') == true ? 1 : 0;
    var x = new Ajx;
    x.actionUrl('{{route("post-category.store")}}');
    x.passData('id',id);
    x.passData('action','UPDATE_CATEGORY_STATUS');
    x.passData('status',status);
    x.globalAlert(true);
    x.start();
}

function delete_data(id){
    if (confirm("Are you sure want to delete..!") == true) {
        var x = new Ajx;
        x.actionUrl('{{route("post-category.store")}}');
        x.passData('id',id);
        x.passData('action','DELETE_CATEGORY');
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

