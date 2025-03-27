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
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Ensure body takes full height of the viewport */
        }

        .header {
            text-align: center;
           
          

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
            position: absolute;
            margin-top: 1px;
            left: 0;
            text-align: left;
        }



        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top:180px;
            border: 1px solid #333;
            /* Adds border around the entire table */
        }

        .item-table th,
        .item-table td {
            font-size:14px;
            padding: 8px;
            border: 1px solid #333;
        }

        .total {
            font-weight: bold;
        }
    </style>
     <table>
        <tbody>
            <tr>
                <td style="width: 40%;">
                <img src="{{ public_path('images/logo.jpg') }}" alt="Sample Image"
     style="width: 100px; height: 100px; margin: 0; padding: 0; display: block;">

                </td>

                <td style="width: 500%;  text-align: left; padding-left: 20px;">
                    <h1 style="margin: 0; font-weight: bold;">Sky Safety Equipment</h1>
                    <h5 style="margin: 0;">No 70/7, Robert Gunawardana Mw, Thalangama South, Battaramulla, Sri Lanka
                    </h5>
                    <h5 style="margin: 0;">Email: skysafetyequipment@gmail.com | Mobile: 0768 459 499</h5>
                    <h5 style="margin: 0;">Business Reg. No: WD 21641</h5>
                </td>
                <td style=" padding-left: 50px;" >
                    
                <img src="{{ public_path('images/greateagle.webp') }}" alt="Sample Image"
                        style="width: 50px; height: 50px;">
               
                    <img src="{{ public_path('images/Udyogi.png') }}" alt="Sample Image"
                        style="width: 50px; height: 50px;">
              
                    <img src="{{ public_path('images/honeywell.png') }}" alt="Sample Image"
                        style="width: 50px; height: 50px;">
                
                    <img src="{{ public_path('images/3m.png') }}" alt="Sample Image"
                        style="width: 50px; height: 30px;">
    </td>
            </tr>
        </tbody>
    </table>
    


            

</head>

<body>
    

      <div style="text-align: right; font-size: 20px;">

          <b>Sales Quotation</b>
      </div>
    <div class="invoice-details" style="margin-top: 0;">
        <table>
            <tbody>
                <tr>
                    <td style="text-align: right">Date</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $quoteDate }}</td>
                </tr>
                <tr>
                    <td style="text-align: right">Quotation No</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $code }}</td>
                </tr>
                <tr>
                    <td style="text-align: right">Payment Terms</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $paymentMethod }}</td>
                </tr>
                <tr>
                    <td style="text-align: right">Validity Period</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $validityPeriod }}</td>
                </tr>
                <tr>
                    <td style="text-align: right">Valid To</td>
                    <td style="text-align: center">:</td>
                    <td>{{ $dueDate }}</td>
                </tr>
                <tr>
                    <td style="text-align: right">Contact No</td>
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
                        <td style="font-weight: bold">Company Name</td>
                        <td style="text-align: center">:</td>
                        <td>{{ $customer->company }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">Address</td>
                        <td style="text-align: center">:</td>
                        <td style="word-wrap: break-word; white-space: pre-wrap; max-width: 300px;height:60px">{{ $customer->address }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold">Attention</td>
                        <td style="text-align: center">:</td>
                        <td style="word-wrap: break-word; white-space: pre-wrap; max-width: 300px;"> {{ $customer->name }}</td>
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


                    <td style="width: 25%; border: 1px solid #333; padding: 8px; text-align: left;font-size: 14px;">
                        <ul>
                            <li>{{ $quoteitem['itemcode'] }}</li>
                           {{-- @foreach (explode("\n", $quoteitem['description']) as $line)
                                {{ $line }}
                            @endforeach --}}
			<p>{!! nl2br($quoteitem['description']) !!}</p>

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
    
</body>
<!-- <footer style="position: absolute; bottom: 0;">


                    <img src="{{ public_path('images/greateagle.webp') }}" alt="Sample Image"
                        style="width: 50px; height: 30px;">
               
                    <img src="{{ public_path('images/Udyogi.png') }}" alt="Sample Image"
                        style="width: 50px; height: 30px;">
              
                    <img src="{{ public_path('images/honeywell.png') }}" alt="Sample Image"
                        style="width: 50px; height: 30px;">
                
                    <img src="{{ public_path('images/3m.png') }}" alt="Sample Image"
                        style="width: 50px; height: 30px;">
            
</footer> -->

</html>
