<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Quotation</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
    font-size: 15.96px;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Ensure body takes full height of the viewport */
        }

        .header {
            text-align: center;
            margin-top: 2px;
            padding-bottom: 5px;

        }

        .footer {
       
            position: absolute;
            margin-top: auto;
            margin-bottom: 5%
            width: 100%;
        }

        .invoice-details {
            position: absolute;

            right: 0;
            margin-top: 5px;
            text-align: right;
        }

        .customer-details,
        {
        margin-top: 2px;
        }



        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
            border: 1px solid #333;
            /* Adds border around the entire table */
        }

        .item-table th,
        {
        padding: 8px;
        text-align: center;
        border: 1px solid #333;

        }

        .item-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #333;

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
    

        {{-- <h1>Sales Quotation</h1> --}}
    <div class="invoice-details">

        <table>
            <tbody>
                <tr>
                    <td></td>
                    
                    <td colspan="2"  style="font-weight: bold; font-size: 25px; width: 100%;">Sales Quotation</td>
                </tr>

                <tr>
                    <td>Date</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $quoteDate }}</td>
                </tr>
                <tr>
                    <td>Quotation No</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $code }}</td>
                </tr>
                <tr>
                    <td>Payment Terms</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $paymentMethod }}</td>
                </tr>
                <tr>
                    <td>Validity Period</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $validityPeriod }}</td>
                </tr>
                <tr>
                    <td>Valid To</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $dueDate }}</td>
                </tr>
                <tr>
                    <td>Contact No</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $contactNumber }}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="customer-details">


        <table>
            <tbody>
                <tr>
                    <td colspan="3">
                        <h3>Submited To </h3>
                    </td>
                </tr>
                @foreach ($customerdetails as $customer)
                    <tr>
                        <td>Company Name</td>
                        <td style="text-align: center">:</td>
                        <td style="font-weight: bold">{{ $customer->company }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td style="text-align: center">:</td>
                        <td style="word-wrap: break-word; white-space: pre-wrap; max-width: 300px; font-weight: bold">{{ $customer->address }}</td>
                    </tr>
                    <tr>
                        <td>Attention</td>
                        <td style="text-align: center">:</td>
                        <td style="font-weight: bold" > {{ $customer->name }}</td>
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


                    <td style="width: 25%; border: 1px solid #333; padding: 8px; text-align: left;">
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
                            alt="Image for {{ $quoteitem['itemcode'] }}" style="width: 150px; height: 150px;" /></td>

                    <td>{{ $quoteitem['qty'] }}</td>
                    <td>{{ number_format($quoteitem['unitprice'], 2) }}</td>
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
                                echo number_format($subtotal, 2);
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
                                echo number_format($subtotal, 2);
                            @endphp
                        @endif

                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>




    <br>
    <br>
    <br>
    <br>

    
</body>
<footer style="position: absolute; bottom: 0;">


                    <img src="{{ public_path('images/Picture2.jpg') }}" alt="Sample Image"
                        style="width: 150px; height: 60px;">
               
                    <img src="{{ public_path('images/Udyogi.png') }}" alt="Sample Image"
                        style="width: 150px; height: 60px;">
              
                    <img src="{{ public_path('images/honeywell.png') }}" alt="Sample Image"
                        style="width: 150px; height: 60px;">
                
                    <img src="{{ public_path('images/3m.png') }}" alt="Sample Image"
                        style="width: 150px; height: 45px;">
            
</footer>

</html>
