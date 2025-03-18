<script>
    $('#edit-desc').click(function() {
        $('#first-selector-desc').addClass('active');
        $('#desc-input')[0].focus();
    });
    $('#cancel-desc').click(function() {
        $('#first-selector-desc').removeClass('active');
    });
    $('#next-desc').click(function(e) {
        e.preventDefault();
        data = $('#desc-input').val();
        axios.post("{{ route('vendor.change-desc') }}", {
                'desc': data
            })
            .then((res) => {
                $('#first-selector-desc').removeClass('active');


            })
            .catch((err) => {
                $('#first-selector-desc').removeClass('active');


            });
    });
</script>
