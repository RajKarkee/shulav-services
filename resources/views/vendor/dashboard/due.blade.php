@if ($user->vendor->active == 0)
    <div class="bg-warning shadow mb-3">
        <div class="card-body text-white">
            Please Pay Due Bills To Activate Your Account
        </div>
    </div>
@else
    @if ($user->vendor->bills->where('paid', 0)->count() > 0)
        <div class="bg-warning shadow mb-3">
            <div class="card-body text-white">
                You Have {{ $user->vendor->bills->where('paid', 0)->count() }} Due Bills. Please Pay As soon as
                possible.
            </div>
        </div>
    @endif
@endif
