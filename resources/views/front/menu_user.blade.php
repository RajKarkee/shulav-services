<li class="user">
    {{-- <a href="{{route($user->getRole().'.dashboard')}}" > --}}
    <a  data-bs-toggle="offcanvas" href="#sidebar-desktop" role="button" aria-controls="sidebar-desktop">
        <img class="rounded-image profile-image" src="{{$user->role<2?asset('admin/img/user.svg'):asset($user->vendor?->image)}}" alt="">
    </a>
</li>
