@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection
@section('page-option')
    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showAdd()">Add Route</button>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Bus Routes</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>From</th>
                    <th>To</th>
                    <th>Bus Type</th>
                    <th>Description</th>
                    <th>Actions</th>
                </thead>
                <tbody id="data">
                    <!-- Data will be loaded here -->
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
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        $(window).on('load', function() {
            loadData();
        })

        function loadData() {
            axios.get('{{ route('admin.busServices.busRoutes.loadData') }}')
                .then((res) => {
                    $('#data').html(res.data);
                })
                .catch((err) => {
                    toastr.error("Please Try Again.")
                    console.log(err);
                });
        }

        function delData(id){
            if(confirm('Are you sure you want to delete this route?')){
                axios.post('{{ route('admin.busServices.busRoutes.delete') }}', {id:id})
                    .then((res) => {
                        toastr.success('Route Deleted Successfully')
                        loadData();
                    })
                    .catch((err) => {
                        toastr.error("Please Try Again.")
                        console.log(err);
                    });
            }
        }

        function showAdd() {
            $('#addModal').modal('show');
        }
    </script>
    <script>

        // Add these functions to your script section

function saveRoute() {
    let formData = new FormData(document.getElementById('addForm'));
    
    axios.post('{{ route('admin.busServices.busRoutes.add') }}', formData)
        .then((res) => {
            if (res.data.status) {
                toastr.success('Route Added Successfully');
                $('#addModal').modal('hide');
                document.getElementById('addForm').reset();
                loadData();
            } else {
                toastr.error(res.data.message);
            }
        })
        .catch((err) => {
            if (err.response && err.response.data && err.response.data.errors) {
                let errors = err.response.data.errors;
                for (let key in errors) {
                    toastr.error(errors[key][0]);
                }
            } else {
                toastr.error("Please Try Again.");
            }
            console.log(err);
        });
}

function editData(id) {
    axios.post('{{ route('admin.busServices.busRoutes.edit') }}', {id: id})
        .then((res) => {
            if (res.data.status) {
                let route = res.data.route;
                
                $('#edit_id').val(route.id);
                $('#edit_from_location').val(route.from_location_id);
                $('#edit_to_location').val(route.to_location_id);
                $('#edit_bus_type').val(route.bus_type_id);
                $('#edit_distance').val(route.distance);
                $('#edit_estimated_time').val(route.estimated_time);
                $('#edit_fare').val(route.fare);
                $('#edit_description').val(route.description);
                
                $('#editModal').modal('show');
            } else {
                toastr.error(res.data.message);
            }
        })
        .catch((err) => {
            toastr.error("Please Try Again.");
            console.log(err);
        });
}

function updateRoute() {
    let formData = new FormData(document.getElementById('editForm'));
    
    axios.post('{{ route('admin.busServices.busRoutes.update') }}', formData)
        .then((res) => {
            if (res.data.status) {
                toastr.success('Route Updated Successfully');
                $('#editModal').modal('hide');
                loadData();
            } else {
                toastr.error(res.data.message);
            }
        })
        .catch((err) => {
            if (err.response && err.response.data && err.response.data.errors) {
                let errors = err.response.data.errors;
                for (let key in errors) {
                    toastr.error(errors[key][0]);
                }
            } else {
                toastr.error("Please Try Again.");
            }
            console.log(err);
        });
}
        </script>
@endsection