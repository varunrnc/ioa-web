@extends('web.layouts.master')

@section('title','IOA')

@section('style')
<style type="text/css">
	.increase:active {
		background-color: #e2e2e2 !important;
	}
	.decrease:active {
		background-color: #e2e2e2 !important;
	}
</style>
@endsection

@section('main-content')

<section class="cart__section py-5 my-5">
	<div class="container-fluid">
		<div class="cart__section--inner">
			<form action="#">
				<h2 class="cart__title mb-40">Shopping Cart</h2>
				<div id="cart-loader" style="display: none; width: 100%;position: fixed;background-color: #00000040;top: 0;bottom: 0;left: 0;right: 0;z-index: 2;color: white;">
					<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
						<span class="spinner-border spinner-s2 loaderx" style="display:block;" role="status" aria-hidden="true"></span>
					</div>
				</div>
				<div id="cart-empty" style="display:none; width:100%">
					<div class="d-flex justify-content-center align-items-center" style="height: 200px; flex-direction:column;">
						<h6>Cart is empty!</h6>
						<a class="btn btn-primary mt-3" href="{{route('shop.page')}}">Shop Now</a>
					</div>
				</div>
				<div class="row" id="cart-details" style="display:none;">
					<div class="col-lg-8">
						<div class="cart__table">
							<table class="cart__table--inner">
								<thead class="cart__table--header">
									<tr class="cart__table--header__items">
										<th class="cart__table--header__list">Product</th>
										<th class="cart__table--header__list">Price</th>
										<th class="cart__table--header__list">Quantity</th>
										<th class="cart__table--header__list">Total</th>
									</tr>
								</thead>
								<tbody class="cart__table--body cart-tbody">

								</tbody>
							</table>
							<div class="continue__shopping d-flex justify-content-end">
								<a class="continue__shopping--link" href="{{route('shop.page')}}">Continue shopping</a>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="cart__summary border-radius-10">
							<div class="coupon__code mb-30">
								<h3 class="coupon__code--title">Coupon</h3>
								<p class="coupon__code--desc">Enter your coupon code if you have one.</p>
								<div class="coupon__code--field d-flex">
									<label>
										<input class="coupon__code--field__input text-uppercase border-radius-5" placeholder="Coupon code" type="text">
									</label>
									<button class="coupon__code--field__btn btn" type="button">Apply Coupon</button>
								</div>
							</div>
							<div class="cart__note mb-10">
								<button type="button" class="btnx-primary float-end minicart__open--btn" id="change-addrs-btn" data-offcanvas>Change</button>
								<h3 class="cart__note--title">Delivery Address</h3>
							</div>
							<div id="address_box" class="w-100 mt-3">
							</div>
							<div id="add_address_box" class="w-100 mt-3">
								<div class="address_txt py-3 px-3 rounded text-center">
									<h6 class="fs-5">Address List is empty.</h6>
									<button type="button" class="btnx-primary mt-2" id="add-adrs-btn">Add New</button>
								</div>
							</div>
							<div class="cart__summary--total mb-20 mt-3">
								<table class="cart__summary--total__table">
									<tbody>
										<tr class="cart__summary--total__list">
											<td class="cart__summary--total__title text-left">SUBTOTAL</td>
											<td class="cart__summary--amount text-right">₹<span id="sub_total"></span></td>
										</tr>
										<tr class="cart__summary--total__list">
											<td class="cart__summary--total__title text-left">
												SHIPPING CHARGE
												(<small id="shipping_charge">30</small><small>/kg</small>)
											</td>
											<td class="cart__summary--amount text-right">₹<span id="shipping_amount"></span></td>
										</tr>
										<tr class="cart__summary--total__list">
											<td class="cart__summary--total__title text-left">COUPON DISCOUNT</td>
											<td class="cart__summary--amount text-right">₹<span id="coupon_discount"></span></td>
										</tr>
										<tr class="cart__summary--total__list">
											<td class="cart__summary--total__title text-left">GRAND TOTAL</td>
											<td class="cart__summary--amount text-right">₹<span id="total_amount"></span></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="cart__summary--footer">
								<hr class="border-1">
								<ul class="d-flex justify-content-end">
									<li><a class="cart__summary--footer__btn btn checkout" href="javascript:void(0)" onclick="checkout()">Check Out</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

