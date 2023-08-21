<!-- Add / Update Delivery Address -->
<div class="modal" id="delivery_address_modal" data-animation="slideInUp">
    <div class="modal-dialog quickview__main--wrapper">
        <header class="modal-header quickview__header">
            <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>✕ </button>
        </header>
        <div class="quickview__inner">
            <div class="">
                <h3 class="contact__form--title mb-10">Add Delivery Address</h3>
                <form class="contact__form--inner" action="{{route('address.post')}}" id="delivery_address_form">
                    <input type="hidden" value="" name="id">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">Full Name <span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="name" placeholder="User Full Name" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">Mobile <span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="mobile" placeholder="Mobile Number" type="number">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">City<span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="city" placeholder="City Name" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">State<span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="state" placeholder="State" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">Pincode<span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="pincode" placeholder="Pincode" type="number">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">Address Line 1<span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="address_line_1" placeholder="House Name, Area, Building Name" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">Address Line 2<span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="address_line_2" placeholder="Road name, Area, Colony" type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact__form--list mb-10">
                                <label class="contact__form--label">Address Notes<span class="contact__form--label__star">*</span></label>
                                <input class="contact__form--input" name="address_notes" placeholder="Nearby Famous Shop, Mall, Landmark" type="text">
                            </div>
                        </div>
                    </div>
                    <button class="contact__form--btn btn mt-2" type="button" onclick="saveDeliveryAddress()"> 
                        <span>Save Address</span>
                        {!! Hpx::spinner() !!}
                    </button>  
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Delivery Address End -->


