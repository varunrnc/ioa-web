<!-- <ul class="widget__categories--menu">
    <li class="widget__categories--menu__list">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-dashboard-web menu-icon"></i>
            <span class="widget__categories--menu__text">Dashboard</span>
        </label>
    </li>
</ul> -->

<ul class="widget__categories--menu">
    <li class="widget__categories--menu__list drop_menu">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-home menu-icon"></i>
            <span class="widget__categories--menu__text">Orders</span>
            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355"
                height="8.394">
                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                    transform="translate(-6 -8.59)" fill="currentColor"></path>
            </svg>
        </label>
        <ul class="widget__categories--sub__menu">
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('order.index') }}">
                    <i class="icofont-cart menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Orders</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('customer.index') }}">
                    <i class="icofont-users-alt-5 menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Customers</span>
                </a>
            </li>
            {{--
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{route('testimonial.index')}}">
                    <i class="icofont-users-alt-5 menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Reports</span>
                </a>
            </li>
            --}}
        </ul>
    </li>

    <li class="widget__categories--menu__list drop_menu">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-cube menu-icon"></i>
            <span class="widget__categories--menu__text">Product</span>
            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355"
                height="8.394">
                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                    transform="translate(-6 -8.59)" fill="currentColor"></path>
            </svg>
        </label>
        <ul class="widget__categories--sub__menu">
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('product.index') }}">
                    <i class="icofont-cubes menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Products</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('admin.plant.index') }}">
                    <i class="icofont-flora-flower menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Plants</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('category.index') }}">
                    <i class="icofont-listing-box menu-icon2 fs-3"></i>
                    <span class="widget__categories--sub__menu--text">Category</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('admin.sub-category.index') }}">
                    <i class="icofont-listing-box menu-icon2 fs-3"></i>
                    <span class="widget__categories--sub__menu--text">Sub-Category</span>
                </a>
            </li>
        </ul>
    </li>

    <a href="{{ route('admin.chat') }}" class="widget__categories--menu__list w-100">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-ui-text-chat menu-icon"></i>
            <span class="widget__categories--menu__text">Messages</span>
            <h4 class="widget__categories--menu__arrowdown--icon text-success msg_menu_count"
                style="top: 4px; font-weight: bold; color: #c70000 !important; display: none; font-size: 14px;"></h4>
        </label>
    </a>

    <li class="widget__categories--menu__list drop_menu">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-home menu-icon"></i>
            <span class="widget__categories--menu__text">Website</span>
            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355"
                height="8.394">
                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                    transform="translate(-6 -8.59)" fill="currentColor"></path>
            </svg>
        </label>
        <ul class="widget__categories--sub__menu">
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('slider.index') }}">
                    <i class="icofont-multimedia menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Slider</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('testimonial.index') }}">
                    <i class="icofont-users-alt-5 menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Testimonial</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="widget__categories--menu__list drop_menu">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-home menu-icon"></i>
            <span class="widget__categories--menu__text">Plants</span>
            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355"
                height="8.394">
                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                    transform="translate(-6 -8.59)" fill="currentColor"></path>
            </svg>
        </label>
        <ul class="widget__categories--sub__menu">
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('admin.mplant.index') }}">
                    <i class="icofont-multimedia menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Plant</span>
                </a>
            </li>

        </ul>
    </li>

    <li class="widget__categories--menu__list drop_menu">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-papers menu-icon"></i>
            <span class="widget__categories--menu__text">Posts</span>
            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355"
                height="8.394">
                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                    transform="translate(-6 -8.59)" fill="currentColor"></path>
            </svg>
        </label>
        <ul class="widget__categories--sub__menu">
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('post.index') }}">
                    <i class="icofont-ui-copy menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">All Posts</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('post.create') }}">
                    <i class="icofont-page menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Add New</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('post-category.index') }}">
                    <i class="icofont-layout menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Categories</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="widget__categories--menu__list drop_menu">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-video-alt menu-icon" style="font-size: 2.2rem;"></i>
            <span class="widget__categories--menu__text">Videos</span>
            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355"
                height="8.394">
                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                    transform="translate(-6 -8.59)" fill="currentColor"></path>
            </svg>
        </label>
        <ul class="widget__categories--sub__menu">
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('video.index') }}">
                    <i class="icofont-ui-video menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">All Videos</span>
                </a>
            </li>
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('webinar.index') }}">
                    <i class="icofont-users-alt-2 menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Webinar</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="widget__categories--menu__list drop_menu">
        <label class="widget__categories--menu__label d-flex align-items-center">
            <i class="icofont-gear-alt menu-icon"></i>
            <span class="widget__categories--menu__text">Settings</span>
            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355"
                height="8.394">
                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                    transform="translate(-6 -8.59)" fill="currentColor"></path>
            </svg>
        </label>
        <ul class="widget__categories--sub__menu">
            <li class="widget__categories--sub__menu--list">
                <a class="widget__categories--sub__menu--link d-flex align-items-center"
                    href="{{ route('order_setting.index') }}">
                    <i class="icofont-settings menu-icon2"></i>
                    <span class="widget__categories--sub__menu--text">Order Settings</span>
                </a>
            </li>
        </ul>
    </li>

</ul>
