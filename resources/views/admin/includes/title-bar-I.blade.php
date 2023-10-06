@if (isset($tbx['tb']) and $tbx['tb'] == 1)
    <div class="row bg__gray--color py-4 pb-3 rounded mx-0 mb-4">
        <div class="col-5">
            <h2 class="fs-2">
                <!-- {!! !empty(url()->previous()) != url()->current()
                    ? '<a href="" class="btn btn-primary fs-1 me-2" style="padding: 0px 6px;"><i class="icofont-arrow-left"></i></a>'
                    : null !!}  -->
                {{ $tbx['title'] ?? null }}
            </h2>
        </div>
        <div class="col-7">
            @if (isset($tbx['btn-name']))
                <a class="btn btn-success float-end fs-4 px-4" href="{{ $tbx['btn-link'] }}">
                    {{ $tbx['btn-name'] }}
                </a>
            @endif
            <a class="offcanvas__stikcy--toolbar__btn search__open--btn d-lg-none float-end me-3"
                href="javascript:void(0)" data-offcanvas="">
                <span class="offcanvas__stikcy--toolbar__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none"
                            stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                            stroke-width="32" d="M338.29 338.29L448 448"></path>
                    </svg>
                </span>
            </a>

            @if ($tbx['search-bar'] == true)
                <form class="product__view--search__form float-end d-none d-lg-flex me-2"
                    action="{{ url()->current() }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="date" class="form-control fs-4" name="date">
                        <button type="submit" class="btn btn-primary px-2 fs-4" type="button" id="button-addon2">
                            <i class="icofont-search"></i>
                        </button>
                    </div>

                </form>
            @endif
        </div>
    </div>
@endif
