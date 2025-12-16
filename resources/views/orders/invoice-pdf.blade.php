<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            /* font-size: 15px; */

        }

        .header {
            text-align: center;

        }

        .invoice-details {
            position: absolute;

            right: 0;

            text-align: right;
            font-size: 14px;


        }

        .customer-details,
        {
        position: absolute;
        /* margin-top: 1px; */
        left: 0;
            font-size: 14px;
        text-align: left;
        }



        .item-table {
            width: 100%;
            font-size: 14px;

            margin-top: 135px;
        }

        .item-table th,
        .item-table td {

            padding: 8px;

        }


        .total {
            font-weight: bold;
        }

        .label {
    vertical-align: top;
    white-space: nowrap;
}

.colon {
    vertical-align: top;
    text-align: center;
    width: 10px;
}

.value {
    vertical-align: top;
    max-width: 280px;
    word-wrap: break-word;
    word-break: break-word;
}
.tr {
    border-bottom: 8px solid transparent;
    line-height: 1.4;
}
.row {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
    align-items: flex-start;
}
.footerTable {
            font-size: 14px;

}

    </style>
</head>
<header>
    <table>
        <tbody>
           
            <tr>
               
                    
              
                <td style="width: 40%;">
                    <img src="{{ public_path('images/logo.jpg') }}" alt="Sample Image" style="width: 75px; height: auto;">
                </td>

                <td style="width: 500%;  text-align: left; padding-left: 20px;">
                    <h1 style="margin: 0; font-weight: bold; font-size: 25px; font-family; 'Bodoni MT Black', serif;">{{ $companydetails['company_name'] }}</h1>
                    <h6 style="margin: 0;">{{ $companydetails['address'] }}
                    </h6>
                    <h6 style="margin: 0;">Email: {{ $companydetails['email'] }} | Mobile: {{ $companydetails['phone_number'] }}</h6>
                    <h6 style="margin: 0;">Business Reg. No: {{ $companydetails['brregistration'] }}</h6>
                </td>
            </tr>
        </tbody>
    </table>
</header>

<body>
<div class="row">
    <div style="margin-top: 5px">
        <div style="text-align: right; font-size: 17px;">

            <b>Invoice</b>
        </div>
        <div class="invoice-details" style="margin-top: 0;">
            <table>
                <tbody>

                    @foreach ($orderbills as $index => $orderbill)
                        <tr>
                            <td style="text-align: right">Invoice No</td>
                            <td style="text-align: center">:</td>
                            <td>SS/{{ str_pad($orderbill['id'], 4, '0', STR_PAD_LEFT) }}</td>
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
                        <tr class="tr">
                            <td class="label">Customer Name</td>
                            <td class="colon">:</td>
                            <td class="value">{{ $customer->company }}</td>
                        </tr>

                        <tr class="tr">
                            <td class="label">Address</td>
                            <td class="colon">:</td>
                            <td class="value">
                                {{ $customer->address }}
                            </td>
                        </tr>

                        <tr class="tr">
                            <td class="label">Delivery Address</td>
                            <td class="colon">:</td>
                            <td class="value">
                                {{ $deliveryAddress }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
    @php
        $subtotal = 0;
        $totalamount = 0;
        $totaldiscount = 0;
    @endphp
    <div class="row">
 <table class="item-table">
        <thead>
            <tr>
                <th style="text-align: left">Item Code</th>
                <th style="text-align: left">Description</th>
                <th></th>
                <th>Qty</th>
                <th style="text-align: right">Unit Price</th>
                <th style="text-align: center">Discount(%)</th>
                <th style="text-align: right">Amount</th>
            </tr>
        </thead>
        <tbody>
           
            @foreach ($orderitems as $index => $orderitem)
                <tr>

                    <td>{{ $orderitem->stock->code }}</td>
                    <td style="text-align: left">
                        {{ $orderitem->stock->name }}


                    </td>
                    <td>{{ $orderitem['sizes'] }}</td>
                    <td style="text-align: center">{{ $orderitem['quantity'] }}</td>
                    <td style="text-align: right">{{ number_format($orderitem['unit_price'], 2) }}</td>
                    <td style="text-align: center">{{ $orderitem['discount'] }}</td>
                    <td style="text-align: right">
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
            <tr>
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
                <td></td>
                <td>


                </td>
            </tr>

            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">Total</td>
                <td style="text-align: right">
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
    </div>
   






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
<footer style="position: fixed; bottom: 0; width: 100%;">
    <table style="width: 100%;" class="footerTable">
        <tbody>
            <!-- Row for Authorized and Customer Signature -->
            <tr>
                <td style="width: 50%; text-align: left;">
                    <div style="margin-left: 50px;"> <!-- Align content to the left -->
                        <p>..................................</p>
                        <p>Authorized</p>
                    </div>
                </td>
                <td style="width: 50%; text-align: right;">
                    <div style="margin-right: 50px;"> <!-- Align content to the right -->
                        <p>..................................</p>
                        <p>Customer Signature</p>
                    </div>
                </td>
            </tr>
            <!-- Row for Notes -->
            <tr>
                <td colspan="2" style="text-align: center;">
                    <div style="margin: 0 auto; width: 80%;"> <!-- Center align the content -->
                        <p style="font-size: 9.64px;">
                            ALL PAYMENTS/ CHEQUES TO BE DRAWN IN FAVOR OF “{{ $companydetails['company_name'] }}” AND CROSSED “ACCOUNT
                            PAYEE ONLY.”
                            For exchange, please submit the goods along with the invoice within 7 working days.
                        </p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</footer>

</html>
