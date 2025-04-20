@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection
@section('page-option')
    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showAdd()">Add Route</button>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Bus</li>
    <li class="breadcrumb-item">Bus Service</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Bus Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="data">
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.bus_services.busRoutes.add')
    @include('admin.bus_services.busRoutes.edit')
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
        integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Initialize dropify and load data on page load
        $(document).ready(function() {
            $('.dropify').dropify();
            loadData();
        });

        // API Routes
        const routes = {
            delete: '{{ route('admin.busServices.busRoutes.delete') }}',
            add: '{{ route('admin.busServices.busRoutes.add') }}',
            edit: '{{ route('admin.busServices.busRoutes.edit') }}',
            update: '{{ route('admin.busServices.busRoutes.update') }}'
        };

        // CRUD Functions
        function loadData() {
            axios.get('{{ route('admin.busServices.busRoutes.loadData') }}')
                .then(res => {
                    if (res.data.status) {
                        let html = '';
                        if (res.data.routes.length > 0) {
                            res.data.routes.forEach(route => {
                                html += `<tr>
                                    <td>${route.from_location?.location_name ?? 'N/A'}</td>
                                    <td>${route.to_location?.location_name ?? 'N/A'}</td>
                                    <td>${route.bus_type?.bus_type_name ?? 'N/A'}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" onclick="editData(${route.id})">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="delData(${route.id})">Delete</button>
                                    </td>
                                </tr>`;
                            });
                        } else {
                            html = `<tr>
                                <td colspan="5" class="text-center">No Bus Services found</td>
                            </tr>`;
                        }
                        $('#data').html(html);
                    } else {
                        toastr.error("Failed to load data");
                    }
                })
                .catch(err => {
                    toastr.error("Please Try Again.");
                    console.error(err);
                });
        }

        function delData(id) {
            if (confirm('Are you sure you want to delete this route?')) {
                axios.post(routes.delete, {
                        id
                    })
                    .then(() => {
                        toastr.success('Route Deleted Successfully');
                        loadData();
                    })
                    .catch(err => {
                        toastr.error("Please Try Again.");
                        console.error(err);
                    });
            }
        }

        function showAdd() {
            $('#addModal').modal('show');
        }

        function saveRoute() {
            const formData = new FormData(document.getElementById('addForm'));

            axios.post(routes.add, formData)
                .then(res => {
                    if (res.data.status) {
                        toastr.success('Route Added Successfully');
                        $('#addModal').modal('hide');
                        document.getElementById('addForm').reset();
                        loadData();
                    } else {
                        toastr.error(res.data.message);
                    }
                })
                .catch(handleAxiosError);
        }

        function editData(id) {
            axios.post(routes.edit, {
                    id
                })
                .then(res => {
                    if (res.data.status) {
                        const route = res.data.route;
                        // Map route data to form fields
                        const fields = [
                            'id', 'from_location', 'to_location', 'bus_type',
                            'distance', 'estimated_time', 'fare', 'description'
                        ];

                        fields.forEach(field => {
                            const fieldId = field === 'id' ? field : field + '_id';
                            $(`#edit_${field}`).val(route[fieldId] || route[field]);
                        });

                        $('#editModal').modal('show');
                    } else {
                        toastr.error(res.data.message);
                    }
                })
                .catch(err => {
                    toastr.error("Please Try Again.");
                    console.error(err);
                });
        }

        function updateRoute() {
            const formData = new FormData(document.getElementById('editForm'));

            axios.post(routes.update, formData)
                .then(res => {
                    if (res.data.status) {
                        toastr.success('Route Updated Successfully');
                        $('#editModal').modal('hide');
                        loadData();
                    } else {
                        toastr.error(res.data.message);
                    }
                })
                .catch(handleAxiosError);
        }

        // Helper function for error handling
        function handleAxiosError(err) {
            if (err.response?.data?.errors) {
                const errors = err.response.data.errors;
                Object.values(errors).forEach(error => {
                    toastr.error(error[0]);
                });
            } else {
                toastr.error("Please Try Again.");
            }
            console.error(err);
        }
    </script>
@endsection
