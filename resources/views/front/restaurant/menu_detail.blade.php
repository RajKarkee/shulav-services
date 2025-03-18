@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">

@endsection
@section('title', 'Menu Details')

<style>
    .job-link {
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
    }
</style>
@section('content')

    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <a href="{{ route('user.restaurant.index') }}">Restaurant</a>
                            <span>{{ $menu->name }} - Detail</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="/{{ $menu->logo }}" alt="" style="height: 200px; width:280px;">
                                </div>
                                <div class="col-md-8">
                                    <strong>{{ $menu->name }}</strong>
                                    <input type="hidden" id="name" value="{{ $menu->name }}">
                                    <input type="hidden" id="id" value="{{ $menu->id }}">
                                    <input type="hidden" id="rate" value="{{ $menu->rate }}">

                                    <div>
                                        Rs. {{ $menu->rate }}
                                    </div>
                                    <p> Deliver Approximate time : {{ $menu->timetodeliver }} Min.</p>
                                    <div class="qty">
                                        <span class="btn btn-primary btn-sm" onclick="qtyUpdate(-1)">-</span><input
                                            type="text" class="text-center" name="qty" value="1" min="1"
                                            id="qty" style="width:50px; border:none;" readonly><span
                                            class="btn btn-primary btn-sm " onclick="qtyUpdate(1)">+</span>
                                    </div>
                                    <hr>
                                    <span class="btn btn-warning" onclick="addToCart();">Add To Cart</span>
                                    <br><br>
                                    <p>{{ $menu->desc }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



    </div>



@endsection
@section('js')
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')

    <script>
        var carts;

        function qtyUpdate(val) {
            let qty = parseInt($('#qty').val());
            if (val == -1) {
                if (qty != 1) {
                    $('#qty').val(qty - 1);
                } else {
                    $('#qty').val(1);
                }
            } else {
                if (qty == 5) {
                    $('#qty').val(5);
                } else {
                    let tot = parseInt(qty + 1);
                    $('#qty').val(tot);
                }
            }
        }


        function addToCart() {

            const qty = parseInt($('#qty').val());
            const name = $('#name').val();
            const rate =parseInt( $('#rate').val());
            const id = $('#id').val()

            carts = [];
            const retrievedObject = localStorage.getItem("cart");
            if (retrievedObject != undefined) {
                carts = JSON.parse(retrievedObject);

            }
            const item = {
                name: name,
                qty: qty,
                rate: rate,
                id: id
            };

            const oldItem=carts.find(o=>o.id==id);
            const index=carts.findIndex(o=>o.id==id);
            if(oldItem!=null){
                if(carts[index].qty == 5){
                    alert('Sorry your order qty is over.');
                    return;
                }else{
                    carts[index].qty += parseInt(item.qty);
                    carts[index].rate = item.rate;
                }
            }else{
                carts.push(item);
            }

            localStorage.setItem("cart", JSON.stringify(carts));
            // console.log(carts);
            alert('Item added to cart');
        }
    </script>

@endsection
