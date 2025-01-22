<?php
require_once './dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$html = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* General page styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            font-size:12px;
        }

        /* Set the page size for A4 portrait */
        @page {
            size: A5 portrait;
            padding : 0 10px;
        }

        .main {
            width: 100%;
            max-width: 750px; /* Adjust max-width to fit within the portrait A4 */
            margin: 0 0;
            background-color: #fff;
            padding: 20px;
            box-sizing: border-box;
        }

        h1, h2, h3 {
            margin: 0;
            color: #333;
            text-align: center;
        }

        p {
            margin: 5px 0;
        }

        .line {
            display: block;
            width: 100%;
            border-top: 2px dashed #333;
            margin: 6px 0;
        }

        .invoice-det {
            display: block;
            margin-bottom: 20px;
        }

        .invoice-det p {
            margin: 2px 0;
        }

        /* Styling for the invoice details */
        .invoice-det .inv {
            width: 50%;
            display: inline-block;
            vertical-align: top;
        }

        .invoice-det .date {
            width: 50%;
            display: inline-block;
            text-align: right;
            vertical-align: top;
        }

        /* Styling for product details */
        .product {
            width: 100%;
            margin: 10px 0;
            padding: 5px;
            box-sizing: border-box;
            text-align: left;
        }

        .product span {
            width: 16%;
            display: inline-block;
            padding: 5px 0;
        }

        .product b {
            font-weight: bold;
        }

        .product .description {
            width: 100%;
        }

        .product .amount {
            width: 20%;
            text-align: right;
        }

        /* Styling for the Tax Details table */
        .tax-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .tax-table th,
        .tax-table td {
            padding: 8px;
            text-align: left;
        }

        .tax-table th {
            background-color: #f2f2f2;
        }

        .total-row td {
            font-weight: bold;
            text-align: right;
        }

        .total-row td:first-child {
            text-align: left;
        }

        /* Footer Terms and Conditions */
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>

<body>
<center>
    <div class="main">
        <h1>Vestis Limited</h1>
        <p><b>Contact:</b> Shetyeyash444@gmail.com</p>
        <p><b>Place Of Supply:</b> Yashwant Galaxy 001 B, Y K Nagar, Virar West, Opp. Paradise Grandeur, behind Dmart, Vasai, Palghar-401303</p>

        <span class="line"></span>

        <h2>TAX INVOICE</h2>

        <span class="line"></span>

       <div class="invoice-det">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; text-align: left; padding: 5px;">
                <p><b>Invoice No:</b> 12455876</p>
                <p><b>Date:</b> 12-12-12 00:00:00</p>
            </td>
            <td style="width: 50%; text-align: right; padding: 5px;">
                <p><b>Customer Id:</b> 121545665</p>
                <p><b>Mobile No:</b> 8788064485</p>
            </td>
        </tr>
    </table>
</div>


        <span class="line"></span>

        <!-- Product Details Table -->
<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <!-- Table Header -->
    <thead>
        <tr>
            <th style="text-align: left; padding: 5px; border-bottom: 1px solid #ddd;"><b>Item</b></th>
            <th style="text-align: right; padding: 5px; border-bottom: 1px solid #ddd;"><b>Price</b></th>
            <th style="text-align: right; padding: 5px; border-bottom: 1px solid #ddd;"><b>Quantity</b></th>
            <th style="text-align: right; padding: 5px; border-bottom: 1px solid #ddd;"><b>Disc. Amt</b></th>
            <th style="text-align: right; padding: 5px; border-bottom: 1px solid #ddd;"><b>Net Amt</b></th>
        </tr>
    </thead>
    <!-- Table Body -->
    <tbody>
        <tr>
            <td style="text-align: left; padding: 5px;">10215451505102</td>
            <td style="text-align: right; padding: 5px;">Rs. 699.00</td>
            <td style="text-align: right; padding: 5px;">1</td>
            <td style="text-align: right; padding: 5px;">Rs. 0.00</td>
            <td style="text-align: right; padding: 5px;">Rs. 699.00</td>
        </tr>
        <tr>
            <td style="text-align: left; padding: 5px;" colspan="4"><b>Mens Sweat Shirt</b></td>
            <td style="text-align: right; padding: 5px;">Rs. 665.00</td>
        </tr>
    </tbody>
</table>


        <span class="line"></span>

        <!-- Total Amounts Table -->
<table style="width: 100%; margin-top: 10px; border-collapse: collapse;">
    <tr>
        <td style="width: 75%; text-align: left; padding: 8px; font-weight: bold;">Gross Total:</td>
        <td style="width: 25%; text-align: right; padding: 8px; font-weight: bold;">Rs. 699.00</td>
    </tr>
    <tr>
        <td style="width: 75%; text-align: left; padding: 8px; font-weight: bold;">Total Invoice Amt:</td>
        <td style="width: 25%; text-align: right; padding: 8px; font-weight: bold;">Rs. 699.00</td>
    </tr>
</table>


        <span class="line"></span>

        <h3>TAX DETAILS</h3>

        <table class="tax-table">
            <thead>
                <tr>
                    <th>GST IND</th>
                    <th>Taxable Value (Rs.)</th>
                    <th>CGST (Rs.)</th>
                    <th>SGST (Rs.)</th>
                    <th>CESS (Rs.)</th>
                    <th>Total Amt (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>A)</td>
                    <td>665.00</td>
                    <td>16.64</td>
                    <td>16.64</td>
                    <td>0.00</td>
                    <td>699.00</td>
                </tr>
            </tbody>
        </table>

        <span class="line"></span>

    <!-- Total Received Amount Table -->
<table style="width: 100%; margin-top: 10px; border-collapse: collapse;">
    <tr>
        <td style="width: 75%; text-align: left; padding: 8px; font-weight: bold;">TOTAL RECEIVED AMOUNT:</td>
        <td style="width: 25%; text-align: right; padding: 8px; font-weight: bold;">Rs. 699.00</td>
    </tr>
</table>


        <span class="line"></span>

        <div class="footer">
            <p>*All offers are applicable subject to T&C</p>
            <p>*Refund and exchange available for 7 days</p>
            <p>*Please retain the product label to be eligible for return or exchange</p>
            <p>*This is a computer-generated invoice and does not require a signature</p>
        </div>
    </div>
    </center>
</body>

</html>

    ';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$width = 300;
$height = "";

$dompdf->setPaper('A7', 'portrait');
$dompdf->render();
$dompdf->stream('invoice.pdf', ['0','0',$width=> 0]);
