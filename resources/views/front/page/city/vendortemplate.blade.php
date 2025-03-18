<span class="d-none" id="vendor-template">
    <a class="col-md-4 col-6 vendor-alternate " href="{{ route('vendor', ['username' => 'xxx_username']) }}">
        <div class="vendor-card p-2 p-md-4 mt-3">
            <div class="first d-none d-md-block">
                <h6 class="heading">xxx_name</h6>

            </div>
            <div class="row m-0">
                <div class="col-md-3">
                    <div class="image">
                        <img id="image-xxx_id" data-src="xxx_image" src="/uploads/vendor/blank.svg" alt=""
                            class="lazy-xxx_step rounded-circle ">
                    </div>
                    <div class="d-block d-md-none">
                        <h6 class="heading">xxx_name</h6>
                        {{-- <div class="time d-flex flex-row align-items-center justify-content-between mt-3">
                            <div class="d-flex align-items-center"> <i class="fa fa-clock-o clock"></i> <span class="hour ml-1">3 hrs</span> </div>
                            <div> <span class="font-weight-bold">$90</span> </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-9 p-0 info">
                    <div class="d-flex m-0 justify-content-center justify-content-md-between">
                        <span
                            class="p-0  d-none d-md-inline-flex align-items-center justify-content-center justify-content-md-start"
                            style="word-break:break-all">@xxx_username</span>
                        <span
                            class="p-0 d-flex  d-md-inline-flex align-items-center justify-content-center justify-content-md-end">
                            <i class="fas me-1 fa-star"></i>
                            <span class="ms-1">xxx_rate</span>
                        </span>
                    </div>
                    {{-- @if (!Request::has('ser_id'))
                        <div class="p-0 pt-1 center">
                            <i class="fas me-1 fa-briefcase"></i>
                            <span class="service">xxx_service</span>
                        </div>
                    @endif --}}
                    <div class="p-0 pt-1 center ">
                        <i class="fas me-1 fa-mobile-alt"></i>
                        <span class="city">xxx_phone</span>
                    </div>

                    <div class="p-0 pt-1 no-overflow text-center text-md-start">
                        xxx_address

                    </div>


                </div>
            </div>
            <div class="d-none d-md-block">
                <hr class="line-color my-2">
                <div class="row info">
                    <div class="col-md-6 text-md-start text-center ">
                        <span class="text-center d-inline-block">

                            <div>
                                xxx_reviews Comments
                            </div>
                        </span>
                    </div>
                    <div class="col-md-6 text-md-end text-center">
                        <span class="text-center d-inline-block">
                            <div>
                                xxx_count Profile Views
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </a>
</span>
