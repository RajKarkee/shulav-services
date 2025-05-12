<div class="menu">
    {{-- @include('front.index.menu_logo') --}}
    <div class="menu-section">
        <ul>



            @if (Auth::check())
                @php
                    $user = Auth::user();
                @endphp

                @if ($user->role == 2)
                    <li>
                        <a class="{{ Request::is('vendor/dashboard/job-search') ? 'text-danger' : '' }}" href="{{ route('vendor.job-search.index') }}">Search Jobs</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('vendor/dashboard/my-bids') ? 'text-danger' : '' }}" href="{{ route('vendor.mybids') }}">My bids</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('vendor/dashboard/bid-accepted-jobs') ? 'text-danger' : '' }}" href="{{ route('vendor.bidaccept') }}">Bid Accepted jobs</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('vendor/dashboard/finished-jobs') ? 'text-danger' : '' }}" href="{{ route('vendor.finishedJob') }}">Finished Jobs</a>
                    </li>
                    <li>
                        <a href="{{route('user.products.index')}}">My products</a>
                    </li>
                @endif

                @if ($user->role == 3)
                    <li>
                        <a class="{{ Request::is('user/jobs') ? 'text-danger' : '' }}"
                            href="{{ route('user.jobs.index') }}">My Jobs</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('user/jobs/bid-requested') ? 'text-danger' : '' }}"
                            href="{{ route('user.jobs.requested') }}">Bid Requested Jobs</a>
                    </li>
                    <li>
                        <a class="{{ Request::is('user/jobs/running') ? 'text-danger' : '' }}"
                            href="{{ route('user.jobs.running') }}">Running Jobs</a>
                    </li>

                    <li>
                        <a class="{{ Request::is('user/jobs/finished') ? 'text-danger' : '' }}"
                            href="{{ route('user.jobs.finished') }}">Finished Jobs</a>
                    </li>


                @endif
                    <div class="pull-right">
                        @include('front.menu_user')

                    </div>


            @else

                <li>
                    <a href="{{ route('loginFirst') }}">Sign In</a>
                </li>
                <li>
                    <a href="{{ route('vendor.product.add', ['type' => 1]) }}" class="btn-menu-sell">Add Product</a>
                </li>
            @endif

        </ul>

    </div>
    <div class="menu-section">
        <ul>
            <li><a href="{{ route('user.cart') }}"><img src="https://img.icons8.com/ios-filled/40/null/shopping-cart.png"/></a></li>
        </ul>
    </div>
</div>


