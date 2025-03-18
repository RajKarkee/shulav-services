@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
    <style>
        .col-md-3 {
            margin-bottom: 10px;
        }

        label {
            font-weight: 600;
            font-size: 1.1rem;
            /* margin-bottom: 5px; */
            color: black;
            margin-top: 5px;
        }

        .form-control,
        .tox {
            border-radius: 5px !important;
        }

    </style>
@endsection
@section('page-option')
<button type="button" class="btn btn-primary" onclick="initAdd(0);">
    Add New Type
  </button>
  
@endsection
@section('s-title')
    <li class="breadcrumb-item active">
        Team Types
    </li>
@endsection
@section('content')

    <div class="bg-white shadow mb-3">
        <div class="card-body">
                @foreach ($types as $type)
                    <div class="mb-2">
                        <div class="shadow p-2">

                            <form class=" p-2" action="{{route('admin.team.type.edit',['type'=>$type->id])}}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-7">

                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" value="{{$type->name}}" name="name" id="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">

                                        <div class="h-100 pb-3 d-flex justify-content-start align-items-end">
                                            <button class="ml-2 btn btn-secondary">Update</button>
                                            <a  href="{{route('admin.team.index',['type'=>$type->id])}}"   class="ml-2 btn btn-success">Manage</a>
                                            <a onclick="return prompt('Enter yes To Continue.')=='yes';" href="{{route('admin.setting.gallery.type.del',['type'=>$type->id])}}" class="ml-2 btn btn-danger">Del</a>
                                        </div>
                                    </div>
                                </div>
                               
                            </form>
                            {{-- <div class="p-3">

                                <div class=" shadow " id="child-{{$type->id}}">
                                    <h5 class="p-2 d-flex align-items-center justify-content-between">
                                        <span class="fw-bolder">Child Types</span>
                                        <button class="btn btn-primary" onclick="initAdd({{$type->id}})">Add Child Type</button>
                                    </h5>
                                    <hr class="m-0">
                                    <div class="p-2">
                                        @foreach ($type->childs as $child)
                                        <form class=" p-2" action="{{route('admin.team.type.edit',['type'=>$child->id])}}" enctype="multipart/form-data" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-7">
            
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" value="{{$child->name}}" name="name" id="name" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
            
                                                    <div class="h-100 pb-3 d-flex justify-content-start align-items-end">
                                                        <button class="ml-2 btn btn-secondary">Update</button>
                                                        <a  href="{{route('admin.team.index',['type'=>$child->id])}}"   class="ml-2 btn btn-success">Manage</a>
                                                        <a onclick="return prompt('Enter yes To Continue.')=='yes';" href="{{route('admin.team.type.del',['type'=>$child->id])}}" class="ml-2 btn btn-danger">Del</a>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
        </div>
    </div>


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addModalLabel">Add Team Type</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form class="pb-3" action="{{route('admin.team.type.add')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="parent_id" id="parent_id" value="0">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                  
                    <div class="py-2">
                        <button class="btn btn-primary">Add team Type</button>
                    </div>
                </form>
            </div>          
          </div>
        </div>
      </div>
@endsection
@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.photo').dropify();
        });
        function initAdd(val) {
            $('#parent_id').val(val);
            $('#addModal').modal('show');
        }
    </script>
@endsection
