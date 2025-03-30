@extends('admin.layout.app')
@section('s-title')
    <li class="breadcrumb-item">Front Page Section</li>
@endsection
@section('content')
    <div class="bg-white p-4 shadow">
        <form action="{{ route('admin.frontPageSection.index') }}" method="POST" onsubmit="saveSection(this,event)">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label for="section_name">Section Name</label>
                    <input type="text" name="section_name" class="form-control" id="section_name"
                        placeholder="Section Name">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="design_type">Design Type</label>
                    <select name="design_type" id="design_type" class="form-control">
                        <option value="1">Type 1</option>
                        <option value="2">Type 2</option>
                        <option value="3">Type 3</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label for="position">Position</label>
                    <input type="number" name="position" id="position" class="form-control">
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
                        <th>Section Name</th>
                        <th>Design Type</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="section-list">
                    @foreach ($sections as $section)
                        <tr>
                            <td>{{ $section->section_name }}</td>
                            <td>{{ $section->design_type }}</td>
                            <td>{{ $section->position }}</td>

                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#editModal{{ $section->id }}">Edit</button>
                                <div class="modal fade" id="editModal{{ $section->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="editModalLabel{{ $section->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $section->id }}">Edit Section
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('admin.frontPageSection.edit', ['section_id' => $section->id]) }}"
                                                    method="POST" id="editForm{{ $section->id }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="section_name{{ $section->id }}">Section Name</label>
                                                        <input type="text" name="section_name" class="form-control"
                                                            id="section_name{{ $section->id }}"
                                                            value="{{ $section->section_name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="design_type{{ $section->id }}">Design Type</label>
                                                        <select name="design_type" id="design_type{{ $section->id }}"
                                                            class="form-control">
                                                            <option value="1"
                                                                {{ $section->design_type == 1 ? 'selected' : '' }}>Type 1
                                                            </option>
                                                            <option value="2"
                                                                {{ $section->design_type == 2 ? 'selected' : '' }}>Type 2
                                                            </option>
                                                            <option value="3"
                                                                {{ $section->design_type == 3 ? 'selected' : '' }}>Type 3
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="position{{ $section->id }}">Position</label>
                                                        <input type="number" name="position"
                                                            id="position{{ $section->id }}" class="form-control"
                                                            value="{{ $section->position }}">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="updateSection({{ $section->id }})">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.frontPageSection.del', ['section_id' => $section->id]) }}"
                                    class="btn btn-sm btn-danger">Delete</a>
                                <a href="{{ route('admin.frontPageSection.product.index', ['section_id' => $section->id]) }}"
                                    class="btn btn-sm btn-info">Manage Products</a>
                            </td>
                        </tr>
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
