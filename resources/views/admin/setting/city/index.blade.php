@extends('admin.layout.app')
@section('css-include')
    <link href="{{ asset('admin/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

@endsection
@section('page-option')
    <a type="button" class="btn btn-primary" href="{{route('admin.setting.city.add')}}">Add City</a>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item">Cities</li>
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
                    @foreach ($cities as $city)
                        <tr id="city-{{$city->id}}">
                            <td>
                                {{$city->name}}
                            </td>
                            <td>
                                <a href="{{route('admin.setting.city.location.index',['id'=>$city->id])}}">
                                    <i class="material-icons">location_on</i>

                                </a>
                                <a href="{{route('admin.setting.city.edit',['city'=>$city->id])}}" class="btn btn-sm btn-table">
                                    <i class="material-icons">edit</i>
                                </a>
                                <button onclick="del({{$city->id}})" class="btn btn-sm text-danger btn-table">
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

    <script src="{{asset('admin/plugins/DataTables/datatables.min.js')}}"></script>
    <script>
        var table;
        $(function () {
            table=$('#cities').DataTable({
                "columnDefs": [
                    { "sortable":false,"searchable": false, "targets": 1 }
                ]
            });
        });

        function del(id) {
            if(confirm('Do You Want To Delete City.')){
                block('#cities-holder');
                axios.post('{{route('admin.setting.city.delete')}}',{id:id})
                .then((res)=>{
                    unblock('#cities-holder');
                    if(res.data.status){
                        table
                        .row( $('#city-'+id).parents('tr') )
                        .remove()
                        .draw();
                        success('City Deleted Sucessfully');
                    }else{
                        error('Cannot Delete city,'+res.data.message);

                    }
                })
                .catch((err)=>{
                    unblock('#cities-holder');
                    error('Cannot Delete city,Please Try Again');
                });
            }
        }
    </script>
@endsection
