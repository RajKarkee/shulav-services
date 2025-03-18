<div id="reviews" class=" shadow mt-2">
    <div class="title">
        <span>
            Reviews
        </span>
        @if (!Auth::check()  )
        <a href="{{ route('login',['q'=>route('vendor',['username'=>$vendor->username])]) }}">
            login To review
        </a>
        @else
        @if ((Auth::user()->role==3 || Auth::user()->role==2) && (Auth::user()->vendor->id!=$vendor->id))
            <button class="btn-primary btn" data-bs-target="#add-review" data-bs-toggle="modal" data-bs->Add Review</button>
        @endif
        @endif
    </div>
    <div class="review-stat mt-4">
        {{-- <div class="review-stat-header text-center pb-4 d-flex align-items-center justify-content-center">
            <span class="d-flex align-items-center"><i class="material-icons">grade</i> <span id="reviews-avg"></span></span> <span class="mx-2">|</span>
            <span id="reviews-count"> Reviews</span>
        </div> --}}

    </div>
    <hr>
    <div id="reviews-inner">

    </div>
</div>
@if (Auth::check() && (Auth::user()->role==3 || Auth::user()->role==2) && (Auth::user()->vendor->id!=$vendor->id) )
    @include('front.page.vendor.reviewadd')
@endif
