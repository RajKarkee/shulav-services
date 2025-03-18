@extends('admin.layout.app')
@section('css-include')
    <link href="{{ asset('admin/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('page-option')
    <a type="button" target="_blank" class="btn btn-primary"
        href="{{ route('admin.setting.city.location.add', ['id' => $city->id]) }}">Add location in {{ $city->name }}</a>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.setting.city.index') }}">
            Cities
        </a>
    </li>
    <li class="breadcrumb-item">{{ $city->name }}</li>
    <li class="breadcrumb-item">Locations</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body" id="cities-holder">
            <table class="table bordered" id="cities">
                <thead>
                    <tr>

                        <th>
                            Name
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $location)
                        <tr id="location-{{ $location->id }}">
                            <td>
                                {{ $location->name }}
                            </td>
                            <td>
                                <a href="{{ route('admin.setting.city.location.edit', ['location' => $location->id]) }}"
                                    class="btn btn-sm btn-table" target="_blank">
                                    <i class="material-icons">edit</i>
                                </a>
                                <button onclick="del({{ $location->id }})" class="btn btn-sm text-danger btn-table">
                                    <i class="material-icons">delete</i>
                                </button>
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
            table = $('#cities').DataTable({
                "columnDefs": [{
                    "sortable": false,
                    "searchable": false,
                    "targets": 1
                }]
            });
        });

        function del(id) {
            if (confirm('Do You Want To Delete City.')) {
                block('#cities-holder');
                axios.post('{{ route('admin.setting.city.location.delete') }}', {
                        id: id
                    })
                    .then((res) => {
                        unblock('#cities-holder');
                        if (res.data.status) {
                            table
                                .row($('#location-' + id).parents('tr'))
                                .remove()
                                .draw();
                            success('Location Deleted Sucessfully');
                        } else {
                            error('Cannot delete location,' + res.data.message);

                        }
                    })
                    .catch((err) => {
                        unblock('#cities-holder');
                        error('Cannot delete location,Please Try Again');
                    });
            }
        }
    </script>
@endsection
