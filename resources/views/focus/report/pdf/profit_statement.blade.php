@extends ('focus.report.pdf.statement')
@section('statement_body')
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td>{{trans('general.date')}}</td>
            <td>{{trans('products.product')}}</td>
            <td>{{trans('meta.purchase')}}</td>
            <td>{{trans('meta.sales')}}</td>
            <td>{{trans('en.profit')}}</td>
        </tr>
        @php
            $fill = false;
            $balance=0;
            foreach ($transactions as $row) {
                if ($fill == true) {
                    $flag = ' mfill';
                } else {
                    $flag = '';
                }
                $balance += ($row['product_price'] - $row['purchase_price'])*$row['product_qty'];
                echo '<tr class="item' . $flag . '"><td>' . dateFormat($row['created_at']) . '</td><td>'.$row['product_name'] . ' ' . $row['code'].'</td><td>' . amountFormat($row['purchase_price']) . '</td><td>' . amountFormat($row['product_price']) . '</td><td>' . amountFormat($balance) . '</td></tr>';
                $fill = !$fill;
            }
        @endphp
    </table>
    <br>
    <table class="subtotal">
        <thead>
        <tbody>
        <tr>
            <td class="myco2" rowspan="2"><br>
            </td>
            <td class="summary"><strong>{{trans('general.summary')}}</strong></td>
            <td class="summary"></td>
        </tr>
        <tr>
            <td>{{trans('en.profit')}}:</td>
            <td>{{amountFormat($balance)}}</td>
        </tr>

        </tbody>
    </table>
@endsection
