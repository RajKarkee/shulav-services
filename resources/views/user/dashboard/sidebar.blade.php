<div class="col-md-4 pb-3">
    <div class="bg-white shadow">
        <div class="card-body">
            @include('user.dashboard.image')
            @include('user.dashboard.name')
            <hr>
            <div class="d-flex justify-content-between info">
                <span>
                    <i class="material-icons">person</i> <span>Member Since</span>
                </span>
                <span>
                    {{$user->created_at->format('M')}}, {{$user->created_at->year}}
                </span>
            </div>
            <div class="d-flex justify-content-between info">
                <span>
                    <i class="material-icons">room</i> <span>From</span>
                </span>
                <span id="from-input">
                    {{$user->vendor->city->name}}
                </span>
            </div>
            <hr class="my-1">
           <div class="info">
               <span >
                    {{$user->vendor->address}}
                </span>
            </div>
            <hr class="my-1">
            <div class="text-center">
                <a href="{{route('user.edit-info')}}" class="btn text-black w-100 " style="font-weight: 600;border:1px solid var(--black-primary);padding:5px 10px;margin-top:5px;">Edit Info</a>
                <a href="{{route('user.edit-info')}}" class="btn text-black w-100 " style="font-weight: 600;border:1px solid var(--black-primary);padding:5px 10px;margin-top:5px;">Change Password</a>
            </div>
        </div>
    </div>
    @include('user.dashboard.desc')
</div>
