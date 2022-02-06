<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Print {{$general['bill_type']}} {{$invoice['tid']}}</title>

    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        header {
            padding: 5px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 2.0em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: #FCFCFC;
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #ebedf0;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="{{ Storage::disk('public')->url('app/public/img/company/' . $company['logo']) }}" height="120">
    </div>
    <h1>{{$general['bill_type']}} {{prefix($general['prefix'],$invoice['ins'])}}#{{$invoice['tid']}}</h1>
    <div id="company" class="clearfix">
        <div>{{$company['cname']}}</div>
        <div> {{$company['address']}},{{$company['city']}}<br />{{$company['region']}} {{$company['postbox']}}, {{$company['country']}}</div>
        <div>{{$company['phone']}}</div>
        <div>{{$company['email']}}</div>
    </div>
    <div id="project">
        <div><span>{{$general['person']}}</span> {{$invoice->customer->name}}</div>
        <div><span>{{trans('customers.address')}}</span> {{$invoice->customer->address}}, {{$invoice->customer->city}}, {{$invoice->customer->region}} {{$invoice->customer->postbox}}, {{$invoice->customer->country}}</div>
        <div><span>{{trans('general.email')}}</span> {{$invoice->customer->email}}</div>
        <div><span>{{$general['lang_bill_date']}}</span> {{dateFormat($invoice['invoicedate'],$company['main_date_format'])}}</div>
        <div><span>{{$general['lang_bill_due_date']}}</span> {{dateFormat($invoice['invoiceduedate'],$company['main_date_format'])}}</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service">#</th>
            <th class="desc">{{trans('products.product_des')}}</th>
            <th>{{trans('products.price')}}</th>
            <th>{{trans('products.qty')}}</th>
            <th> {{trans('general.subtotal')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice->products as $product)
        <tr>
            <td class="service">{{ $loop->iteration }}</td>
            <td class="desc">{{$product['product_name']}} @if(isset($product['serial'])){{$product['serial']}}@endif</td>
            <td class="unit">{{amountFormat($product['product_price'],$invoice['currency'])}}</td>
            <td class="qty">{{numberFormat($product['product_qty'],$invoice['currency'])}} {{$product['unit']}}</td>
            <td class="total">{{amountFormat($product['product_price']*$product['product_qty'],$invoice['currency'])}}</td>
        </tr>
        @endforeach

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
        </tbody>
    </table>
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
