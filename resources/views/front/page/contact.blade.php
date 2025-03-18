@extends('front.page')
@section('css')
    <link href="{{ asset('front/contact.css') }}" rel="stylesheet" />
    <style>
        .jumbotron {
            display: none;
        }
    </style>
@endsection
@section('meta')
    @include('front.index.meta')
@endsection
@section('title', 'Contact')
@section('jumbotron')
    <li>Contact</li>
@endsection
@section('content')
    <div class="w-100">
        <div class="gmap_canvas1">
            <iframe id="gmap_canvas1"
                src="https://maps.google.com/maps?q={{ $data->map }}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
                scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
    </div>
    <div class="container">
        <div class="py-4">
            <h4 class="contact-title">
                Contact Us
            </h4>
            <div class="row">
                <div class="col-md-4 py-3">
                    <div class="contact-holder">
                        <div class="contact-logo">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="contact-inner">
                            <div class="contact-header">Give us a call</div>
                            <div class="contact-text">
                                <a href="tel:{{ $data->phone }}">{{ $data->phone }}</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 py-3">
                    <div class="contact-holder">
                        <div class="contact-logo">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="contact-inner">
                            <div class="contact-header">Send us an email</div>
                            <div class="contact-text">
                                <a href="mailto:{{ $data->email }}">{{ $data->email }}</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 py-3">
                    <div class="contact-holder">
                        <div class="contact-logo">
                            <i class="fas fa-map-marked"></i>
                        </div>
                        <div class="contact-inner">
                            <div class="contact-header">Come see us</div>
                            <div class="contact-text">
                                <div>
                                    {!! $data->addr !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($data->others as $other)
            <div class="py-2">
                <h4 class="contact-title-sm">
                    {{ $other->name }} ({{ $other->designation }})
                </h4>
                <div class="row">
                    <div class="col-md-4 py-3">
                        <div class="contact-holder">
                            <div class="contact-logo-sm">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="contact-inner">
                                <div class="contact-text">
                                    <a href="tel:{{ $other->phone }}">{{ $other->phone }}</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 py-3">
                        <div class="contact-holder">
                            <div class="contact-logo-sm">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <div class="contact-inner">
                                <div class="contact-text">
                                    <a href="mailto:{{ $other->email }}">{{ $other->email }}</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 py-3 nb">
                        <div class="contact-holder"></div>
                    </div>

                </div>
            </div>
        @endforeach
        <div class="div py-2">
            <div class="row">
                <div class="pb-4 col-md-5">
                    <div class="contact-title">
                        FAQS
                    </div>

                    <div class="faqs">
                        @foreach ($faqs as $faq)

                            <a target="_blank" class="single-faq"
                                href="{{ route('faq', ['faq' => $faq->id]) }}">{{ $faq->q }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="pb-4 col-md-7">
                    <div class=" shadow">
                        <div class="card-body">
                            <div class="contact-title">
                                Drop Us A Message
                            </div>
                            <div class="contact-text" style="color: #626262;">
                                ​If you’ve got questions, we would love to answer them. Or perhaps some suggestions? We
                                would
                                love to hear them!
                            </div>
                            <div class="py-3">
                                <form action="{{ route('message') }}" accept-charset="utf-8" id="contact_form"
                                    method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="name" class="required">Name</label>
                                            <input type="text" name="name" required class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="email">Email </label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="phone">Phone Number </label>
                                            <input type="phone" name="phone" class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="subject" class="required">Subject </label>
                                            <input type="text" name="subject" required class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="msg">Message</label>
                                            <textarea rows="8" cols="50" name="msg" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-12 form-group text-right form-submit">
                                            <button class="btn btn-primary " type="submit">Submit</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if  (Session::has('msg'))
    <div class="modal fade" id="ignismyModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label=""><span>×</span></button>
                 </div>

                <div class="modal-body">

                    <div class="thank-you-pop">
                        <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
                        <h1>Thank You!</h1>
                        <p>Your submission is received and we will contact you soon</p>
                     </div>

                </div>

            </div>
        </div>
    </div>
    @endif
@endsection
@section('js')
@if  (Session::has('msg'))
    <script>
        $(document).ready(function () {
            $('#ignismyModal').modal('show');
        });
    </script>
@endif
@endsection
