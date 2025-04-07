{{-- @extends('front1.index') {{-- or your main layout --}}

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div id="loginMessage"></div>
            <div class="card">
                <div class="card-header text-center">Login</div>
                <div class="card-body">
                    <form id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: "{{ route('User.login') }}",
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                window.location.href = response.redirect_url || "/";
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Login failed. Please check your credentials.';
                $('#loginMessage').html(`<div class="alert alert-danger">${errorMsg}</div>`);
            }
        });
    });
</script>
@endsection --}}
