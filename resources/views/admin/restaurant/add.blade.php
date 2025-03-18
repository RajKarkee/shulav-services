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

                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" id="name" class="form-control" >
                             </div>

                             <div class="form-group">
                                 <label for="desc">Description</label>
                                 <textarea name="desc" id="desc" class="form-control" maxlength="160"></textarea>
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
                <button type="button" class="btn btn-primary" id="addsave" onclick="addSave()">Save Restaurant</button>
            </div>
        </div>
    </div>
</div>
@section('script1')
    <script >
        function showAdd(){
            $('#addmodal').modal('show');

        }
         function addSave(){
            const name=$('#name').val();
            if(name==''){
                alert('Please Enter Name');
                return;
            }
            const fd=new FormData(document.getElementById('addform'));
            $('#addmodal').block({message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'});
            axios.post('{{route('admin.restaurant.index')}}',fd)
            .then((res)=>{

                toastr.success('Added Successfully')
                document.getElementById('addform').reset();

                $('#addmodal').modal('hide');
                $('#addimage .dropify-clear')[0].click();
                $('#addmodal').unblock();
                loadData();
            })
            .catch((err)=>{
                $('#addmodal').unblock();
                toastr.error("Please Try Again.")
                console.log(err);
            });
        }
    </script>
@endsection
