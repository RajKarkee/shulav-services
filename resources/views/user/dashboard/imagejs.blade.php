<script src="{{ asset('front/js/rcrop.min.js') }}"></script>
<script>
    var data;

    function initEdit() {
        $('#second-selector-image').show();
        $('#first-selector-image').hide();

        $('#image-resize').width($('#image-holder').width());
        $('#image-resize').attr('src', result);
        // $('#image-display').attr('src', e.target.result);
        // $('#image-display').parent().addClass('loaded');

        $('#image-resize').on('rcrop-changed', function() {
            data = $(this).rcrop('getDataURL');
        });
        $('#image-resize').rcrop({
            minSize: [200, 200],
            preserveAspectRatio: true,
            // preview: {
            //     display: true,
            //     size: [100, 100],
            // }
        });
        $('#image-input').val('');
    }


    function readURL(input) {
        $('#image-holder').html('<img src="" id="image-resize" alt="" >');
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                result = e.target.result;
                initEdit();
            };
            reader.readAsDataURL(input.files[0]);
        } else {

        }
    }

    $("#image-input").change(function() {
        readURL(this);
    });

    $('#cancel-image').click(function(e) {
        $('#second-selector-image').hide();
        $('#first-selector-image').show();
        $('#image-holder').html('<img src="" id="image-resize" alt="" >');

    });
    $('#next-image').click(function(e) {
        e.preventDefault();
        data = $('#image-resize').rcrop('getDataURL');
        $('#second-selector-image').hide();
        $('#first-selector-image').show();
        // $(selector).css(propertyName, value);
        $('#overlay-image-spinner').css('display','flex');
        document.getElementById('image-display').src=data;
        $('img.profile-image').each(function (index, element) {
            element.src=data;

        });
        fetch(data)
            .then(res => res.blob())
            .then((_data) => {
                console.log(_data, 'blob');
                var fd = new FormData();
                fd.append('image', _data);
                axios.post("{{ route('user.change-image') }}", fd)
                    .then((res) => {
                        $('#overlay-image-spinner').hide();

                    })
                    .catch((err) => {
                        $('#overlay-image-spinner').hide();

                    });
            })


    });
</script>
