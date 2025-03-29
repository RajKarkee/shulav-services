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
                    <input type="hidden" name="parent_id" id="parent_id" value="{{$parent_id}}">
                    <div class="row">
                        <div class="col-md-4" id="addimage">
                            <input type="file" class="dropify" name="image" id="image" accept=".jpg,.jpeg,.png" data-default="">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="form-group d-none"  >
                                <label for="rate">Rate</label>
                                <input type="number" name="rate" id="rate" class="form-control" value="{{ isset($cat) ? $cat->rate : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea name="desc" id="desc" class="form-control" maxlength="160"></textarea>
                            </div>

                            <!-- Service Type Dropdown -->
                            <div class="form-group {{$parent_id?'d-none':''}}">
                                <label for="type">Service Type</label>
                                <select name="type" id="type" class="form-control type">

                                </select>
                            </div>

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
                cats.push(res.data);
                $('#data').append(render(res.data));

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
