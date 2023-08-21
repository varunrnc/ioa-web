@extends('admin.layouts.admin_layout')

@section('title','IOA')


@section('head')

@endsection


@section('main-content')


<div class="admin-container">
	
    @php
        $tbx['tb'] = 1;
        $tbx['title'] = 'Testimonials';
        $tbx['btn-name'] = 'Add';
        $tbx['btn-link'] = route('testimonial.create');
        $tbx['search-bar'] = true;
    @endphp
    @include('admin.includes.title-bar')

	<div class="cart__table">
        <table class="cart__table--inner">
            <thead class="cart__table--header">
                <tr class="cart__table--header__items">
                    <th class="cart__table--header__list">Name</th>
                    <th class="cart__table--header__list">Status</th>
                    <th class="cart__table--header__list text-right">Action</th>
                </tr>
            </thead>
            <tbody class="cart__table--body" id="slider-list">
                @foreach($testimonials as $testimonial)
                <tr class="cart__table--body__items">                    
                    <td class="cart__table--body__list">
                        <div class="cart__product d-flex align-items-center">
                            <div class="cart__thumbnail">
                                <a href="#">
                                    @if(file_exists('assets/img/testimonial/'.$testimonial->image) and !empty($testimonial->image))
                                        <img src="{{ asset('assets/img/testimonial/'.$testimonial->image) }}?{{rand()}}" class="border-radius-5" alt="Testimonial">
                                    @else
                                        <img src="{{ asset('assets/img/other/testimonial.jpg') }}" class="border-radius-5" alt="Testimonial">
                                    @endif
                                </a>
                            </div>
                            <div class="cart__content">
                                <h3 class="cart__content--title h4"><a href="#">{{$testimonial->name}}</a></h3>
                                <span class="cart__content--variant">{{$testimonial->place}}</span>
                                <span class="cart__content--variant fw-bold">{{Str::words($testimonial->message,5)}}</span>
                            </div>
                        </div>
                    </td>                  
                    <td class="cart__table--body__list">
                        <span class="cart__price">
                        	<span class="cart__price">
                            	<label class="switchz">
								  <input type="checkbox" onclick="change_status(this,{{$testimonial->id}})" {{ $testimonial->status == 1 ? 'checked' : null}}>
								  <span class="sliderz round"></span>
								</label>
                        	</span>
                    	</span>
                    </td>               
                    <td class="cart__table--body__list text-right">
                        <div class="btn-groupx" role="group" aria-label="Action">
					       <a class="btn btn-sm fs-4 btn-outline-secondary" href="{{route('testimonial.edit',$testimonial->id)}}">Edit</a>
					      <a class="btn btn-sm btn-outline-danger fs-4" onclick="delete_data({{$testimonial->id}})">Delete</a>
					    </div>
                    </td>
                </tr>
                @endforeach             
            </tbody>
        </table>                            
    </div> 
</div>


<div id="confirm" class="modal">
  <div class="modal-body">
    Are you sure?
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
  </div>
</div>


@endsection


@section('script')
<script type="text/javascript">
function change_status(selector,id){
    var status = $(selector).prop('checked') == true ? 1 : 0;
    var x = new Ajx;
    x.actionUrl('{{route("testimonial.store")}}');
    x.passData('id',id);
    x.passData('action','UPDATE_TESTIMONIAL_STATUS');
    x.passData('status',status);
    x.globalAlert(true);
    x.start();
}

function delete_data(id){
    if (confirm("Are you sure want to delete..!") == true) {
        var x = new Ajx;
        x.actionUrl('{{route("testimonial.store")}}');
        x.passData('id',id);
        x.passData('action','DELETE_TESTIMONIAL');
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

