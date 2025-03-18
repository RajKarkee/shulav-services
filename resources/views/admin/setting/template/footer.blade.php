@php
    $data=getSetting('minor');
@endphp
<div class="footer">
    <div >
        <div style="max-width: 100%" class="logo mb-2">
            <img src="{{asset($data->footer_logo)}}" alt="">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 footer-single">

            <a href="{{$data->play_store}}" class="mobile-logo">
                <img src="{{asset('front/palystore.svg')}}" class="w-100" alt="">
            </a>
            <hr class="d-block d-md-none">
        </div>
        <div class="col-md-3 footer-single">
                <div class="title mb-2">
                    {{$data->company}}
                </div>
                <div class="subtitle">
                    <address>
                        {!! $data->address !!}<br>
                        @foreach ($data->phone as $phone)

                        <a href="tel:{{$phone}}">{{$phone}}</a>,
                        @endforeach
                         <br>
                         @foreach ($data->email as $email)
                         <a href="mailto:{{$email}}">{{$email}}</a>,
                         @endforeach
                    </address>
                </div>
            <hr class="d-block d-md-none">
        </div>
        <div class="col-md-3 footer-single">
            <div class="title mb-2">
                Company
            </div>
            <div class="subtitle"> <a href="random">About Us</a> </div>
            <div class="subtitle"> <a href="random">Team</a> </div>
            <div class="subtitle"> <a href="random">Careers</a> </div>
            <div class="subtitle"> <a href="random">Contact Us</a> </div>
            <hr class="d-block d-md-none">

        </div>
        <div class="col-md-3 footer-single">
            <div class="title mb-2">
                Our Newsletter
            </div>
            <div class="subtitle mb-2 text-justify">
                To get latest new and updates from us please Subscribe our newsletter.
            </div>
                <form id="subscribe" action="{{route('subscribe')}}" class="subscribe shadow">
                    @csrf
                    <input type="email" required placeholder="Enter Email Address">
                    <button>
                        <i class="fas px-2 fa-arrow-right">
                        </i>
                    </button>
                </form>
        </div>


    </div>
    <hr class="mb-0">
                <div class="social">
                    @include('front.index.social')
                </div>
</div>

<div id="subscribe-modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE876;</i>
				</div>
				<h4 class="modal-title w-100">Awesome!</h4>
			</div>
			<div class="modal-body">
				<p class="text-center">Your booking has been confirmed. Check your email for detials.</p>
			</div>
			<div class="modal-footer text-center">
				<button class="btn btn-success d-block " data-bs-dismiss="modal" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>
