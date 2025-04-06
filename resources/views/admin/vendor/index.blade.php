@extends('admin.layout.app')
@section('css-include')
    <link href="{{ asset('admin/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

@endsection
@section('page-option')
    <a type="button" class="btn btn-primary" href="{{route('admin.vendor.add')}}">Add Seller</a>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Sellers</li>
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
                        <th>
                            City
                        </th>
                        <th>
                            Category
                        </th>

                        <th>
                            Email
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Status
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                    @php
                        $city = \App\Models\City::where('id',$vendor->city_id)->first(['name']);
                        $category = \App\Models\Category::where('id',$vendor->category_id)->first(['name','active']);
                        $user = \App\Models\User::find($vendor->user_id);
                    @endphp
                    <tr>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$city->name}}
                        </td>
                        <td>
                            {{$category->name}}
                        </td>

                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$vendor->phone}}
                        </td>
                        <td>
                            {{$category->active==1?'Active':'InActive'}}
                        </td>
                        <td>
                            <a href="{{route('admin.vendor.detail',['vendor'=>$vendor->id])}}" class="btn btn-success">Detail</a>
                        </td>
                        {{-- <td>
                            {{$vendor->address}}
                        </td> --}}
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
                    { "sortable":false,"searchable": false, "targets": 6 }
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
