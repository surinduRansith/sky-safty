<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Quotation</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-top: 10px;
            padding-bottom: 10px;

        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .invoice-details {
            position: absolute;
            top: 80px;
            right: 0;
            width: 210px;
            height: 100px;
        }

        .customer-details,
        .item-details {
            margin-top: 10px;
        }

        .invoice-details {
            margin-top: 200px;
            text-align: right;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 1px solid #333;
            /* Adds border around the entire table */
        }

        .item-table th,
        .item-table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #333;

        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">

        <table>
            <tbody>
                <tr>
                    <td style="width: 40%;">
                        <img src="{{ public_path('images/logo.jpg') }}" alt="Sample Image"
                            style="width: 150px; height: auto;">
                    </td>

                    <td style="width: 500%;  text-align: left; padding-left: 20px;">
                        <h1 style="margin: 0; font-weight: bold;">Sky Safety Equipment</h1>
                        <p style="margin: 0;">No 70/7, Robert Gunawardana Mw, Thalangama South, Battaramulla, Sri Lanka
                        </p>
                        <p style="margin: 0;">Email: skysafetyequipment@gmail.com | Mobile: 0768 459 499</p>
                        <p style="margin: 0;">Business Reg. No: WD 21641</p>
                    </td>
                </tr>
            </tbody>
        </table>


        <h1>Sales Quotation</h1>
    </div>
    <div class="invoice-details">

        <table>
            <tbody>

                <tr>
                    <td>Quotation No</td>
                    <td>:</td>
                    <td>{{ $code }}</td>
                </tr>
                <tr>
                    <td>Quotation Date</td>
                    <td>:</td>
                    <td>{{ $quoteDate }}</td>
                </tr>
                <tr>
                    <td>Payment Terms</td>
                    <td>:</td>
                    <td>{{ $method }}</td>
                </tr>
                <tr>
                    <td>Payment Due</td>
                    <td>:</td>
                    <td>{{ $dueDate }}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="customer-details">

        <h2>Submit To </h2>
        <table>
            <tbody>
                @foreach ($customerdetails as $customer)
                    <tr>
                        <td>Customer Name</td>
                        <td>:</td>
                        <td>{{ $customer->company }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td>{{ $customer->address }}</td>
                    </tr>
                    <tr>
                        <td>Attention</td>
                        <td>:</td>
                        <td>{{ $customer->name }}</td>
                    </tr>
                    <tr>



                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @php
        $subtotal = 0;
        $totalamount = 0;
        $totaldiscount = 0;
    @endphp
    <table class="item-table">
        <thead>
            <tr>

                <th>ITEM DESCRIPTION</th>
                <th>IMAGES</th>
                <th>QTY</th>
                <th>UNIT PRICE</th>
                <th>DISCOUNT</th>
                <th>NET VALUE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quotationitems as $index => $quoteitem)
                <tr>


                    <td style="width: 20%; border: 1px solid #333; padding: 8px; text-align: left;">
                        <ul>
                            <li>{{ $quoteitem['itemcode'] }}</li>
                            @foreach (explode("\n", $quoteitem['description']) as $line)
                                {{ $line }}
                            @endforeach

                            @php
                                $allSizes = [];
                                $allSizesLetters = [];
                            @endphp

                            @foreach ($quoteitem['sizes'] as $size)
                                @if (ctype_digit($size['size']))
                                    @php
                                        $allSizes[] = $size['size'];
                                    @endphp
                                @else
                                    @php
                                        $allSizesLetters[] = $size['size'];
                                    @endphp
                                @endif
                            @endforeach
                            @if (count($allSizesLetters) > 0)
                                <p>Size: {{ implode(', ', $allSizesLetters) }}</p> {{-- Display all sizes in one line --}}
                            @endif

                            @if (count($allSizes) > 0)
                                @php
                                    $minSize = min($allSizes);
                                    $maxSize = max($allSizes);
                                @endphp
                                <br>
                                Size: {{ $minSize }}-{{ $maxSize }}
                            @endif


                        </ul>
                    </td>

                    <td><img src="{{ public_path('storage/' . $quoteitem['image']) }}"
                            alt="Image for {{ $quoteitem['itemcode'] }}" style="width: 200px; height: 200px;" /></td>

                    <td>{{ $quoteitem['qty'] }}</td>
                    <td>Rs.{{ $quoteitem['unitprice'] }}</td>
                    <td>{{ $quoteitem['discount'] }}</td>
                    <td>
                        @if ($quoteitem['discount'] > 0)
                            @php

                                $subtotal =
                                    (float) $quoteitem['qty'] * (float) $quoteitem['unitprice'] -
                                    ((float) $quoteitem['qty'] *
                                        (float) $quoteitem['unitprice'] *
                                        (float) $quoteitem['discount']) /
                                        100;
                                echo 'Rs. ' . $subtotal;
                                $totalamount +=
                                    (float) $quoteitem['qty'] * (float) $quoteitem['unitprice'] -
                                    ((float) $quoteitem['qty'] *
                                        (float) $quoteitem['unitprice'] *
                                        (float) $quoteitem['discount']) /
                                        100;
                            @endphp
                        @else
                            @php

                                $subtotal = (float) $quoteitem['qty'] * (float) $quoteitem['unitprice'];
                                $totalamount += (float) $quoteitem['qty'] * (float) $quoteitem['unitprice'];
                                echo 'Rs. ' . $subtotal;
                            @endphp
                        @endif

                    </td>
                </tr>
            @endforeach


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


        <p>ALL PAYMENTS/ CHEQUES TO BE DRAWN IN FAVOR OF “Sky Safety Equipment” AND CROSSED “ACCOUNT PAYEE ONLY.”

            For exchange, please submit the goods along with the invoice within 7 working days.</p>
    </div> --}}
</body>

</html>
