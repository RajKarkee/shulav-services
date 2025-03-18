@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection
@section('page-option')
    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showAdd()">Add New</button>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Realstates</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <th>
                        Image
                    </th>
                    <th>
                        Name
                    </th>

                    <th>
                        Contact
                    </th>
                    <th>
                        Rate
                    </th>
                    <th>

                    </th>
                </thead>
                <tbody id="data">

                </tbody>
            </table>
        </div>
    </div>
    @include('admin.realstate.add')
    @include('admin.realstate.edit')
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
        integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var state = 1;
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        function searchService(ele) {
            $('.cat').each(function(index, element) {
                let can = false;


                $('.service-' + element.dataset.id).each(function(index, element1) {
                    if (element1.dataset.name.toLowerCase().startsWith(ele.value.toLowerCase())) {
                        $(element1).removeClass('d-none');
                        can = true;
                    } else {
                        $(element1).addClass('d-none');
                    }
                });

                if (element.dataset.name.toLowerCase().startsWith(ele.value.toLowerCase()) || can) {
                    $(element).removeClass('d-none');
                } else {
                    $(element).addClass('d-none');
                }

            });
        }

        function searchCategory(ele) {
            $('.cat').each(function(index, element) {
                let can = false;

                if (element.dataset.name.toLowerCase().startsWith(ele.value.toLowerCase())) {
                    $(element).removeClass('d-none');
                } else {
                    $(element).addClass('d-none');
                }
                $('.service').each(function(index, element) {


                });

            });
        }

        $(window).on('load', function() {
            loadData();
        })

        function loadData() {
                axios.get('{{ route('admin.realstates.loadData') }}')
                    .then((res) => {

                        $('#data').html(res.data);

                    })
                    .catch((err) => {

                        toastr.error("Please Try Again.")
                        console.log(err);
                    });
            }

       function delData(id){
        if(confirm('Are you sure ?')){
            axios.post('{{ route('admin.restaurant.delete') }}',{id:id})
                .then((res) => {
                    toastr.success('Delete Successfully')
                    loadData();
                })
                .catch((err) => {

                    toastr.error("Please Try Again.")
                    console.log(err);
                });
        }

       }


    </script>
@endsection
