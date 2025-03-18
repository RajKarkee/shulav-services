<div class="col-md-4 pb-3 {{Route::is('vendor.dashboard')?'':' d-none d-md-block'}}">
    <div class="bg-white shadow">
        <div class="card-body">
            @include('vendor.dashboard.image')
            @include('vendor.dashboard.name')
            <hr>
            <div class="d-flex justify-content-between info">
                <span>
                    <i class="fas me-1 fa-user-clock"></i> <span>Member Since</span>
                </span>
                <span>
                    {{$user->created_at->format('M')}}, {{$user->created_at->year}}
                </span>
            </div>
            @if ($user->vendor->city)
                
            <div class="d-flex justify-content-between info">
                <span>
                    <i class="fas me-1 fa-map-marker-alt"></i> <span>From</span>
                </span>
                <span id="from-input">
                    {{$user->vendor->city->name}}
                </span>
            </div>
            <hr class="my-1">
            @endif
           <div class="info">
               <span >
                    {{$user->vendor->address}}
                </span>
            </div>
            <hr class="my-1">
            <div class="text-center">

                <a href="{{route('vendor.edit-info')}}" class="btn text-black w-100 " style="font-weight: 600;border:1px solid var(--black-primary);padding:5px 10px;margin-top:5px;">Edit Info</a>
            </div>
        </div>
    </div>
    @include('vendor.dashboard.desc')
</div>
