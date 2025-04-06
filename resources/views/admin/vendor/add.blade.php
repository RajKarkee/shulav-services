@extends('admin.layout.app')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
<style>
    .form-control {
        padding: 0.355rem 0.755rem;
    }
    .col-md-6, .col-md-3 {
        padding-bottom: 0.5rem;
    }
</style>
@endsection

@section('page-option')
@endsection

@section('s-title')
    <li class="breadcrumb-item"><a href="{{ route('admin.vendor.index') }}">Sellers</a></li>
    <li class="breadcrumb-item">Add</li>
@endsection

@section('content')
@php
    $cities = explode(',', $data[0]->cities);
    $categories = explode(',', $data[0]->categories);
@endphp

<div class="card shadow">
    <div class="card-body">
        <form id="add-vendor" action="{{ route('admin.vendor.add') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3 pb-3">
                    <input type="file" name="image" id="image" class="dropify">
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3 pb-3">
                            <label for="city_id">City</label>
                            <select name="city_id" id="city_id" class="form-control">
                                @foreach($cities as $c)
                                    @php [$id, $name] = explode(':', $c); @endphp
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 pb-3">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach($categories as $a)
                                    @php [$id, $name] = explode(':', $a); @endphp
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <input type="checkbox" onchange="checkOrg(this);" name="is_org" id="is_org" value="1">
                            <label for="is_org"><strong>Is Organization</strong></label>
                            <hr>
                        </div>

                        <div class="col-md-6">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="address">Street Address</label>
                            <input type="text" name="address" id="address" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="dob" id="dob_label">Date Of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control">
                        </div>
                        <div class="col-md-3" id="gender-holder">
                            <label for="gender" id="gender_label">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                                <option value="2">Other</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <label for="desc">Description</label>
                            <textarea name="desc" id="desc" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12 py-3">
                            <button class="btn btn-primary">Save Seller</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
<script>
    var state = false;
    function checkOrg(ele) {
        document.getElementById('dob_label').innerHTML = ele.checked ? 'Established Date' : 'Date Of Birth';
        if (ele.checked) {
            $('#gender-holder').addClass('d-none');
        } else {
            $('#gender-holder').removeClass('d-none');
        }
    }

    $(document).ready(function() {
        $('.dropify').dropify();
        $('#add-vendor').submit(function(e) {
            e.preventDefault();
            if (!state) {
                state = true;
                let form = document.getElementById('add-vendor');
                block('#add-vendor');
                let fd = new FormData(form);
                axios.post($(form).attr('action'), fd)
                    .then((res) => {
                        form.reset();
                        toastr.success('Vendor Added Successfully');
                        state = false;
                        unblock('#add-vendor');
                    })
                    .catch((err) => {
                        unblock('#add-vendor');
                        state = false;
                        toastr.error('Vendor cannot be added, ' + err.response.data.message);
                    });
            }
        });
    });
</script>
@endsection
