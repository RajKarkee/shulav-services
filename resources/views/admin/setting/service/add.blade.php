<div class="modal fade bd-example-modal-lg" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addtitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addform">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" id="category_id" name="category_id" value="">
                            <input type="hidden" id="state" name="state" value="1">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="rate">Rate</label>
                                <input type="number" name="rate" id="rate" class="form-control" value="{{ isset($cat) ? $cat->rate : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea name="desc" id="desc" class="form-control" maxlength="160"></textarea>
                            </div>

                            <!-- Service Type Dropdown -->
                            <div class="form-group">
                                <label for="service_id">Service Type</label>
                                <select name="service_id" id="service_id" class="form-control">
                                    <option value="">Select Service Type</option>
                                    <option value="1">Normal Service</option>
                                    <option value="2">Hotel & Restaurants</option>
                                    <option value="3">Bus Ticket</option>
                                    <option value="4">Plane Ticket</option>
                                    <option value="5">Vehicle Rent</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-4" id="addimage">
                            <input type="file" class="dropify" name="image" id="image" data-default="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addsave" onclick="addSave()">Save Category</button>
            </div>
        </div>
    </div>
</div>
@section('script1')
    <script >
        function showAdd(_state,cat_id){
            $('#addmodal').modal('show');
            $('#addtitle').text('Add New '+(_state==1?'Category':'Service'));
            $('#addsave').text('Add '+(_state==1?'Category':'Service'));
            $('#state').val(_state);
            $('#category_id').val(_state==1?0:cat_id);

            state=_state;
        }
         function addSave(){
            const name=$('#name').val();
            if(name==''){
                alert('Please Enter '+ (state==1?'Category':'Service') +' Name');
                return;
            }
            const fd=new FormData(document.getElementById('addform'));
            $('#addmodal').block({message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'});
            axios.post('{{route('admin.setting.category.add')}}',fd)
            .then((res)=>{
                console.log(res);
                const cat_id=$('#category_id').val();
                $('#data').append(res.data);

                // if(state==1){

                //     $('#all').append(res.data);
                // }else{
                //     $('#services-'+cat_id).append(res.data);

                // }
                document.getElementById('addform').reset();
                $('#rate').val({{ isset($cat)?$cat->rate:'0'}});
                $('#addmodal').modal('hide');
                $('#addimage .dropify-clear')[0].click();
                $('#addmodal').unblock();

            })
            .catch((err)=>{
                $('#addmodal').unblock();
                toastr.error('Cannot Add '+(state==1?'Category':'Service')+" Please Try Again.")
                console.log(err);
            });
        }
    </script>
@endsection
