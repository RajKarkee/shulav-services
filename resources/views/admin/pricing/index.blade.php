@extends('admin.layout.app')
@section('css-include')
    <style>
        .fw-bolder{
            font-weight: 700;
        }
        .form-control{
            border-radius: 5px !important;
        }
    </style>
@endsection
@section('page-option')
@endsection
@section('s-title')

    <li class="breadcrumb-item active">
        Pricing
    </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 fw-bolder">Amount</div>
                <div class="col-md-4 fw-bolder">Days</div>
                <div class="col-md-4 fw-bolder"></div>
            </div>
            <hr>
            <form action="{{route('admin.pricing.add')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4"><input required type="number" name="price" id="price" class="form-control"></div>
                    <div class="col-md-4"><input required type="number" name="days" id="days" class="form-control"></div>
                    <div class="col-md-4"><button class="btn btn-primary">Add Pricing</button></div>
                </div>
            </form>
            @foreach ($pricings as $pricing)
            
            <hr>
            <form action="{{route('admin.pricing.edit',['pricing'=>$pricing->id])}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4"><input required type="number" value="{{$pricing->price}}" name="price" id="price-{{$pricing->id}}" class="form-control"></div>
                    <div class="col-md-4"><input required type="number" value="{{$pricing->days }}" name="days" id="days-{{$pricing->id}}" class="form-control"></div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">Update </button>
                        <a href="{{route('admin.pricing.del',['pricing'=>$pricing->id])}}" class="btn btn-danger" onclick="return prompt('Enter yes to delete')=='yes';">Delete</a>
                    </div>
                </div>
            </form>
            @endforeach

        </div>
    </div>


@endsection
@section('script')
   
@endsection
