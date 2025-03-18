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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">City</label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option></option>
                                            @foreach (App\Models\City::all() as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Location</label>
                                    <select name="location_id" id="location_id" class="form-control">


                                    </select>
                                </div>
                            </div>


                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" id="name" class="form-control" >
                             </div>

                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rate">Rate</label>
                                        <input type="number" name="rate" id="rate" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        <input type="number" name="contact" id="contact" class="form-control" >
                                    </div>
                                </div>
                             </div>

                             <div class="form-group">
                                 <label for="desc">Description</label>
                                 <textarea name="desc" id="desc" class="form-control" maxlength="160"></textarea>
                             </div>

                        </div>
                        <div class="col-md-4" id="addimage">
                            <input type="file" class="dropify" name="featureimg" id="image" data-default="">
                            <br>
                            <label for="Gallery">Gallery Image</label>
                            <input type="file" class="dropify" name="gallery[]" multiple id="gallery" data-default="">
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

            const fd=new FormData(document.getElementById('addform'));
            $('#addmodal').block({message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'});
            axios.post('{{route('admin.realstates.index')}}',fd)
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

                toastr.error('invalid input');
                // console.log(err.response.data);
                // for (const key in err.response.data) {
                //     if (Object.hasOwnProperty.call( err.response.data, key)) {
                //         const element =  err.response.data[key];
                //         toastr.error(element);

                //         console.log(element);
                //     }
                // }

            });
        }

        $('#city_id').on('change',function(){
        //    alert($('#city_id').val());
           axios.post('{{ route('admin.realstates.location') }}',{city_id:$('#city_id').val()})
                    .then((res) => {
                        // console.log(res.data);
                        $('#location_id').empty();
                        $('#location_id').append('<option></option>');
                        res.data.forEach(e => {
                            $('#location_id').append('<option value='+e.id+'>'+e.name+'</option>');
                        });

                    })
                    .catch((err) => {

                        toastr.error("Please Try Again.")
                        console.log(err);
                });
        });
    </script>
@endsection