@include('web.includes.cart.address_list')
@include('web.includes.address_modal.delivery_address')

@endsection

@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
	function getCartDetails() {
		var cart_empty = $('#cart-empty');
		var cart_details = $('#cart-details');
		// Get Cart List
		if ($('#is_login').val() == 1) {
			cart_empty.hide();
			var x = new Ajx;
			x.actionUrl("{{route('order.get')}}");
			x.ajxLoader('#cart-loader');
			x.globalAlert(false);
			x.errorMsg(false);
			x.passData('action', 'CART_LIST');
			x.start(function(response) {
				if (response.status == true && response.other_data.cart_count > 0) {
					var cart_list = response.data;
					var other_data = response.other_data;
					var html_list = '';
					var coupon_code = '';
					var coupon_discount_price = '';
					cart_list.forEach(function(data, index) {
						coupon_code = data.coupon_code;
						coupon_discount_price = data.coupon_discount_price;
						var url = "{{asset('assets/img/product')}}";
						var thumbnail = url + '/' + data.image1;
						html_list += `
            		<tr class="cart__table--body__items">
                        <td class="cart__table--body__list">
                            <div class="cart__product d-flex align-items-center">
                                <button class="cart__remove--btn" data-id="` + data.id + `" aria-label="search button" type="button">
                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"></path></svg>
                                </button>
                                <div class="cart__thumbnail">
                                    <a href="product-details.html">
                                    <img class="border-radius-5" src="` + thumbnail + `" alt="cart-product"></a>
                                </div>
                                <div class="cart__content">
                                    <h3 class="cart__content--title h6">
                                    <a href="product-details.html">` + data.product_name + `</a>
                                    </h3>
                                    <span class="cart__content--variant">
                                    	WEIGHT: ` + (data.weight * 1) + ` Kg
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="cart__table--body__list">
                            <span class="cart__price">₹` + (data.selling_price * 1) + `</span>
                        </td>
                        <td class="cart__table--body__list">
                            <div class="quantity__box cart-qnty-box" data-id="` + data.id + `">
                                <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="decrease">-</button>
                                <label>
                                    <input type="number" class="quantity__number quickview__value--number" value="` + data.quantity + `" data-counter="" readonly>
                                </label>
                                <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="increase">+</button>
                            </div>
                        </td>
                        <td class="cart__table--body__list">
                            <span class="cart__price end">₹` + (data.selling_price * data.quantity) + `</span>
                        </td>
                    </tr>`;
					});
					$('#cart-details .cart-tbody').html(html_list);
					cart_details.show();
					$('.coupon__code--field__input').val(coupon_code);
					$('#sub_total').html(other_data.sub_total);
					$('#shipping_charge').html(other_data.shipping_charge);
					$('#shipping_amount').html(other_data.shipping_amount);
					$('#coupon_discount').html(other_data.coupon_discount);
					$('#coupon_discount').closest('tr').hide();
					if (other_data.coupon_discount > 0) {
						$('#coupon_discount').closest('tr').show();
					}
					$('#total_amount').html(other_data.total_amount);

					var address_box = $('#address_box');
					var add_address_box = $('#add_address_box');
					var address = other_data.address;
					var address_html = '';
					if(address == null || address == ''){
						address_box.hide();
						add_address_box.show();
					}else{
						add_address_box.hide();
						address_html = `
							<div class="address_txt py-2 px-3 rounded mt-3" data-id="`+address.id+`">
                                <h5>`+ address.name + `</h5>
                                <p class="fs-5 mb-1 text-capitalize">` + address.address_line_1 + `, ` + address.address_line_2 + `, ` + address.city + `, ` + address.state + ` - ` + address.pincode + `</p>
                                ` + (address.address_notes != null ? '<p class="my-1 text-capitalize fs-5">(' + address.address_notes + ')</p>' : null) + `
                                <p>` + address.mobile + `</p>
                            </div>
						`;
						address_box.html(address_html);
                        address_box.show();
					}

				} else {
					cart_empty.show();
				}
			});
		} else {
			cart_empty.show();
		}
	}

	$(document).ready(function() {

		getCartDetails();

		// Remove form Cart List
		$(document).on('click', '.cart-tbody .cart__remove--btn', function() {
			if ($('#is_login').val() == 1) {
				var cart_details = $('#cart-details');
				//cart_details.hide();
				var x = new Ajx;
				x.actionUrl("{{route('order.post')}}");
				x.passData('id', $(this).attr('data-id'));
				x.ajxLoader('#cart-loader');
				x.globalAlert(true);
				x.errorMsg(false);
				x.passData('action', 'REMOVE_FROM_CART');
				x.start(function(response) {
					getCartDetails();
				});
			} else {
				location.href = "{{route('login')}}";
			}
		});


		// Update Product Quantity
		$(document).on('click', '.cart-qnty-box .increase,.cart-qnty-box .decrease', function() {
			var id = $(this).closest('.cart-qnty-box').attr('data-id');
			var qty = $(this).closest('.cart-qnty-box').find('.quantity__number').val();
			var quantity = $(this).val() == 'increase' ? (parseInt(qty) + 1) : (parseInt(qty) - 1);
			if ($('#is_login').val() == 1) {
				var cart_details = $('#cart-details');
				// cart_details.hide();
				var x = new Ajx;
				x.actionUrl("{{route('order.post')}}");
				x.passData('id', id);
				x.passData('quantity', quantity);
				x.ajxLoader('#cart-loader');
				x.globalAlert(true);
				x.errorMsg(false);
				x.passData('action', 'UPDATE_QUANTITY');
				x.start(function(response) {
					getCartDetails();
				});
			} else {
				location.href = "{{route('login')}}";
			}
		});


		// Update Coupon code
		$(document).on('click', '.coupon__code--field__btn', function() {
			var coupon_code = $('.coupon__code--field__input').val();
			if ($('#is_login').val() == 1) {
				var cart_details = $('#cart-details');
				// cart_details.hide();
				var x = new Ajx;
				x.actionUrl("{{route('order.post')}}");
				x.passData('action', 'UPDATE_COUPON_CODE');
				x.passData('coupon_code', coupon_code);
				x.ajxLoader('#cart-loader');
				x.globalAlert(true);
				x.errorMsg(false);
				x.start(function(response) {
					getCartDetails();
				});
			} else {
				location.href = "{{route('login')}}";
			}
		});

		// Get Address List
		$(document).on('click', '#change-addrs-btn', function() {
			var AddressBox = $('.addrs_list');
			AddressBox.hide();
			var x = new Ajx;
			x.actionUrl("{{route('address.get')}}");
			x.ajxLoader('#address-loader');
			x.globalAlert(false);
			x.errorMsg(false);
			x.passData('action', 'GET');
			x.start(function(response) {
				if (response.status == true) {
					var data_list = response.data;
					var address_list = '';
					data_list.forEach(function(data, index) {
						address_list += `
                        <label class="form-check-label user_addrx" for="flexRadioDefault` + data.id + `" data-id="`+data.id+`">
                            <div class="address_txt py-2 px-3 rounded mt-3 ps-5">
                                <h5><input class="form-check-input me-2" type="radio" name="flexRadioDefault" id="flexRadioDefault` + data.id + `" style="margin-left:-20px;">` + data.name + `</h5>
                                <p class="fs-5 mb-1 text-capitalize">` + data.address_line_1 + `, ` + data.address_line_2 + `, ` + data.city + `, ` + data.state + `, ` + ` - ` + data.pincode + `</p>
                                ` + (data.address_notes != null ? '<p class="my-1 text-capitalize fs-5">(' + data.address_notes + ')</p>' : null) + `
                                <p>` + data.mobile + `</p>
                            </div>
                        </label>
						<div class="address_action_box">
							<span class="addrs_edit_btn" onclick="editDeliveryAddress(`+data.id+`)">Edit</span> | <span class="addrs_remove_btn" onclick="removeDeliveryAddress(`+data.id+`)">Remove</span>
						</div>
                    `;
					});
					AddressBox.html(address_list);
					AddressBox.show();
				} else {
					alert(response.message);
				}
			});
		});

		$(document).on('click', '.user_addrx', function() {
			$('body').removeClass('offCanvas__minicart_active');
			$('.offCanvas__minicart').removeClass('active');
			var address_id = $(this).attr('data-id');
			updateAddressId(address_id);
		});

		// Add new address
		$(document).on('click', '#add_new_address_btn,#add-adrs-btn', function() {
			$('#delivery_address_modal .contact__form--title').html('Add Delivery Address');
			$('#delivery_address_modal').addClass('is-visible');
			$('#delivery_address_modal [name="id"]').val('');
			document.getElementById('delivery_address_form').reset();
			$('.minicart__close--btn').click();
		});



	});

	function updateAddressId(address_id) {
		var x = new Ajx;
		x.actionUrl("{{route('order.post')}}");
		x.ajxLoader('#cart-loader');
		x.globalAlert(false);
		x.errorMsg(false);
		x.passData('action', 'UPDATE_ADDRESS_ID');
		x.passData('address_id',address_id);
		x.start(function(response) {
			if (response.status == true) {
				getCartDetails();
			} else {
				alert('Failed to update delivery address..! please try again');
			}
		});
	}

	function saveDeliveryAddress(){
		var x = new Ajx;
		x.form = '#delivery_address_form';
		x.actionUrl('{{route("address.post")}}');
		x.ajxLoader('#delivery_address_form .loaderx');
		var address_id = $('#delivery_address_form [name="id"]').val();
		if(address_id != null && address_id > 0){
			x.passData('action', 'UPDATE');
		}else{
			x.passData('action', 'CREATE');
		}
		x.globalAlert(true);
		x.start(function(response) {
			if (response.status == true) {
				getCartDetails();
				$('.close-modal').click();
			}
		});
	}

	function editDeliveryAddress(update_id){
		$('#delivery_address_modal .contact__form--title').html('Edit Delivery Address');
		$('#delivery_address_modal').addClass('is-visible');
		$('.minicart__close--btn').click();
		var x = new Ajx;
		x.actionUrl('{{route("address.get")}}');
		x.passData('action','GET');
		x.passData('id',update_id);
		x.globalAlert(false);
		x.start(function(response) {
			if(response.status == true) {
				autoFill('#delivery_address_form',response.data[0]);
			}
		});
	}

	// Remove Address List
	function removeDeliveryAddress(delete_id){
		var AddressBox = $('.addrs_list');
		AddressBox.hide();
		var x = new Ajx;
		x.actionUrl("{{route('address.post')}}");
		x.ajxLoader('#address-loader');
		x.globalAlert(false);
		x.errorMsg(false);
		x.passData('action', 'DELETE');
		x.passData('id',delete_id);
		x.start(function(response) {
			if (response.status == true) {
				$('#change-addrs-btn').click();
				getCartDetails();
			} else {
				alert(response.message);
			}
		});
	}

	function checkout(){
		var address_id = $('#address_box .address_txt').attr('data-id');
		var x = new Ajx;
		x.actionUrl("{{route('order.post')}}");
		x.ajxLoader('#cart-loader');
		x.globalAlert(true);
		x.errorMsg(false);
		x.passData('action', 'BUY_CART_LIST');
		x.passData('address_id',address_id);
		x.start(function(response) {
			if (response.status == true) {
				var data = response.data;
				$('#address-loader').show();
				var options = {
				"key": "{{env('RAZORPAY_KEY')}}",
				"amount": data.total_amount,
				"currency": "INR",
				"name": "{{auth()->user()->name ?? null}}",
				"description": "Order Payment",
				"image": "{{asset('assets/img/logo/logo.png')}}",
				"order_id": data.order_id,
				"handler": function (response){
                    var x = new Ajx;
                    x.actionUrl("{{route('order.post')}}");
                    x.ajxLoader('#cart-loader');
                    x.globalAlert(true);
                    x.errorMsg(false);
                    x.passData('action', 'PAYMENT_STATUS');
                    x.passData('pay_id',address_id);
                    x.start(function(response) {
					// alert(response.razorpay_payment_id);
					// alert(response.razorpay_order_id);
					// alert(response.razorpay_signature)
				},
				"prefill": {
					"name": "{{auth()->user()->name ?? null}}",
					"email": "{{auth()->user()->email ?? null}}",
					"contact": "{{auth()->user()->mobile ?? null}}"
				},
				"theme": {
					"color": "#3CB815"
				}};
				var rzp1 = new Razorpay(options);
				rzp1.on('payment.failed',
				function (response){
					// alert(response.error.code);
					alert(response.error.description);
					// alert(response.error.source);
					// alert(response.error.step);
					alert(response.error.reason);
					// alert(response.error.metadata.order_id);
					// alert(response.error.metadata.payment_id);
				});
				rzp1.open();
			} else {
				alert(response.message);
			}
		});
	}

</script>
@endsection
