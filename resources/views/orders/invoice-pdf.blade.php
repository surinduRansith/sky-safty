<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 15.96px;
            color: #333;
        }

        .header {
            text-align: center;   
        }

        .invoice-details {
            position: absolute;
            
            right: 0;
           
            text-align: right;

        }

        .customer-details,
         {
            position: absolute;
            margin-top: 50px;
            left: 0;
           
            text-align: left;
        }

        

        .item-table {
            width: 100%;

            margin-top: 160px;
        }

        .item-table th,
        .item-table td {

            padding: 8px;
            text-align: center;
        }


        .total {
            font-weight: bold;
        }
    </style>
</head>
<header>
    <table>
        <tbody>
            <tr>
                <td style="width: 40%;">
                    <img src="{{ public_path('images/logo.jpg') }}" alt="Sample Image"
                        style="width: 150px; height: auto;">
                </td>

                <td style="width: 500%;  text-align: left; padding-left: 20px;">
                    <h1 style="margin: 0; font-weight: bold;">Sky Safety Equipment</h1>
                    <h5 style="margin: 0;">No 70/7, Robert Gunawardana Mw, Thalangama South, Battaramulla, Sri Lanka
                    </h5>
                    <h5 style="margin: 0;">Email: skysafetyequipment@gmail.com | Mobile: 0768 459 499</h5>
                    <h5 style="margin: 0;">Business Reg. No: WD 21641</h5>
                </td>
            </tr>
        </tbody>
    </table>
</header>
<body>
    <div style="margin-top: 15px">
        <p style="font-weight: bold; font-size: 25px; width: 100%; text-align: right; margin-bottom: 5px;">Invoice</p>
        <div class="invoice-details" style="margin-top: 0;">
        <table>
            <tbody>
                
                @foreach ($orderbills as $index => $orderbill)
                    <tr>
                        <td style="text-align: right">Invoice No</td>
                        <td style="text-align: center">:</td>
                        <td>SS/{{ $orderbill['id'] }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right">Invoice Date</td>
                        <td style="text-align: center">:</td>
                        <td>{{ $orderbill['invoicedate'] }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right">Po No</td>
                        <td style="text-align: center">:</td>
                        <td>{{ $orderbill['ponumber'] }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right">Payment Terms</td>
                        <td style="text-align: center">:</td>
                        <td>{{ $orderbill['paymentmethod'] }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: right">Payment Due</td>
                        <td style="text-align: center">:</td>
                        <td>{{ $orderbill['duedate'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="customer-details">
        <table>
            <tbody>
                @foreach ($customerdetails as $customer)
                    <tr>
                        <td>Customer Name</td>
                        <td style="text-align: center">:</td>
                        <td>{{ $customer->company }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td style="text-align: center">:</td>
                        <td style="word-wrap: break-word; white-space: pre-wrap; max-width: 300px;">{{ $customer->address }}</td>
                    </tr>
                    <tr>
                        <td>Delivery Address</td>
                        <td style="text-align: center">:</td>
                        <td style="word-wrap: break-word; white-space: pre-wrap; max-width: 300px;">{{ $deliveryAddress }}</td>
                    </tr>
                    
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    @php
        $subtotal = 0;
        $totalamount = 0;
        $totaldiscount = 0;
    @endphp
    <table class="item-table">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Description</th>
                <th></th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderitems as $index => $orderitem)
                <tr>

                    <td>{{ $orderitem->stock->code }}</td>
                    <td>
                        {{ $orderitem->stock->name }}


                    </td>
                    <td>{{ $orderitem['sizes'] }}</td>
                    <td>{{ $orderitem['quantity'] }}</td>
                    <td>{{  number_format($orderitem['unit_price'], 2) }}</td>
                    <td>{{ $orderitem['discount'] }}</td>
                    <td>
                        @if ($orderitem['discount'] > 0)
                            @php

                                $subtotal =
                                    (float) $orderitem['quantity'] * (float) $orderitem['unit_price'] -
                                    ((float) $orderitem['quantity'] *
                                        (float) $orderitem['unit_price'] *
                                        (float) $orderitem['discount']) /
                                        100;
                                echo number_format($subtotal, 2);
                                $totalamount +=
                                    (float) $orderitem['quantity'] * (float) $orderitem['unit_price'] -
                                    ((float) $orderitem['quantity'] *
                                        (float) $orderitem['unit_price'] *
                                        (float) $orderitem['discount']) /
                                        100;
                            @endphp
                        @else
                            @php

                                $subtotal = (float) $orderitem['quantity'] * (float) $orderitem['unit_price'];
                                $totalamount += (float) $orderitem['quantity'] * (float) $orderitem['unit_price'];
                                echo number_format($subtotal, 2);
                            @endphp
                        @endif

                    </td>
                </tr>

                @php
                    $totaldiscount = $orderitem['total_discount'];
                @endphp
            @endforeach
            <tr >
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Discount</td>
                <td>
                    {{ $totaldiscount }}

                </td>
            </tr>

            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>
                    @if ($totaldiscount > 0)
                        @php

                            $totalamount = (float) $totalamount - ((float) $totalamount * (float) $totaldiscount) / 100;
                            echo number_format($totalamount, 2);
                        @endphp
                    @else
                       {{ number_format($totalamount, 2) }}
                    @endif


                </td>
            </tr>
        </tbody>
    </table>






    {{-- <div class="footer">

        <div style="text-align: center; margin-top: 50px;">
            <table>
                <tbody>
                    <tr>
                        <td style="width: 50%;">
                            <div style="margin-left: 70px; text-align: center"> <!-- Adjust margin as needed -->
                                <p>..................................</p>
                                <p>Authorized</p>
                            </div>
                        </td>
                        <td style="width: 50%;">
                            <div style="margin-left: 300px; text-align: center"> <!-- Adjust margin as needed -->
                                <p>..................................</p>
                                <p>Customer Signature</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <p style="font-size: 12px">ALL PAYMENTS/ CHEQUES TO BE DRAWN IN FAVOR OF “Sky Safety Equipment” AND CROSSED “ACCOUNT PAYEE ONLY.”

            For exchange, please submit the goods along with the invoice within 7 working days.</p>
    </div> --}}
</body>
<footer style="position: fixed; bottom: 0;">
  
    <table>
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <div style="margin-left: 70px; text-align: center"> <!-- Adjust margin as needed -->
                        <p>..................................</p>
                        <p>Authorized</p>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div style="margin-left: 300px; text-align: center"> <!-- Adjust margin as needed -->
                        <p>..................................</p>
                        <p>Customer Signature</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>



<p style="font-size: 12px; align-items: center">ALL PAYMENTS/ CHEQUES TO BE DRAWN IN FAVOR OF “Sky Safety Equipment” AND CROSSED “ACCOUNT PAYEE ONLY.”

    For exchange, please submit the goods along with the invoice within 7 working days.</p>
</footer>

</html>
