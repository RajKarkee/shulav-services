<div class="modal fade bd-example-modal-lg" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" ></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="modal-body">
                <form id="eaddform">
                    @csrf
                    <input type="hidden" name="id" id="eid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="restro">Restaurent</label>
                                <select name="restaurant_id" id="erestaurant_id" class="form-control">
                                    <option></option>
                                    @foreach (App\Models\Restaurant::all() as $r)
                                        <option value="{{$r->id}}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" id="ename" class="form-control" required>
                             </div>

                             <div class="form-group">
                                <label for="rate">Rate</label>
                                <input type="number" name="rate" id="erate" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label for="time"> Deliver Time (In Min.)</label>
                                <input type="number" min="1" name="timetodeliver" id="etimetodeliver" class="form-control" >
                            </div>

                             <div class="form-group">
                                 <label for="desc">Description</label>
                                 <textarea name="desc" id="edesc" class="form-control" maxlength="160"></textarea>
                             </div>

                        </div>
                        <div class="col-md-4" id="editimage">
                            <input type="file" class="dropify" name="logo" id="eimage" data-default="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editsave" onclick="update()">Update Restaurant</button>
            </div>
        </div>
    </div>
</div>
@section('script2')
    <script >
        function showEdit(id){
            $('#editmodal').modal('show');
            $('#editimage').html('');
            let data = $('#menu-'+id)[0].dataset;
            $('#eid').val(id);
            $('#ename').val(data.name);
            $('#erate').val(data.rate);
            $('#etimetodeliver').val(data.deliver);
            $('#erestaurant_id').val(data.restro).change();
            $('#edesc').html(data.desc);
            // console.log(data);
            $('#editimage').html('<input type="file" class="dropify" name="logo" id="eimage" data-default-file="'+data.image+'">');
            $('#eimage').dropify();


        }
         function update(){
            const fd=new FormData(document.getElementById('eaddform'));
            $('#editmodal').block({message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'});
            axios.post('{{route('admin.restaurant.menu.update')}}',fd)
            .then((res)=>{

                toastr.success('Updated Successfully')
                document.getElementById('eaddform').reset();
                $('#editmodal').modal('hide');
                $('#editimage .dropify-clear')[0].click();
                $('#editmodal').unblock();
                loadData();

            })
            .catch((err)=>{
                $('#editmodal').unblock();
                toastr.error('Cannot Update Please Try Again.')
                console.log(err);
            });
        }
    </script>
@endsection
