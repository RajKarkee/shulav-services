@extends('admin.layout.app')
@section('css-include')
    <link href="{{ asset('admin/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

@endsection
@section('page-option')
    {{-- <a type="button" class="btn btn-primary" href="{{ route('admin.vendor.add') }}">Add Vendor</a> --}}
@endsection
@section('s-title')

    <li class="breadcrumb-item active">
        Payment Details
    </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>Reference Id</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($payments as $pay)
                            <tr>
                                <td>#{{$pay->job_id}}</td>
                                <td><a href="{{ route('admin.payment.store',$pay->id) }}" onclick="return confirm('Are you sure?');" class="badge badge-primary">Accept Payment</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script src="{{ asset('admin/plugins/DataTables/datatables.min.js') }}"></script>
    <script>
        var table;
        $(function() {
            table = $('#bills').DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "searchable": false,
                    "targets": 7
                }]
            });
        });
    </script>
@endsection
