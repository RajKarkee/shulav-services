@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'Vendor Dashboard ')

@section('content')

    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3" >
                        <div class="card-body " id="jumbotron">
                            <a href="{{route('vendor.dashboard')}}">Dashboard</a>
                            <span>Manage Services</span>
                        </div>
                    </div>
                    @include('vendor.dashboard.due')

                    <div class="bg-white shadow p-3 mb-3">
                        <form action="{{route('vendor.subscribe')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="category_id">Service Category</label>
                                    <select name="category_id" id="category_id" class="form-control">

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="service_id">Service </label>
                                    <select name="service_id" id="service_id" class="form-control">

                                    </select>
                                </div>
                                <div class="py-2 text-end">
                                    <button class="btn btn-primary" onclick="return confirm('Do you want to add service?');">
                                        Add New Subscription
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (count($cats1)>0)    
                        <div class="bg-white shadow mb-3" >
                            <div class="card-body " id="">
                                <h5>
                                    Subscribed Services
                                </h5>
                                <hr>
                                <div id="subscribed-services">
                                    <div class="row">

                                        @foreach ($cats1 as $otherService)
                                        <div class="col-md-6 pb-3 mobile-sm">
                                            <div class="row shadow m-0 ">

                                                <div class="col-6 ps-0">
                                                    <a href="{{ route('search', ['ser_id' => $otherService->service_id]) }}"
                                                        class="service h-100">
                                                        <img src="{{ asset($otherService->image) }}" alt="">
                                                        <div class="name">
                                                            {{ $otherService->name }}
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-6 py-2">
                                                    @if ($otherService->paid==0)
                                                        <div>
                                                            Please Pay Bill To Activate this Service
                                                        </div>
                                                        <hr class="my-1">
                                                        <div class="text-center">
                                                            <a class="text-success" target="_blank" href="{{route('vendor.bill',['bill'=>$otherService->bill_id??1])}}">View Bill</a>

                                                        </div>
                                                    @else
                                                        @if ($otherService->service_id!=$user->vendor->service_id)
                                                            <a class="text-success" href="{{route('vendor.change-main-service',['id'=>$otherService->service_id])}}">Make Primary</a><hr class="my-1">
                                                            @if ($otherService->active==1)
                                                            <a class="text-danger" href="{{route('vendor.change-status-service',['id'=>$otherService->id,'status'=>0])}}">Deactivate</a>

                                                            @else
                                                            <a class="text-success" href="{{route('vendor.change-status-service',['id'=>$otherService->id,'status'=>1])}}">Activate</a>
                                                            @endif

                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
    <script>
        const cats={!!json_encode($cats)!!};
        const cats1={!!json_encode($cats1)!!};

        $(document).ready(function () {
            let html='';

            cats.forEach(cat => {
                html+='<option value="'+cat.id+'">'+cat.name+'</option>';
            });
            $('#category_id').html(html);
            $('#category_id').change(function (e) {
                e.preventDefault();
                loadServices();
            });
            loadServices();

            // html='';
            // cats1.forEach(cat => {
            //     html='<div><h6>'+cat.name+'</h6><div class="px-3">';
            //         cat.services.split(',').forEach(service => {
            //             const servicedata=service.split(':');
            //             html+='<span class="m-2 shadow p-2 px-4">'+servicedata[1] +'</span>';
            //         });
            //     html+='</div></div>';
            // });
            // $('#subscribed-services').html(html);

        });

        function  loadServices() {
            let html='';
            const cat_id=$('#category_id').val();
            data=cats.find(o=>o.id==cat_id);
            console.log(data);
            data.services.split(',').forEach(service => {
                const servicedata=service.split(':');
                html+='<option value="'+servicedata[0]+'">'+servicedata[1] +' (Rs. '+ servicedata[2]+')'+'</option>';

            });
            $('#service_id').html(html);

        }
    </script>
@endsection
