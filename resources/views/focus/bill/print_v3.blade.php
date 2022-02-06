<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Print {{$general['bill_type']}} {{$invoice['tid']}}</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>
        @font-face {
            font-family: SourceSansPro;
            src: url(SourceSansPro-Regular.ttf);
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 10pt;

        }

        header {
            padding: 5px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #header td {
            background: #FFF;
            text-align: left;

        }
        #header tr td:nth-child(2n) {
            text-align: right;
        }


        #logo {
            float: left;
            margin-top: 4px;
            display: inline-block;
        }

        #logo img {
            height: 70px;
        }

        #company {
            display: inline-block;
            float: right;
            text-align: right;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.0em;
            line-height: 1em;
            font-weight: normal;
            margin: 0  0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3{
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks{
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices{
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }


    </style>
</head>
<body>
<table id="header" class="clearfix">
    <tr><td> <div id="logo">
                <img src="{{ Storage::disk('public')->url('app/public/img/company/' . $company['logo']) }}" height="70">
            </div></td><td><div id="company">
                <h2 class="name">{{$company['cname']}}</h2>
                <div> {{$company['address']}},{{$company['city']}}<br />{{$company['region']}} {{$company['postbox']}}, {{$company['country']}}</div>
                <div>{{$company['phone']}}</div>
                <div>{{$company['email']}}</div>
            </div></td></tr>
    <tr><td style=" border-left: 6px solid #0087C3;">   <div id="client">
                <div class="to">{{$general['person']}}:</div>
                <h2 class="name">{{$invoice->customer->name}}</h2>
                <div class="address">{{$invoice->customer->address}}, {{$invoice->customer->city}}, {{$invoice->customer->region}} {{$invoice->customer->postbox}}, {{$invoice->customer->country}}</div>
                <div class="email">{{$invoice->customer->email}}</div>
            </div></td><td><div id="invoice">
                <h2>{{$general['bill_type']}} {{prefix($general['prefix'],$invoice['ins'])}}#{{$invoice['tid']}}</h2>
                <div class="date">{{$general['lang_bill_date']}}: {{dateFormat($invoice['invoicedate'],$company['main_date_format'])}}</div>
                <div class="date">{{$general['lang_bill_due_date']}}: {{dateFormat($invoice['invoiceduedate'],$company['main_date_format'])}}</div>
            </div></td></tr>



</table>
<main>
    <div id="details" class="clearfix">


    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc">{{trans('products.product_des')}}</th>
            <th class="unit">{{trans('products.price')}}</th>
            <th class="qty">{{trans('products.qty')}}</th>
            <th class="total">{{trans('general.subtotal')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->products as $product)
        <tr>
            <td class="no">{{ $loop->iteration }}</td>
            <td class="desc"><h4>{{$product['product_name']}}</h4>{{$product['product_des']}} @if(isset($product['serial'])){{$product['serial']}}@endif</td>
            <td class="unit">{{amountFormat($product['product_price'],$invoice['currency'])}}</td>
            <td class="qty">{{numberFormat($product['product_qty'],$invoice['currency'])}} {{$product['unit']}}</td>
            <td class="total">{{amountFormat($product['product_price']*$product['product_qty'],$invoice['currency'])}}</td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">{{trans('general.subtotal')}}</td>
            <td class="total">{{amountFormat($invoice['subtotal'],$invoice['currency'])}}</td>
        </tr>
        @if($invoice['tax'])
            <tr>
                <td colspan="4">{{$general['tax_string_total']}}</td>
                <td class="total">{{amountFormat($invoice['tax'],$invoice['currency'])}}</td>
            </tr>
        @endif
        @if($invoice['discount']>0)
            <tr>
                <td colspan="4">{{trans('general.discount')}}</td>
                <td class="total">{{amountFormat($invoice['discount'],$invoice['currency'])}}</td>
            </tr>
        @endif
        @if($invoice['shipping']>0)
            <tr>
                <td colspan="4">{{trans('general.shipping')}}</td>
                <td class="total">{{amountFormat($invoice['shipping'],$invoice['currency'])}}</td>
            </tr>
        @endif
        <tr>
            <td colspan="4" class="grand total">{{trans('general.grand_total')}}</td>
            <td class="grand total">{{amountFormat($invoice['total'],$invoice['currency'])}}</td>
        </tr>
        </tfoot>
    </table>
    <div id="thanks">Thank you!</div>
    <div id="notices">
        <div>{{@$invoice->term->title}}:</div>
        <div class="notice">{!!@$invoice->term->terms  !!}</div>
    </div>
</main>
<footer>
    {{trans('en.invoice_footer')}}
</footer>
</body>
</html>
