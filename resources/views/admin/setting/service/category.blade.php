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
    @if ($parent)
        <li class="breadcrumb-item">{{$parent->name}}</li>
        <li class="breadcrumb-item">Sub Category</li>
    @endif
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th>Image</th> --}}
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="data">

                </tbody>
            </table>
        </div>
    </div>

    @include('admin.setting.service.add')
    @include('admin.setting.service.edit')

    <textarea id="cats" class="d-none">@json($cats)</textarea>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>

    <script>
        const serviceTypes = @json(\App\Helper::serviceTypes);
        var cats=[];
        var state = 1;
        $(document).ready(function() {
            $('.dropify').dropify();
            cats = JSON.parse($('#cats').val());
            $('#cats').remove();
            for (const key in serviceTypes) {
                if (Object.prototype.hasOwnProperty.call(serviceTypes, key)) {
                    const value = serviceTypes[key];
                    $('.type').append(`<option value="${key}">${value}</option>`);
                    // $('#etype').append(`<option value="${key}">${value}</option>`);
                }
            }

            $('#data').html(cats.map(cat => render(cat)).join(''));
        });

        function render(cat){
            const subURL = "{{ route('admin.setting.category.index') }}";
            return `<tr id="cat-${cat.id}">

                        <td>${cat.name}</td>
                        <td>
                            ${serviceTypes[cat.type]}
                        </td>
                        <td style="width: 35%">${cat.desc}</td>
                        <td class="btn-table">
                            <button class="btn mt-1 btn-secondary btn-sm" onclick="showEdit(1, ${cat.id})">
                                <i class="material-icons">edit</i>
                            </button>
                            <button class="btn mt-1 btn-sm btn-danger text-danger" onclick="del(1, ${cat.id})">
                                <i class="material-icons">delete</i>
                            </button>
                            <a href="${subURL}?parent_id=${cat.id}" class="btn mt-1 btn-success btn-sm">
                                <i class="material-icons">list</i>
                            </a>
                        </td>
                    </tr>`;

        }

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
