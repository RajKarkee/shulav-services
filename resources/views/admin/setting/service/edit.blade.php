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
                        <div class="col-md-4" id="editimage">
                            <input type="file" class="" name="image" id="eimage" accept=".jpg,.jpeg,.png" data-default="">
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" id="eid" name="id" value="">
                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" id="ename" class="form-control" >
                             </div>
                             <div class="form-group">
                                 <label for="desc">Description</label>
                                 <textarea name="desc" id="edesc" class="form-control" maxlength="160"></textarea>
                             </div>
                             <div class="form-group">
                                <label for="type">Service Type</label>
                                <select name="type" id="etype" class="form-control type">

                                </select>
                            </div>

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
            $('#edittitle').text('Edit '+(_state==1?'Category':'Service'));
            $('#editsave').text('Update '+(_state==1?'Category':'Service'));
            $('#editimage').html('');

            let cat = cats.find(cat => cat.id == id);

            $('#eid').val(cat.id);
            $('#ename').val(cat.name);
            $('#edesc').val(cat.desc);
            $('#etype').val(cat.type);

            $('#editimage').html('<input type="file" class="dropify" name="image" id="eimage" data-default-file="/'+cat.image+'">');
            $('#eimage').dropify();

            $('#editmodal').modal('show');
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
                const updatedData = res.data;

                cats = cats.map(cat => {
                    if(cat.id==updatedData.id){
                        cat.name = updatedData.name;
                        cat.desc = updatedData.desc;
                        cat.type = updatedData.type;
                        cat.image = updatedData.image;
                    }
                    return cat;
                });

                $('#cat-'+updatedData.id).replaceWith(render(updatedData));
                toastr.success("Category Updated Successfully.");

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
