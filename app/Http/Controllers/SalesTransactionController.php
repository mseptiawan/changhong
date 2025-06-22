<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesTransactionController extends Controller
{
    public function index()
    {
        $sales = DB::table('sales_transactions')
            ->join('stores', 'sales_transactions.store_id', '=', 'stores.id_store')
            ->join('spgms', 'sales_transactions.spgms_id', '=', 'spgms.id_spgms')
            ->join('products', 'sales_transactions.product_id', '=', 'products.id_product')
            ->select(
                'sales_transactions.*',
                'stores.name as store_name',
                'spgms.name as spgm_name',
                'products.product_name'
            )
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('transaksi.index', compact('sales'));
    }

    public function rincian()
    {
        $transactions = DB::table('sales_transactions')
            ->join('stores', 'sales_transactions.store_id', '=', 'stores.id_store')
            ->join('products', 'sales_transactions.product_id', '=', 'products.id_product')
            ->join('spgms', 'sales_transactions.spgms_id', '=', 'spgms.id_spgms')
            ->join('companies', 'spgms.company_id', '=', 'companies.id_companies')
            ->select(
                'sales_transactions.*',
                'stores.name as store_name',
                'products.product_name',
                'spgms.name as spgm_name',
                'companies.group_name as company_name'
            )
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('transaksi.rincian', compact('transactions'));
    }


    public function summary(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        // Pecah bulan dan tahun
        [$year, $monthOnly] = explode('-', $month);

        $summary = DB::table('spgms')
            ->join('companies', 'spgms.company_id', '=', 'companies.id_companies')
            ->join('targets', function ($join) use ($year, $monthOnly) {
                $join->on('targets.spgms_id', '=', 'spgms.id_spgms')
                    ->whereRaw("MONTH(targets.month) = ? AND YEAR(targets.month) = ?", [$monthOnly, $year]);
            })
            ->leftJoin('sales_transactions', function ($join) use ($year, $monthOnly) {
                $join->on('sales_transactions.spgms_id', '=', 'spgms.id_spgms')
                    ->whereRaw("MONTH(sales_transactions.transaction_date) = ? AND YEAR(sales_transactions.transaction_date) = ?", [$monthOnly, $year]);
            })
            ->select(
                'spgms.name as spgm_name',
                'companies.group_name as company',
                'targets.target_amount',
                'targets.target_bigsize',
                DB::raw('COALESCE(SUM(sales_transactions.total_amount), 0) as actual_sales'),
                DB::raw('ROUND(COALESCE(SUM(sales_transactions.total_amount), 0) * 1000000 / targets.target_amount * 100, 0) as percent_achieved'),

                DB::raw('COALESCE(SUM(CASE WHEN sales_transactions.bigsize = 1 THEN sales_transactions.total_amount ELSE 0 END), 0) as bigsize_sales'),
                DB::raw('ROUND(COALESCE(SUM(CASE WHEN sales_transactions.bigsize = 1 THEN sales_transactions.total_amount ELSE 0 END), 0) / (targets.target_bigsize / 1000000), 0) as percent_bigsize')


            )
            ->groupBy(
                'spgms.name',
                'companies.group_name',
                'targets.target_amount',
                'targets.target_bigsize'
            )
            ->get();


        return view('transaksi.summary', compact('summary'));
    }
}
