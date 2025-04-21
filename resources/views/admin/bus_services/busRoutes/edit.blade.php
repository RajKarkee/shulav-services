<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Bus Route</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_from_location">From</label>
                                <select name="from_location_id" id="edit_from_location" class="form-control" required>
                                    <option value="">Select Departure Location</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_to_location">To</label>
                                <select name="to_location_id" id="edit_to_location" class="form-control" required>
                                    <option value="">Select Destination Location</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_bus_type">Bus Type</label>
                        <select name="bus_type_id" id="edit_bus_type" class="form-control" required>
                            <option value="">Select Bus Type</option>
                            @foreach ($busTypes as $busType)
                                <option value="{{ $busType->id }}">{{ $busType->bus_type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_distance">Distance (km)</label>
                        <input type="number" name="distance" id="edit_distance" class="form-control" step="0.01"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="edit_estimated_time">Estimated Travel Time (hours)</label>
                        <input type="number" name="estimated_time" id="edit_estimated_time" class="form-control"
                            step="0.5" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_fare">Base Fare</label>
                        <input type="number" name="fare" id="edit_fare" class="form-control" step="0.01"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateRoute()">Update Route</button>
            </div>
        </div>
    </div>
</div>
