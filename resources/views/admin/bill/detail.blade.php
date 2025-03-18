@extends('admin.layout.app')
@section('css')
    <style>
        .sm-title{
            font-weight: 600;
            font-size: 1.2rem;

        }
        .form-control{
            border-radius: 0px;
        }
    </style>
@endsection
@section('page-option')
    <a type="button" class="btn btn-primary" href="{{ route('admin.vendor.add') }}">Add Vendor</a>
@endsection
@section('s-title')

    <li class="breadcrumb-item ">
        <a href="{{route('admin.bills.index')}}">Bills</a>
    </li>
    <li class="breadcrumb-item active">
        #{{$bill->id}}
    </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="sm-title">
                        Invoiced To
                    </div>
                    <div>
                        {{$bill->name}}, <br>
                        {{$bill->vendor->phone}}, <br>
                        {{$bill->vendor->address}}, <br>
                        {{$bill->vendor->city->name}}, Nepal
                    </div>


                    <div class="sm-title mt-3">
                        Invoiced For
                    </div>
                    <div>
                        {{$bill->particular}}
                    </div>
                    <div class="sm-title mt-3">
                        Invoiced Amount
                    </div>
                    <div>
                        {{$bill->amount}}
                    </div>




                </div>
                <div class="col-md-6 text-left text-md-right">
                    <div class="sm-title ">
                        Invoiced Date
                    </div>
                    <div>
                        {{$bill->created_at->format('jS M, Y')}}
                    </div>
                </div>

            </div>
            <datalist id="payment_gateways">
                <option value="Esewa">Esewa</option>
                <option value="Khalti">Khalti</option>
            </datalist>
            <form action="" method="post">
                @csrf
                <table class="table table-bordered mt-5">
                    <thead>
                        <tr>
                            <td class="text-center"><strong>Transaction Date</strong></td>
                            <td class="text-center"><strong>Gateway</strong></td>
                            <td class="text-center"><strong>Transaction ID</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center p-0">
                                <input type="date" name="paid_date" id="paid_date" class="form-control" value="{{$bill->paid_date}}" required>

                            </td>
                            <td class="text-center p-0">
                                <input list="payment_gateways" type="text" name="gateway" id="gateway" placeholder="Payment Gateway" required class="form-control" value="{{$bill->gateway}}">

                            </td>
                            <td class="text-center p-0">
                                <input type="text" name="txn_id" id="txn_id" class="form-control" placeholder="Transaction ID" value="{{$bill->txn_id}}">
                            </td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="text-right">
                    @if ($bill->type==1)
                    <span>
                        @if ($bill->vendor->active!=1)
                            <input type="checkbox" name="activate" id="activate" value="1" class="mr-2">
                            <label for="activate">Activate Vendor</label>
                        @endif
                        <button class="btn ml-2 btn-success">{{($bill->gateway!=null||$bill->gateway!='')?'Update':'Save'}} Payment</button>
                    </span>
                    @else
                    <span>
                        @if ($bill->product->active!=1)
                            <input type="checkbox" name="activate" id="activate" value="1" class="mr-2">
                            <label for="activate">Activate Product</label>
                        @endif
                        <button class="btn ml-2 btn-success">{{($bill->gateway!=null||$bill->gateway!='')?'Update':'Save'}} Payment</button>
                    </span>
                    @endif
                </div>
            </form>
        </div>
    </div>


@endsection
@section('script')

@endsection
