@extends('admin.layout.app')

@section('page-option')
@endsection
@section('s-title')
    <li class="breadcrumb-item">Change Password</li>
@endsection
@section('content')
<style>
      .form-control{
            border-radius: 5px;
        }
</style>
    <div class="bg-white">
        <div class="card-body">
            <form method="POST" id="changepass" action="{{ route('admin.password') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="old">Old Password</label>
                        <input type="password" name="old" id="old" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <div id="password-error"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="password_confirm">Confirm Password</label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        <div id="password_confirm-error"></div>

                    </div>
                    <div class="col-12 py-3">
                        <button class="btn btn-success">Change Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#changepass').submit(function(e) {
            $('#password-error').html('');
            $('#password_confirm-error').html('');
            if ($('#password').val() != $('#password_confirm').val())  {
                e.preventDefault();
                $('#password-error').html('Please Confirm Password');
                $('#password_confirm-error').html('Please Confirm Password');
            }

        });
    </script>
@endsection
