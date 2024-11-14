<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Report in Sales</title>
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
                       <h1>Report</h1>
                       <h3>Start Date: {{ $startDateReport }}</h3><h3>End Date: {{ $endDateReport }}</h3>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>
        <table class="item-table">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Order ID</th>
                    <th class="border px-4 py-2">Invoice Date</th>
                    <th class="border px-4 py-2">Final Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($reports as $report)
                    <tr>
                        <td class="border px-4 py-2">SS/{{ $report->order_id }}</td>
                        <td class="border px-4 py-2">
                            {{ $report->invoicedate }}
                        </td>
                        <td class="border px-4 py-2">Rs. {{ number_format($report->final_total, 2) }}</td>
                        @php
                            $total += $report->final_total;
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <td class="border px-4 py-2 font-bold" colspan="2">Total</td>
                    <td class="border px-4 py-2 font-bold">Rs. {{ number_format($total, 2) }}</td>
                </tr>
            </tbody>
        </table>
</body>

</html>
