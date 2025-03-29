<div class="page-sidebar">
    <div class="logo-box"><a href="#" class="logo-text">{{env('APP_NAME','')}}</a><a href="#" id="sidebar-close"><i class="material-icons">close</i></a> <a href="#" id="sidebar-state"><i class="material-icons">adjust</i><i class="material-icons compact-sidebar-icon">panorama_fish_eye</i></a></div>
    <div class="page-sidebar-inner slimscroll">
        <ul class="accordion-menu" id="accordion-menu">

            <li>
                <a href="/">
                    <i class="material-icons">dashboard</i>
                    Dashboard
                </a>

            </li>
            <li>
                <a href="{{route('admin.setting.front.popup.index')}}">
                    <i class="material-icons">dashboard</i>
                    Popups
                </a>

            </li>
            <li>
                <a href="{{route('admin.faq.index')}}">
                    <i class="material-icons">quiz</i>
                    Faq
                </a>

            </li>
            <li>
                <a href="{{route('admin.setting.front.slider.index')}}">
                    <i class="material-icons">dashboard</i>
                    Sliders
                </a>
            </li>
            {{-- <li>
                <a href="#"><i class="material-icons">supervisor_account</i>Sellers<i class="material-icons has-sub-menu">add</i></a>
                <ul class="sub-menu">
                    <li class="sub-item">
                        <a  href="{{route('admin.vendor.index')}}" >List</a>
                    </li>
                    <li class="sub-item">
                        <a  href="{{route('admin.bills.index')}}" >Bills</a>
                    </li> --}}
                    {{-- <li class="sub-item">
                        <a  href="{{route('admin.vendor.add')}}" >Add New</a>
                    </li> --}}
                {{-- </ul>
            </li> --}}
{{--
            <li>
                <a href="{{ route('admin.product_types.index')}}">
                    <i class="material-icons">shopping_cart</i>
                    Product Type
                </a>
            </li> --}}
            <li>
                <a href="{{ route('admin.products.index')}}">
                    <i class="material-icons">shopping_cart</i>
                    Product
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('admin.service.index' ,['type'=>1])}}">
                    <i class="material-icons">build</i>
                    Services
                </a>
            </li> --}}

            <li>
                <a href="{{route('admin.realstates.index')}}">
                    <i class="material-icons">dashboard</i>
                    Real Estates
                </a>
            </li>

            <li >
                <a href="#"><i class="material-icons">settings</i>Restaurant<i class="material-icons has-sub-menu">add</i></a>
                <ul class="sub-menu">
                    <li class="sub-item">
                        <a  href="{{route('admin.restaurant.index')}}" >Rastaurant</a>
                    </li>

                    <li class="sub-item">
                        <a  href="{{route('admin.restaurant.menu.index')}}" >Item Menus</a>
                    </li>

                    <li class="sub-item">
                        <a  href="#" >Orders</a>
                    </li>

                </ul>
            </li>



            <li >
                <a href="#"><i class="material-icons">settings</i>Settings<i class="material-icons has-sub-menu">add</i></a>
                <ul class="sub-menu">
                    <li class="sub-item">
                        <a  href="{{route('admin.pricing.index')}}" >Pricing</a>
                    </li>
                    <li class="sub-item">
                        <a  href="{{route('admin.setting.category.index')}}" >Services</a>
                    </li>
                    <li class="sub-item">
                        <a  href="{{route('admin.setting.city.index')}}" >Cities</a>
                    </li>
                    <li class="sub-item">
                        <a  href="{{route('admin.setting.front.minor')}}" >Front Setting</a>
                    </li>
                    <li class="sub-item">
                        <a  href="{{route('admin.setting.front.step')}}" >Front Step</a>
                    </li>
                    <li class="sub-item">
                        <a  href="{{route('admin.setting.front.website')}}" >Website Info</a>
                    </li>
                    <li class="sub-item">
                        <a  href="{{route('admin.setting.payment')}}" >Payment gateways</a>
                    </li>
                    <li class="sub-item">
                        <a href="{{route('admin.setting.front.contact')}}" > Contact page</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
