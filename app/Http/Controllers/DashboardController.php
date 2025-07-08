<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $targetMonth = 2; // Februari
        $targetYear  = 2025;

        $ranking = DB::table('sales_transactions')
            ->select('spgms_id', DB::raw('SUM(quantity) as total_qty'))
            ->join('products', 'sales_transactions.product_id', '=', 'products.id_product')
            ->where('products.bigsize', true)
            ->whereMonth('transaction_date', $targetMonth)
            ->whereYear('transaction_date', $targetYear)
            ->groupBy('spgms_id')
            ->orderByDesc('total_qty')
            ->get();

        $top10 = $ranking->take(10);
        $top20 = $ranking->slice(10, 10);

        $spgms = DB::table('spgms')->pluck('name', 'id_spgms');

        return view('dashboards.index', compact('top10', 'top20', 'spgms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
