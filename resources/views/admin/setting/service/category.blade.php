@extends('admin.layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection

@section('page-option')
    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showAdd(1)">Add Category</button>
@endsection

@section('s-title')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item">Services Categories</li>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="data">
                    @foreach ($cats as $cat)
                        <tr data-id="{{$cat->id}}" data-name="{{$cat->name}}" data-type="{{$cat->type}}" data-rate="{{$cat->rate}}" data-desc="{{$cat->desc}}" data-image="{{asset($cat->image)}}" id="cat-{{$cat->id}}">
                            <td>
                                <img src="{{ asset($cat->image) }}" style="max-width: 100px" alt="">
                            </td>
                            <td>{{$cat->name}}</td>
                            <td>{{$cat->rate}}</td>
                            <td>
                                @switch($cat->type)
                                    @case(1) Normal @break
                                    @case(2) Hotel & Restaurant @break
                                    @case(3) Bus Ticket @break
                                    @case(4) Plane Ticket @break
                                    @case(5) Vehicle Rent @break
                                    @default N/A
                                @endswitch
                            </td>
                            <td style="width: 35%">{{$cat->desc}}</td>
                            <td class="btn-table">
                                <button class="btn mt-1 btn-secondary btn-sm" onclick="showEdit(1, {{$cat->id}})">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button class="btn mt-1 btn-sm btn-danger text-danger" onclick="del(1, {{$cat->id}})">
                                    <i class="material-icons">delete</i>
                                </button>
                                <a href="{{route('admin.setting.category.category', ['cat'=>$cat->id])}}" class="btn mt-1 btn-success btn-sm">
                                    <i class="material-icons">list</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('admin.setting.service.add')
    @include('admin.setting.service.edit')
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>

    <script>
        var state = 1;
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        function del(_state, id) {
            state = _state;
            if ($('.service-' + id).length > 0 && state == 1) {
                if (!confirm('This Category Contains Services, Do You Still Want to Delete Category?')) {
                    return;
                }
            }
            if (confirm('Do You Want To Delete ' + (state == 1 ? 'Category' : 'Service') + '?')) {
                $('body').block();
                axios.post('{{route('admin.setting.category.delete')}}', { id: id, state: _state })
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success((state == 1 ? 'Category' : 'Service') + " Deleted Successfully.");
                            $('#' + (state == 1 ? 'cat-' : 'service-') + id).remove();
                        }
                        $('body').unblock();
                    })
                    .catch((err) => {
                        $('body').unblock();
                        toastr.error('Cannot Delete ' + (state == 1 ? 'Category' : 'Service') + ". Please Try Again.");
                    });
            }
        }
    </script>
@endsection
