@extends('admin.layout.app')
@section('css-include')
    <link href="{{ asset('admin/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

@endsection
@section('page-option')
    <a type="button" class="btn btn-primary" href="{{ route('admin.vendor.add') }}">Add Seller</a>
@endsection
@section('s-title')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.vendor.index') }}">Sellers</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $vendor->user->name }}
    </li>
@endsection
@section('content')
<div class="card shadow mb-3">
    <div class="card-body" id="cities-holder">
        @if ($vendor->active==1)
        <a href="{{route('admin.vendor.status',['vendor'=>$vendor->id,'status'=>0])}}" onclick="return prompt('Enter yes To Deactivate Vendor')=='yes';" class="btn btn-danger">Deactivate Vendor </a>

        @else
        <a href="{{route('admin.vendor.status',['vendor'=>$vendor->id,'status'=>1])}}" class="btn btn-success" onclick="return prompt('Enter yes To Activate Vendor')=='yes';">Activate Vendor</a>
        @endif
    </div>
</div>
    <div class="card shadow mb-3">
        <div class="card-body" id="cities-holder">
            <div class="row">
                <div class="col-md-2 mb-2">
                    <img class="w-100" src="{{ asset($vendor->image) }}" alt="">
                </div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-md-3">
                    <strong>
                        Name
                    </strong>
                    <br>
                    <div>
                        {{ $vendor->user->name }}
                    </div>
                </div>
                <div class="col-md-3">
                    <strong>
                        Email
                    </strong>
                    <br>
                    <div>
                        {{ $vendor->user->email }}
                    </div>
                </div>
                <div class="col-md-3">
                    <strong>
                        Phone
                    </strong>
                    <br>
                    <div>
                        {{ $vendor->phone }}
                    </div>
                </div>
                <div class="col-md-3">
                    <strong>
                        City
                    </strong>
                    <br>
                    <div>
                        {{ $vendor->city->name }}
                    </div>
                </div>
                <div class="col-md-3">
                    <strong>
                        St. Address
                    </strong>
                    <br>
                    <div>
                        {{ $vendor->address }}
                    </div>
                </div>
                <div class="col-3">
                    <strong>
                        Status
                    </strong>
                    <br>
                    <div>
                        @if ($vendor->active == 1)
                            <span class="text-success">

                                Active
                            </span>
                        @else
                            <span class="text-danger">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-3">
                    <strong>
                        Stage
                    </strong>
                    <br>
                    <div>
                        {{ $vendor->step }}
                    </div>
                </div>
                {{-- <div class="col-3">
                    <strong>
                        Views
                    </strong>
                    <br>
                    <div>
                        {{ $vendor->count }}
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="card shadow mb-3">
        <h2 class="p-3">
            Reviews
        </h2>
        <hr class="my-0">
        <div class="card-body">
            <div class="row">
                <div class=" col-md-6 text-left">
                    <strong class="mr-2">Reviews Count : </strong> {{ $reviews->count() }}
                </div>
                <div class=" col-md-6 text-left text-md-right">
                    <strong class="mr-2">Reviews Count : </strong> {{ $reviews->avg('r') }}
                </div>
            </div>
        </div>
        <hr class="my-0">
        <div class="card-body">
            <div class="row">

                @foreach ($reviews as $review)
                    <div class="col-md-6 mb-3">

                        <div class="row m-0 p-2 h-100 shadow">
                            <img src="{{ asset($review->i) }}" style="width:50px;" alt="">
                            <div style="width: calc(100% - 50px);" class="p-2 d-flex justify-content-between">

                                <h5>
                                    {{ $review->n }}
                                </h5>
                                <h5>
                                    <i class="material-icons">grade</i> {{ $review->r }}
                                </h5>

                            </div>
                            <div>
                                {{ $review->d }}
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card shadow mb-3">
        <h2 class="p-3">
            Bills
        </h2>
        <hr class="my-0">
        <div class="card-body">
            <table class="table">
                <tr>

                    <th>
                        #REF ID
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Particular
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>

                    </th>
                </tr>
                @foreach ($vendor->bills as $bill)
                    <tr>
                        <th>
                            {{ $bill->id }}
                        </th>
                        <th>
                            {{ $bill->date->toDateString() }}
                        </th>
                        <td>
                            {{ $bill->particular }}
                        </td>
                        <td>
                            <span class="{{ $bill->paid ? 'text-success' : 'text-warning' }}">
                                {{ $bill->paid ? 'Paid' : 'Unpaid' }}
                            </span>

                        </td>
                        <td>
                            {{ $bill->amount }}
                        </td>
                        <td>
                            <a target="_blank" href="{{ route('admin.bills.detail', ['bill' => $bill->id]) }}">View Bill</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{-- <div class="card shadow mb-3">
        <h2 class="p-3">
            Services
        </h2>
        <hr class="my-0">
        <div class="card-body">
            <div class="row">
                @foreach ($products->where('type',2) as $service)
                <div class="col-md-6 col-12 p-0 mobile-sm">
                    <div class="row shadow m-0">
                        <div class="col-md-6 pl-0">
                            <a  class="service shadow d-block  h-100">
                                <div class="p-3">
                                    <img class="w-100" src="{{ asset($service->image) }}" alt="">
                                </div>
                                <div class="text-center">
                                    {{ $service->name }}
                                    <br>
                                    @if ($service->active==1)
                                    <span class="text-success">Active</span>
                                    @else
                                    <span class="text-danger">InActive</span>
                                    @endif
                                </div>
                            </a>

                        </div>
                        <div class="col-md-6 pr-0 py-3">
                            <div class="text-start">
                                <a target="_blank" href="{{route('admin.vendor.pdetail',['product'=>$service->id])}}">View Detail</a>
                                <br>
                                @if ($service->active==1)
                                <a href="{{route('admin.vendor.pstatus',['product'=>$service->id,'status'=>0])}}" class="text-danger">Deactivate</span>
                                @else
                                <a class="text-success" href="{{route('admin.vendor.pstatus',['product'=>$service->id,'status'=>1])}}">Activate</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card shadow mb-3">
        <h2 class="p-3">
            Products
        </h2>
        <hr class="my-0">
        <div class="card-body">
            <div class="row">
                @foreach ($products->where('type',1) as $service)
                    <div class="col-md-6 col-12 p-0 mobile-sm">
                        <div class="row shadow m-0">
                            <div class="col-md-6 pl-0">
                                <a  class="service shadow d-block  h-100">
                                    <div class="p-3">
                                        <img class="w-100" src="{{ asset($service->image) }}" alt="">
                                    </div>
                                    <div class="text-center">
                                        {{ $service->name }}
                                        <br>
                                        @if ($service->active==1)
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="text-danger">InActive</span>
                                        @endif
                                    </div>
                                </a>

                            </div>
                            <div class="col-md-6 pr-0 py-3">
                                <div class="text-start">
                                    <a target="_blank" href="{{route('admin.vendor.pdetail',['product'=>$service->id])}}">View Detail</a>
                                    <br>
                                    @if ($service->active==1)
                                    <a href="{{route('admin.vendor.pstatus',['product'=>$service->id,'status'=>0])}}" class="text-danger">Deactivate</span>
                                    @else
                                    <a class="text-success" href="{{route('admin.vendor.pstatus',['product'=>$service->id,'status'=>1])}}">Activate</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    @php
        $skills = App\Models\Skill::where('user_id',$vendor->user->id)->get();
        $certificate = App\Models\Certificate::where('user_id',$vendor->user->id)->get();
    @endphp

    <div class="card shadow mb-3">
        <h2 class="p-3">
            Skills
        </h2>
        <hr class="my-0">
        <div class="card-body">
            <div class="row">
                @foreach ($skills as $skill)
                    <div class="col-md-4 col-12 p-0 mobile-sm">
                        <div class="row shadow m-0">
                            <div class="col-md-6 pr-0 py-3">
                                <div class="text-start">
                                   {{ $skill->title }}
                                    <br>
                                    @if ($skill->type == 1)
                                     <strong>Level One</strong>
                                    @elseif ($skill->type == 2)
                                     <strong>Level two</strong>
                                    @elseif ($skill->type == 3)
                                      <strong>Level Three</strong>
                                    @elseif ($skill->type == 4)
                                     <strong>Level Four</strong>
                                    @else
                                     <strong>Level Five</strong>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>

    <div class="card shadow mb-3">
        <h2 class="p-3">
            Certificate
        </h2>
        <hr class="my-0">
        <div class="card-body">
            <div class="row">
                @foreach ($certificate as $certi)
                    <div class="col-md-4 col-12 p-0 mobile-sm text-center">
                        <div class="row shadow m-0">
                            <div class="col-md-6 pr-0 py-3">
                                <div class="text-start">
                                    <img src="/{{$certi->image}}" alt="" style="height: 100px;">
                                    <br>
                                    {{ $certi->title }}


                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>

@endsection
@section('script')


@endsection
