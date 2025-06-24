<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncentiveRecapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->input('month', date('Y-m')); // default: bulan ini
        $exploded = explode('-', $month);

        if (count($exploded) !== 2) {
            return back()->with('error', 'Format bulan tidak valid.');
        }

        [$year, $monthOnly] = $exploded;

        $startOfMonth = Carbon::create($year, $monthOnly)->startOfMonth()->toDateString();
        $endOfMonth = Carbon::create($year, $monthOnly)->endOfMonth()->toDateString();

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
                'spgms.id_spgms',
                'spgms.name as spgm_name',
                'companies.group_name as company',
                'targets.target_amount',
                'targets.target_bigsize',
                DB::raw('COALESCE(SUM(sales_transactions.total_amount), 0) as actual_sales'),
                DB::raw('ROUND(COALESCE(SUM(sales_transactions.total_amount), 0) * 1000000 / targets.target_amount * 100, 0) as percent_achieved'),
                DB::raw('COALESCE(SUM(CASE WHEN sales_transactions.bigsize = 1 THEN sales_transactions.total_amount ELSE 0 END), 0) as bigsize_sales'),
                DB::raw('ROUND(COALESCE(SUM(CASE WHEN sales_transactions.bigsize = 1 THEN sales_transactions.total_amount ELSE 0 END) * 1000000 / targets.target_bigsize * 100, 0)) as percent_bigsize')
            )
            ->groupBy('spgms.id_spgms', 'spgms.name', 'companies.group_name', 'targets.target_amount', 'targets.target_bigsize')
            ->get();

        $recap = $summary->map(function ($row) use ($startOfMonth, $endOfMonth) {
            $achievement = $row->percent_achieved;
            $bigsize = $row->percent_bigsize;

            // Hitung Paid %
            $achievement_paid = $achievement < 50 ? 50 : ($achievement > 110 ? 110 : $achievement);
            $bigsize_paid = $bigsize < 50 ? 50 : ($bigsize > 110 ? 110 : $bigsize);

            $total_incentive_percent = ($achievement_paid * 0.5) + ($bigsize_paid * 0.5);

            // HITUNG TOTAL INSENTIF IDR
            $sales = DB::table('sales_transactions')
                ->join('model_incentives', function ($join) use ($startOfMonth, $endOfMonth) {
                    $join->on('sales_transactions.product_id', '=', 'model_incentives.product_id')
                        ->whereDate('model_incentives.effective_start', '<=', $endOfMonth)
                        ->whereDate('model_incentives.effective_end', '>=', $startOfMonth);
                })
                ->where('sales_transactions.spgms_id', $row->id_spgms)
                ->whereBetween('sales_transactions.transaction_date', [$startOfMonth, $endOfMonth])
                ->select(
                    DB::raw('SUM(sales_transactions.quantity * model_incentives.base_incentive) as base_incentive_total'),
                    DB::raw('SUM(CASE
                    WHEN sales_transactions.quantity >= model_incentives.min_qty_for_reward
                    THEN model_incentives.additional_reward
                    ELSE 0
                 END) as reward_total')
                )
                ->first();


            $total_incentive_idr = ($sales->base_incentive_total ?? 0) + ($sales->reward_total ?? 0);

            return [
                'SPGM' => $row->spgm_name,
                'Company' => $row->company,
                'Target (Jt)' => $row->target_amount,
                'Actual (Jt)' => $row->actual_sales,
                '% Achieved' => $achievement,
                'Target Bigsize (Jt)' => $row->target_bigsize,
                'Bigsize Actual (Jt)' => $row->bigsize_sales,
                '% Bigsize' => $bigsize,
                'Paid % Achieved' => $achievement_paid,
                'Paid % Bigsize' => $bigsize_paid,
                'Total Incentive Percent' => $total_incentive_percent,
                'Total Incentive (IDR)' => $total_incentive_idr,
            ];
        });

        return view('recap.index', compact('recap'));
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
