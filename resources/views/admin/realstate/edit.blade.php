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
                <form id="editform">
                    @csrf
                    <input type="hidden" name="id" id="eid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">City</label>
                                        <select name="city_id" id="ecity_id" class="form-control">
                                            <option></option>
                                            @foreach (App\Models\City::all() as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Location</label>
                                    <select name="location_id" id="elocation_id" class="form-control">


                                    </select>
                                </div>
                            </div>


                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" id="ename" class="form-control" >
                             </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input type="number" name="rate" id="erate" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        <input type="number" name="contact" id="econtact" class="form-control" >
                                    </div>
                                </div>
                             </div>

                             <div class="form-group">
                                 <label for="desc">Description</label>
                                 <textarea name="desc" id="edesc" class="form-control" maxlength="160"></textarea>
                             </div>

                        </div>
                        <div class="col-md-4" id="editimage">
                            <input type="file" class="dropify" name="featureimg" id="eimage" data-default="">

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
        $('#ecity_id').on('change',function(){
        //    alert($('#city_id').val());
             var loc =  $('#elocation_id').val();
           axios.post('{{ route('admin.realstates.location') }}',{city_id:$('#ecity_id').val()})
                    .then((res) => {
                        // console.log(res.data);
                        if(loc != null){

                        }

                        $('#elocation_id').empty();
                        $('#elocation_id').append('<option></option>');
                        res.data.forEach(e => {
                            $('#elocation_id').append('<option value='+e.id+'>'+e.name+'</option>');
                        });
                    })
                    .catch((err) => {

                        toastr.error("Please Try Again.")
                        console.log(err);
                });
        });

        function showEdit(id){

            $('#editmodal').modal('show');
            $('#editimage').html('');
            let data = $('#restaurant-'+id)[0].dataset;
            $('#ecity_id').val(data.city).change();
            $('#eid').val(id);
            $('#ename').val(data.name);
            $('#erate').val(data.rate);
            $('#edesc').html(data.desc);
            $('#econtact').val(data.contact)
            $('#elocation_id').val(data.location).change();
            // console.log(data);
            $('#editimage').html('<input type="file" class="dropify" name="logo" id="eimage" data-default-file="'+data.image+'">');
            $('#eimage').dropify();

        }

         function update(){
            const fd=new FormData(document.getElementById('editform'));
            $('#editmodal').block({message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'});
            axios.post('{{route('admin.realstates.update')}}',fd)
            .then((res)=>{

                toastr.success('Updated Successfully')
                document.getElementById('editform').reset();
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
