<script>
    $('#edit-name').click(function() {
        $('#first-selector-name').addClass('active');
        $('#name-input')[0].focus();
    });
    $('#cancel-name').click(function() {
        $('#first-selector-name').removeClass('active');
    });
    $('#next-name').click(function(e) {
        e.preventDefault();
        data = $('#name-input').val();
        axios.post("{{ route('user.change-name') }}", {
                'name': data
            })
            .then((res) => {
                $('#first-selector-name').removeClass('active');


            })
            .catch((err) => {
                $('#first-selector-name').removeClass('active');


            });
    });
</script>
