<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Focus\general;

use App\Http\Responses\RedirectResponse;
use App\Models\Company\ConfigMeta;
use App\Models\Company\Goal;
use App\Models\customer\Customer;
use App\Models\invoice\Invoice;
use App\Models\items\InvoiceItem;
use App\Models\product\ProductVariation;
use App\Models\transaction\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class CoreDashboard extends Controller
{
    public function index()
    {

        if (access()->allow('dashboard-owner')) {
            $today = date('Y-m-d');
            $start_date = date('Y-m') . '-01';

            $invoice = Invoice::with(['customer'])->whereBetween('invoicedate', [$start_date, $today])->orderBy('id', 'desc')->take(10);
            $data['invoices'] = $invoice->get();
            $data['customers'] = $invoice->groupBy('customer_id')->get();
            //  dd($data['customers']->pluck('customer_id')->toArray());
            $transactions = Transaction::with(['account'])->whereBetween('payment_date', [$start_date, $today])->orderBy('id', 'desc')->take(10)->get();
            $data['stock_alert'] = ProductVariation::whereRaw('qty<=alert')->whereHas('product', function ($query) {
                return $query->where('stock_type', '=', 1);
            })->orderBy('id', 'desc')->take(10)->get();

            $cates=\App\Models\transactioncategory\Transactioncategory::all();
            $income_cat=array();
            $exp_cat=array();
            foreach ($cates as $cat){
                if(is_array(json_decode(feature(10)['value1']))) {

                     if(in_array($cat->id, json_decode(feature(10)['value1']))) {
                         array_push($exp_cat,array($cat->id,$cat->name));
                     }
                    if(in_array($cat->id, json_decode(feature(8)['value1']))) {
                        array_push($income_cat,array($cat->id,$cat->name));
                    }
            }
                }


            return view('focus.dashboard.index', compact('data', 'transactions','income_cat','exp_cat'));
        }
        if (access()->allow('product-manage')) {
            return new RedirectResponse(route('biller.products.index'), ['']);
        }
        return view('focus.dashboard.no_data');
    }


    public function mini_dash()
    {
        $today = date('Y-m-d');
        $start_date = date('Y-m') . '-01';

        $data['sales_chart'] = Invoice::whereBetween('invoicedate', [$start_date, $today])->groupBy('invoicedate')->select('invoicedate', DB::raw('count(id) as items'), DB::raw('sum(total) as total'))->get();
        $data['today_invoices'] = Invoice::whereBetween('invoicedate', [$start_date, $today])->where('invoicedate', '=', $today)->select('invoicedate', DB::raw('count(id) as items'), DB::raw('sum(total) as total'))->get()->first();
        $data['month_invoices'] = Invoice::whereBetween('invoicedate', [$start_date, $today])->select('invoicedate', DB::raw('count(id) as items'), DB::raw('sum(total) as total'))->get()->first();



        $transactions = Transaction::whereRaw("(DATE(payment_date) between '$start_date' AND '$today') AND relation_id!=-1");
        $data['transactions'] = $transactions->where('payment_date', '=', $today)->select('payment_date', DB::raw('sum(credit) as credit'))->get()->first();
        $income_category = ConfigMeta::where('feature_id', '=', 8)->first();

        $purchase_category = ConfigMeta::where('feature_id', '=', 10)->first(['feature_value','value1']);

        $income_category=json_decode($income_category['value1']);
        $purchase_category =json_decode($purchase_category['value1']);


       // $transactions_today = Transaction::where('payment_date', $today);



        $exp_today=Transaction::where('payment_date', $today)->whereIn('trans_category_id', [$purchase_category])->select(DB::raw('sum(debit) as debit'))->get()->first();

        $inc_today=Transaction::where('payment_date', $today)->whereIn('trans_category_id', [$income_category])->select(DB::raw('sum(credit) as credit'))->get()->first();


        $transactions = Transaction::whereBetween('payment_date', [$start_date, $today])->get();

        $transactions_chart['income'] = $transactions->whereIn('trans_category_id', $income_category);
        $transactions_chart['expenses'] = $transactions->whereIn('trans_category_id', $purchase_category);
        $transactions_chart['income_total'] = $transactions->whereIn('trans_category_id', $income_category)->sum('credit');

        $transactions_chart['expenses_total'] = $transactions->whereIn('trans_category_id', $purchase_category)->sum('debit');
        $income_chart = array();
        foreach ($transactions_chart['income'] as $row_i) {
            $income_chart[] = array('x' => $row_i['payment_date'], 'y' => (int)$row_i['credit']);
        }
        $expense_chart = array();
        foreach ($transactions_chart['expenses'] as $row_i) {
            $expense_chart[] = array('x' => $row_i['payment_date'], 'y' => (int)$row_i['debit']);
        }
        $sales_chart = array();
        foreach ($data['sales_chart'] as $row) {
            $sales_chart[] = array('y' => $row['invoicedate'], 'sales' => (int)(numberClean($row['total'])), 'invoices' => (int)($row['items']));
        }

        $new_products = ProductVariation::whereDate('created_at','=',date('Y-m-d'))->count();
        $customers = Customer::whereDate('created_at','=',date('Y-m-d'))->count();
        $sold_stock = InvoiceItem::whereDate('created_at','>=',$start_date);

        $sold_products = $sold_stock->whereDate('created_at','=',date('Y-m-d'))->count();

        $sold_stock=$sold_stock->count();

        $goals=Goal::where('month','=',date('m'))->first();

        $sales=$data['month_invoices']['total']*100/$goals->sales;
        if($sales>100){
            $sales='100';
        }

        $stock=$sold_stock*100/$goals->stock;
        if($stock>100){
            $stock='100';
        }

        $income=$transactions_chart['income_total']*100/$goals->income;
        if($income>100){
            $income='100';
        }

        $expense=$transactions_chart['expenses_total']*100/$goals->expense;
        if($expense>100){
            $expense='100';
        }





        return json_encode(array(
            'dash' => array(
                numberFormat($data['today_invoices']['items'], 0, 1),
                amountFormat($data['today_invoices']['total'], 0, 1),
                numberFormat($data['month_invoices']['items'], 0, 1),
                amountFormat($data['month_invoices']['total'], 0, 1),
                amountFormat($data['today_invoices']['total'], 0, 1),
                amountFormat($inc_today['credit']),
                amountFormat($exp_today['debit']),
                amountFormat($inc_today['credit'] - $exp_today['debit']),
                amountFormat(profit_calc()),
                numberFormat($sold_products),
                $customers,
                $new_products,
                numberFormat($goals->sales).'/'.numberFormat($data['month_invoices']['total']),
                $sales,
                numberFormat($sold_stock).'/'. numberFormat($goals->stock),
                $stock,
                numberFormat($transactions_chart['income_total']).'/'.numberFormat($goals->income),
                $income,
                numberFormat($transactions_chart['expenses_total']).'/'.numberFormat($goals->expense),
                $expense
            ),
            'income_chart' => $income_chart,
            'expense_chart' => $expense_chart,
            'inv_exp' => array('income' => (int)$transactions_chart['income_total'], 'expense' => (int)$transactions_chart['expenses_total']),
            'sales' => $sales_chart,
        ));
    }

    public function todo()
    {
        $mics = Misc::all();
        $employees = Hrm::all();
        $user = auth()->user()->id;
        $project_select = Project::whereHas('users', function ($q) use ($user) {
            return $q->where('rid', '=', $user);
        })->get();
        return new ViewResponse('focus.projects.tasks.index', compact('mics', 'employees', 'project_select'));
    }


}
