<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>{{ env('APP_NAME', '') }}</title>
    <style>
        body {
            background: #EFEFEF;
        }

        .main {
            border-radius: 10px;
            min-height: 100vh;
            /* margin: 20px 250px; */
            padding: 20px;
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

        .text-center{
            text-align: center;
        }
        
        .w-50{
            width:50%;
        }
        .shadow{
            box-shadow:0px 0px 8px 0px rgba(0,0,0,0.15);
        }
        .card-body{
            padding:30px;
        }

    
        th{
            text-align: start;
        }

     
        .table{
            width:100%;
            border-collapse: collapse;
            
        }

        .table, tr, th,td{
            border: 1px solid #cccccc;
        }

        th,td{
            padding: 5px;
        }
        .text-end{
            text-align: end;
        }

        .text-md-start{
            text-align: start;
        }
        
        @media(max-width:425px){
            .col-md-6{
                width:100%;
            }
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
            <div class="">
                <div class="">
                    <img src="{{asset($data->logo)}}" class="w-50" alt="">
                    <h5>Invoice #{{$bill->id}}</h5>
                </div>
                <div >
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
                <div class="">
                    <div >
                        <div class="sm-title text-center text-md-start ">
                            Invoiced To
                        </div>
                        <div class="text-center text-md-start pb-3 pb-md-0">
                            {{$user->name}}, <br>
                            {{$user->vendor->phone}}, <br>
                            {{$user->vendor->address}}, <br>
                            {{$user->vendor->city->name}}, Nepal
                        </div>
                        <br>
                        <div class="sm-title mt-3 text-center text-md-start">
                            Invoiced Date
                        </div>
                        <div class="text-center text-md-start pb-3 pb-md-0">
                            {{$bill->created_at->format('jS M, Y')}}
                        </div>


                    </div>
                    <br>
                    <div class="">
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



            </div>
        </div>
    </div>


</body>

</html>
