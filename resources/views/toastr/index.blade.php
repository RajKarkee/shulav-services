<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            };
</script>
@if (Session::has('message') || Session::has('error') || Session::has('warning') || Session::has('info'))
    <script>
        @if (Session::has('message'))
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
@endif
