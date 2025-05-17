@extends('admin.layout.app')
@section('s-title')
    <li class="breadcrumb-item">E-Ticketing</li>
    <li class="breadcrumb-item">Locations</li>
@endsection
@section('content')
    <div class="bg-white p-4 shadow">
        <form action="{{ route('admin.busServices.location.add') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label for="Location_name">Location Name</label>
                    <input type="text" name="location_name" class="form-control" id="section_name"
                        placeholder="location_name">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="Latitude">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="latitude" placeholder="Enter latitude">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="Longitude">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="longitude"
                        placeholder="Enter longitude">
                </div>



                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary" type="submit">
                        Save
                    </button>
                </div>
            </div>
        </form>

    </div>
    <div class="card shadow mt-2">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Location Name</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="section-list">
                    @foreach ($locations as $location)
                        <tr>
                            <td>{{ $location->location_name }}</td>
                            <td>{{ $location->latitude }}</td>
                            <td>{{ $location->longitude }}</td>
                            <td><a href="{{ route('admin.busServices.location.del', ['location' => $location->id]) }}"
                                    class="btn btn-sm btn-danger">Delete</a>

                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function saveSection(form, event) {
            event.preventDefault();
            const formData = new FormData(form);
            axios.post(form.action, formData)
                .then(function(response) {
                    location.reload();
                })
                .catch(function(error) {
                    console.error(error);
                });
        }

        function updateSection(sectionId) {
            const form = document.getElementById('editForm' + sectionId);
            const formData = new FormData(form);
            axios.post(form.action, formData)
                .then(function(response) {
                    $('#editModal' + sectionId).modal('hide');
                    location.reload();
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    </script>
@endsection
