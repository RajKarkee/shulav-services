<div class="modal fade bd-example-modal-lg" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edittitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editform">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input type="hidden" id="ecategory_id" name="category_id" value="">
                            <input type="hidden" id="eid" name="id" value="">
                            <input type="hidden" id="estate" name="state" value="1">
                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" id="ename" class="form-control" >
                             </div>
                             <div class="form-group">
                                <label for="rate">Rate</label>
                                <input type="number" name="rate" id="erate" class="form-control" >
                            </div>
                             <div class="form-group">
                                 <label for="desc">Description</label>
                                 <textarea name="desc" id="edesc" class="form-control" maxlength="160"></textarea>
                             </div>

                        </div>
                        <div class="col-md-4" id="editimage">
                            <input type="file" class="" name="image" id="eimage" data-default="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editsave" onclick="update()">Update Category</button>
            </div>
        </div>
    </div>
</div>
@section('script2')
    <script >
        function showEdit(_state,id){
            $('#editmodal').modal('show');
            $('#edittitle').text('Edit '+(_state==1?'Category':'Service'));
            $('#editsave').text('Update '+(_state==1?'Category':'Service'));
            $('#estate').val(_state);
            // $('#category_id').val(_state==1?0:cat_id);
            $('#editimage').html('');
            let data;
            if(_state==1){
                data=$('#cat-'+id)[0].dataset;
            }else{
                data=$('#service-'+id)[0].dataset;

            }
            $('#eid').val(data.id);
            $('#ename').val(data.name);
            $('#erate').val(data.rate);
            $('#edesc').html(data.desc);
            console.log(data);
            $('#editimage').html('<input type="file" class="dropify" name="image" id="eimage" data-default-file="'+data.image+'">');
            $('#eimage').dropify();

            state=_state;
        }
         function update(){
            const name=$('#ename').val();
            if(name==''){
                alert('Please Enter '+ (state==1?'Category':'Service') +' Name');
                return;
            }
            const fd=new FormData(document.getElementById('editform'));
            $('#editmodal').block({message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'});
            axios.post('{{route('admin.setting.category.update')}}',fd)
            .then((res)=>{
                console.log(res);
                const id=$('#eid').val();
                if(state==1){
                    $('#cat-'+id).replaceWith(res.data);
                }else{
                    $('#service-'+id).replaceWith(res.data);
                }
                document.getElementById('editform').reset();
                $('#editmodal').modal('hide');
                $('#editimage .dropify-clear')[0].click();
                $('#editmodal').unblock();

            })
            .catch((err)=>{
                $('#editmodal').unblock();
                toastr.error('Cannot Update '+(state==1?'Category':'Service')+" Please Try Again.")
                console.log(err);
            });
        }
    </script>
@endsection
