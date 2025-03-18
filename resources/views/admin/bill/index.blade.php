@extends('admin.layout.app')
@section('css-include')
    <link href="{{ asset('admin/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

@endsection
@section('page-option')
    <a type="button" class="btn btn-primary" href="{{ route('admin.vendor.add') }}">Add Vendor</a>
@endsection
@section('s-title')

    <li class="breadcrumb-item active">
        Bills
    </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">
            <table class="table" id="bills">
                <thead>
                    <tr>

                        <th>
                            #REF ID
                        </th>
                        <th>
                            Issued To
                        </th>
                        <th>
                            Particular
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
                </thead>
                <tbody>
                    @foreach ($bills as $bill)
                        <tr>
                            <th>
                                #{{ $bill->id }}
                            </th>
                            <th>
                                <a target="blank" href="{{ route('admin.vendor.detail', ['vendor' => $bill->vendor_id]) }}">
                                    {{ $bill->name }}
                                </a>
                            </th>
                            <th>
                                {{ $bill->particular }}
                            </th>
                            <th>
                                {{ $bill->date }}
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
                </tbody>
            </table>
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
