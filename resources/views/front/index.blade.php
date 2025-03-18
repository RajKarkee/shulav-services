<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('front/head.css') }}">
    <meta name="theme-color" content="#FF5A5F" />
    <title>{{ env('APP_NAME', '') }}</title>
    {{-- @include('front.index.meta') --}}
</head>

<body>
    <script>
        function s(sev) {
            let temp = [];
            (sev.split(',')).forEach(ele => {
                const _temp = ele.split('|');
                temp.push({
                    id: _temp[0],
                    name: _temp[1],
                    image: _temp[2]
                });
            });
            return temp;
        }

        _data = {!! json_encode($data) !!};
        data = [];
        for (const key in _data) {
            if (Object.hasOwnProperty.call(_data, key)) {
                const ele = _data[key];
                data[key] = ele.split(',');
            }
        }

        cats = {!! json_encode($cats) !!}

        console.log(cats);
    </script>
    @include('front.sidebar')
    <div id="page-holder" data-role="close-sidebar">
        <datalist id="data-cities">

        </datalist>
        <datalist id="data-services">

        </datalist>

        <div class="head">
            @include('front.menu')
            <div class="desc">
                <div class="large">
                    Discover
                </div>
                <div class="small">
                    your amazing city
                </div>
                <form action="{{ route('searchname') }}" method="get">
                    <div class="search">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="search-item">
                                    <div class="text">
                                        What
                                    </div>
                                    <input list="data-services" name="ser" type="text"
                                        placeholder="Ex: Electric Repair, Ac Repair, Tuiton Teacher">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="search-item">
                                    <div class="text">
                                        Where
                                    </div>
                                    <input list="data-cities" name="loc" type="text"
                                        placeholder="Ex: Kathmandu, Biratnagar">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button>Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="rec">
                    <div class="rec-title">
                        or, browse one of our recomendation
                    </div>
                    <div class="row m-0 justify-content-start">
                        @foreach ($recs as $rec)
                            {{-- @php
                                dd($rec);
                            @endphp --}}
                            <a href="{{ route('search', ['ser_id' => $rec->id]) }}" class=" rec-item ">
                                <div class="logo">
                                    <img src="{{ asset($rec->image) }}" alt="" srcset="">
                                </div>
                                <div class="d-flex justify-content-center">

                                    <div class="line">

                                    </div>
                                </div>
                                <div class="text">
                                    {{ $rec->name }}
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="second" id="seconds">
            {{-- @include('front.index.how') --}}
            <div class="title">
                <strong>Top</strong> Products
            </div>

        </div>
        @include('front.index.service')
        {{-- @include('front.index.footer') --}}
    </div>

    @php
        $popup = getPopup();
    @endphp
    @if ($popup != null)
        <!-- Modal -->
        <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered {{ $popup->is_large == 1 ? 'modal-xl' : ' modal-lg' }}"
                role="document">
                <div class="modal-content popup">


                    <button type="button" class="popup btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-close"></i>
                    </button>

                    <div class="modal-body p-0">
                        <img class="w-100" src="{{ asset($popup->image) }}" alt="">
                    </div>

                </div>
            </div>
        </div>
    @endif

    <a href="{{route('vendor.product.add',['type'=>1])}}" class="add-product">
        <i class="fas fa-plus"></i>
        Add Product
    </a>

    <button onclick="goToTop()" class="go-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://kit.fontawesome.com/43f4dfae9c.js" crossorigin="anonymous"></script>

    <script src="{{ asset('front/js/page.js') }}"></script>

    <script>
        function activate() {
            $('.cat').addClass('d-hide');
            $('#cat-' + $('.btn-service.active').data('id')).removeClass('d-hide');
        }
        $(function() {
            @if ($popup != null)
                if (cityChoosen_str != null) {
                    $('#popup').modal('show');
                }
            @endif
            const service_url = '{{ route('search', ['ser_id' => 'xxx_id']) }}';
            let i = 0;
            service_html = "<div class='row'>";
            cats.forEach(cat => {

                service_html += '<div class="col-lg-2 col-md-4 col-6">' +
                    '<a href="' + (service_url.replace('xxx_id', cat.id)) +
                    '" class="square d-block">' +
                    '<div class="single-service square-inner">' +
                    '<img src="{{ asset('') }}' + cat.image + '">' +
                    '<div class="name">' + cat.name + '</div>' +
                    '</div>' +
                    '</a>' +

                    '</div>';

            });
            service_html += "</div>";
            $('#service-holder').append(service_html);
            data['cities'].forEach(city => {
                $('#data-cities').append('<option value="' + city + '">' + city + '</option>');
            });
            data['services'].forEach(city => {
                $('#data-services').append('<option value="' + city + '">' + city + '</option>');
            });
            activate();
            // $('.btn-service').click(function (e) {
            //     e.preventDefault();
            //     $('.btn-service').removeClass('active');
            //     $(this).addClass('active');
            //     activate();
            // });
            $('#subscribe').submit(function(e) {
                e.preventDefault();
                let ele = this;
                axios.post($(this).attr('action'), (new FormData(this)))
                    .then((res) => {
                        $('#subscribe-modal').modal('show');
                    })
                    .catch((err) => {

                    });

            });
        });
    </script>

    @include('share.citychooserjs')
    <script>
        function loadTops() {
            const x_cid = x_city == null ? null : x_city.id;
            console.log(x_cid);
            axios.post("{{ route('indexData') }}", {
                    city_id: x_cid
                })
                .then((res) => {
                    $('#seconds').append(res.data);
                })
        }
        if (x_city != null) {
            loadTops();
        }
    </script>


</body>

</html>
