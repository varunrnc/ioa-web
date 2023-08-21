<!-- Start offCanvas minicart -->
<div class="offCanvas__minicart" id="modal_address_list">
    <div class="minicart__header mb-4">
        <div class="minicart__header--top d-flex justify-content-between align-items-center">
            <h3 class="minicart__title">Addresses</h3>
            <button class="minicart__close--btn" aria-label="minicart close btn" data-offcanvas>
                <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg>
            </button>
        </div>
        <p class="minicart__header--desc">Select one for your delivery address</p>
    </div>
    <div id="address-loader" style="display:non; width: 100%;">
        <div class="d-flex justify-content-center align-items-center" style="height: 150px;">
                {!! Hpx::spinner('block') !!}
        </div>
    </div>
    <div class="addrs_list mb-3">
    </div>
    <div class="minicart__button d-flex justify-content-center">
        <a class="btn minicart__button--link" id="add_new_address_btn" href="javascript:void(0)">Add New Address</a>
    </div>
</div>
<!-- End offCanvas minicart -->
