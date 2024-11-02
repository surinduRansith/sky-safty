<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Invoice</title>
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

        .invoice-details{
            position: absolute;
            top: 80px;
            right: 0;
             width: 210px;
            height: 100px;
           
        }

         .customer-details, .item-details {
            margin-top: 10px;
        }
        .invoice-details {
            margin-top: 175px;
            text-align: right;
        }
        
        .item-table {
            width: 100%;
           
            margin-top: 40px;
        }
        .item-table th, .item-table td {
           
            padding: 8px;
            text-align: left;
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
                        <img src="{{ public_path('images/logo.jpg') }}" alt="Sample Image" style="width: 150px; height: auto;">
                    </td>
                    
                    <td style="width: 500%;  text-align: left; padding-left: 20px;">
                        <h1 style="margin: 0; font-weight: bold;">Sky Safety Equipment</h1>
                        <p style="margin: 0;">No 70/7, Robert Gunawardana Mw, Thalangama South, Battaramulla, Sri Lanka</p>
                        <p style="margin: 0;">Email: skysafetyequipment@gmail.com | Mobile: 0768 459 499</p>
                        <p style="margin: 0;">Business Reg. No: WD 21641</p>
                    </td>
                </tr>
            </tbody>
        </table>

     
        <h1>Invoice</h1>
    </div>
    <div class="invoice-details">
        <table>
            <tbody>
         @foreach ($orderbills as $index => $orderbill)
                <tr>
                   <td>Invoice No</td>
                   <td>:</td>
                   <td>SS/{{$orderbill['id']}}</td> 
                </tr>
                <tr>
                    <td>Invoice Date</td>
                    <td>:</td>
                    <td>{{$orderbill['invoicedate']}}</td> 
                 </tr>
                 <tr>
                    <td>Payment Terms</td>
                    <td>:</td>
                    <td>{{$orderbill['paymentmethod']}}</td> 
                 </tr>
                 <tr>
                    <td>Payment Due</td>
                    <td>:</td>
                    <td>{{$orderbill['duedate']}}</td> 
                 </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="customer-details">
        <table>
            <tbody>
         @foreach ($customerdetails as  $customer)
                <tr>
                   <td>Customer Name</td>
                   <td>:</td>
                   <td>{{$customer->company}}</td> 
                </tr>
                <tr>
                    <td>Address</td>
                    <td>:</td>
                    <td>{{$customer->address}}</td> 
                 </tr>
                 <tr>
                     <td>Delivery Addrewss</td>
                     <td>:</td>
          
                    <td>{{$deliveryAddress}}</td> 
            
                    
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
                <th>Item Code</th>
                <th>Description</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderitems as $index => $orderitem)
            
               
            <tr>

                <td>{{$orderitem->stock->code}}</td>
                <td>
                    {{$orderitem->stock->name}}
                
                
                </td>
                <td>{{$orderitem['sizes']}}</td>
                <td>{{$orderitem['quantity']}}</td>
                <td>Rs.{{$orderitem['unit_price']}}</td>
                <td>{{$orderitem['discount']}}</td>
                <td>
                    @if ($orderitem['discount'] > 0)
                    @php
                        
                        $subtotal = ((float)$orderitem['quantity'] * (float)$orderitem['unit_price']) - ((float)$orderitem['quantity'] * (float)$orderitem['unit_price'] * (float)$orderitem['discount'] / 100);
                        echo "Rs. ". $subtotal;
                        $totalamount += ((float)$orderitem['quantity'] * (float)$orderitem['unit_price']) - ((float)$orderitem['quantity'] * (float)$orderitem['unit_price'] * (float)$orderitem['discount'] / 100);
                    @endphp
                    @else
                    @php
                        
                        $subtotal = (float)$orderitem['quantity'] * (float)$orderitem['unit_price'];
                        $totalamount += (float)$orderitem['quantity'] * (float)$orderitem['unit_price'];
                        echo "Rs. ".$subtotal;
                    @endphp
                    @endif 
                   
                </td>
            </tr>
           
            @php
                $totaldiscount = $orderitem['total_discount'];
            @endphp
            @endforeach
            
            <tr class="total">
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td >Total Discount</td>
                <td>
                 {{$totaldiscount}}

                </td>
            </tr>

            <tr class="total">
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td >Total</td>
                <td>
                    @if ($totaldiscount > 0)
                        @php

                            $totalamount=(float)$totalamount - ((float)$totalamount * (float)$totaldiscount / 100);
                            echo "Rs. ".$totalamount;
                        @endphp
                    @else
                    Rs. {{$totalamount}}
                    @endif
                 

                </td>
            </tr>
        </tbody>
    </table>
   
    
    
      
   
    
    <div class="footer">

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
                            <div style="margin-left: 300px; text-align: center" > <!-- Adjust margin as needed -->
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
    </div>
</body>
</html>
