<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>{{ env('APP_NAME', '') }}</title>
    <style>
        body {
            background: #EFEFEF;
        }

        .main {
            border-radius: 10px;
            min-height: 100vh;
            margin: 20px 250px;
            padding: 50px;
        }
        .unpaid-title{
            color: #cf0000;
            text-align: center;
        }
        .paid-title{
            color: #00b818;
            text-align: center;
        }
        .unpaid{
            background:rgba(255, 149, 153, 0.2);border-radius:5px;
            padding: 15px;
            text-align: center;
            border: 1px solid rgba(146, 0, 5, 0.582);
            font-weight: 600;
        }

        .detail{
            color: #333333;
            font-size: 1rem;
            font-weight: 500;
        }
        .sm-title{
            color: #181818;
            font-weight: 600;
            font-size: 1.2rem;
        }

        @media(max-width:425px){
            .main{
                border-radius: 10px;
                min-height: 100vh;
                margin: 10px;
                padding: 10px;
            }
        }

    </style>
</head>

<body>
    @php
        $data=getSetting('minor');
        $payment=getSetting('payment');
    @endphp
    <div class="bg-white shadow main">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-center text-md-start pb-3 pb-md-0">
                    <img src="{{asset($data->logo)}}" class="w-50" alt="">
                    <h5>Invoice #{{$bill->id}}</h5>
                </div>
                <div class="col-md-6">
                    @if ($bill->paid)
                        <h4 class="paid-title">Paid</h4>

                    @else
                        <h4 class="unpaid-title">UNPAID</h4>
                        <div class="unpaid" >

                            You Can pay Bill Via  <br>
                            @foreach ($payment as $item)

                            {{$item->title}}: {{$item->id}} <br>
                            @endforeach
                            Reference Number: {{$bill->id}}
                        </div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="detail">
                <div class="row">
                    <div class="col-md-6">
                        <div class="sm-title text-center text-md-start ">
                            Invoiced To
                        </div>
                        <div class="text-center text-md-start pb-3 pb-md-0">
                            {{$user->name}}, <br>
                            {{$user->vendor->phone}}, <br>
                            {{$user->vendor->address}}, <br>
                            {{$user->vendor->city->name}}, Nepal
                        </div>

                        <div class="sm-title mt-3 text-center text-md-start">
                            Invoiced Date
                        </div>
                        <div class="text-center text-md-start pb-3 pb-md-0">
                            {{$bill->created_at->format('jS M, Y')}}
                        </div>


                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="sm-title">
                            Pay To
                        </div>
                        <div>
                            {{$data->company}}, <br>
                            {!!$data->address!!}
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table table-bordered">
                    <tr>
                        <th>Description</th>
                        <th class="w-25">Amount</th>
                    </tr>
                    <tr>
                        <td >{{$bill->particular}}</td>
                        <td >
                            Rs. {{$bill->amount}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end">Sub Total</td>
                        <td >
                            Rs. {{$bill->amount}}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end">Credit</td>
                        <td >
                            Rs. 0
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end">Total</td>
                        <td >
                            Rs. {{$bill->amount}}
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered mt-5">
                    <thead>
                        <tr>
                            <td class="text-center"><strong>Transaction Date</strong></td>
                            <td class="text-center"><strong>Gateway</strong></td>
                            <td class="text-center"><strong>Transaction ID</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">{{$bill->paid_date}}</td>
                            <td class="text-center">{{$bill->gateway}}</td>
                            <td class="text-center">{{$bill->txn_id}}</td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>


            </div>
        </div>
    </div>


</body>

</html>
