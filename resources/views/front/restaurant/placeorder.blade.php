@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">

@endsection
@section('title', 'Cart')
<style>
    .job-link{
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
                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                            <a href="{{ route('user.cart') }}">Cart</a>
                            <span>Place Order</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body">
                            <div class="row text-center p-2">
                                <form action="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for=""><Address></Address></label>
                                            <input type="text" id="address" class="form-control" placeholder="Enter Address">
                                        </div>
                                        <div class="col-md-4">
                                            <label for=""><Address></Address></label>
                                            <input type="text" id="address" class="form-control" placeholder="Enter Address">
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary">Place To Order Now</button>
                                        </div>

                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>



    </div>


<input type="text">
@endsection
@section('js')
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
<script>


       const retrievedObject = localStorage.getItem("cart");
            if (retrievedObject != undefined) {
               var carts = JSON.parse(retrievedObject);
               var tot=0;
               for (let index = 0; index < carts.length; index++) {
                const e = carts[index];
                $('#cartItem').append(`
                <tr id="cartitem-${e.id}">
                    <input type="hidden" id="name_${e.id}" value="${e.name}">
                    <input type="hidden" id="rate_${e.id}" value="${e.rate}">
                    <input type="hidden" id="qty_${e.id}" value="${e.qty}">
                    <input type="hidden" id="itemid_${e.id}" value="${e.id}">
                <td>${e.name}</td><td>${e.rate}</td>
                <td>${e.qty}</td><td>${e.rate*e.qty}</td><td>
                <span class="btn btn-danger btn-sm" onclick="removeItem(${e.id});">Remove</span>
                </td></tr>`);
                tot+=e.rate*e.qty;
                }
                $('#gtot').html(`<tr><th colspan="3" class="pull-right">Grand Total</th><th>${tot}</th><input type="</tr>`);

            //    array.forEach(e => {
            //        $('#cartItem').html('<tr><td>'e.name'</td></tr>');
            //    });

            }

            function removeItem(id){
                if(confirm('Are you sure')){
                    const retrievedObject = localStorage.getItem("cart");
                    if (retrievedObject != undefined) {
                        carts = JSON.parse(retrievedObject);
                        var gtot = parse$('#gtot').val();
                        const index=carts.findIndex(o=>o.id==id);
                        carts.splice(index,1);

                        // delete index.id;
                        localStorage.setItem('cart',JSON.stringify(carts));
                        $('#cartitem-'+id).remove();
                    }

                }
            }

</script>

@endsection
