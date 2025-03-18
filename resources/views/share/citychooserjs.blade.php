<div id="city_chooser_{{ csrf_token() }}"></div>
<script>
    console.log('citiy chooser');
    const cityChoosen_str = localStorage.getItem('cityChoosen');
    var cityChoosen = 0;
    var x_city = null;

    function x_skip() {
        localStorage.setItem('cityChoosen', "2");
        $('#city_chooser_{{ csrf_token() }}').remove();

    }

    function x_chooseCity(id, name) {
        localStorage.setItem('cityChoosen', "1");
        localStorage.setItem('city', JSON.stringify({
            "id": id,
            "name": name
        }));
        $('#city_chooser_{{ csrf_token() }}').remove();


    }
    if (cityChoosen_str != null) {
        cityChoosen = parseInt(cityChoosen_str);
        if (cityChoosen == 1) {
            x_city = JSON.parse(localStorage.getItem("city"));
        }
    } else {
        $(document).ready(function() {
            console.log('init loading ');
            axios.get('chooseCity')
                .then((res) => {
                    $('#city_chooser_{{ csrf_token() }}').html(res.data);
                });
        });
    }
</script>
