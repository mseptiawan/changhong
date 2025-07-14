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

        // === 1. Summary awal
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

        // === 2. Hitung rank berdasarkan bigsize_sales
        $ranked = $summary
            ->sortByDesc('bigsize_sales') // urut terbesar ke kecil
            ->values()
            ->map(function ($row, $index) {
                $row->bigsize_rank = $index + 1;
                return $row;
            });

        // === 3. Hitung recap + insentif
        $recap = $ranked->map(function ($row) use ($startOfMonth, $endOfMonth) {
            $achievement = $row->percent_achieved;
            $bigsize = $row->percent_bigsize;

            // === Perhitungan Paid % sesuai aturan
            if ($achievement < 50) {
                $achievement_paid = 50;
            } elseif ($achievement <= 70) {
                $achievement_paid = 70;
            } elseif ($achievement <= 110) {
                $achievement_paid = $achievement;
            } else {
                $achievement_paid = 110;
            }

            if ($bigsize < 50) {
                $bigsize_paid = 50;
            } elseif ($bigsize <= 70) {
                $bigsize_paid = 70;
            } elseif ($bigsize <= 110) {
                $bigsize_paid = $bigsize;
            } else {
                $bigsize_paid = 110;
            }

            $productsSold = DB::table('sales_transactions')
                ->join('products', 'sales_transactions.product_id', '=', 'products.id_product')
                ->where('sales_transactions.spgms_id', $row->id_spgms)
                ->whereBetween('sales_transactions.transaction_date', [$startOfMonth, $endOfMonth])
                ->select('products.product_name', 'sales_transactions.quantity', 'sales_transactions.total_amount')
                ->get()
                ->map(function ($p) {
                    return [
                        'product_name' => $p->product_name,
                        'quantity'     => $p->quantity,
                        'total_amount' => $p->total_amount,
                    ];
                });

            $total_incentive_percent = ($achievement_paid * 0.5) + ($bigsize_paid * 0.5);

            // === Hitung insentif dari model_incentives
            $sales = DB::table('sales_transactions')
                ->join('model_incentives', function ($join) use ($startOfMonth, $endOfMonth) {
                    $join->on('sales_transactions.product_id', '=', 'model_incentives.product_id')
                        ->whereDate('model_incentives.effective_start', '<=', $endOfMonth)
                        ->whereDate('model_incentives.effective_end', '>=', $startOfMonth);
                })
                ->where('sales_transactions.spgms_id', $row->id_spgms)
                ->whereBetween('sales_transactions.transaction_date', [$startOfMonth, $endOfMonth])
                ->select(
                    DB::raw('SUM(sales_transactions.quantity * model_incentives.base_incentive) as base_incentive_total')
                )
                ->first();

            // Hitung Additional Reward terpisah
            $rewardIncentives = DB::table('sales_transactions')
                ->join('model_incentives', function ($join) use ($startOfMonth, $endOfMonth) {
                    $join->on('sales_transactions.product_id', '=', 'model_incentives.product_id')
                        ->whereDate('model_incentives.effective_start', '<=', $endOfMonth)
                        ->whereDate('model_incentives.effective_end', '>=', $startOfMonth);
                })
                ->where('sales_transactions.spgms_id', $row->id_spgms)
                ->whereBetween('sales_transactions.transaction_date', [$startOfMonth, $endOfMonth])
                ->groupBy('sales_transactions.product_id')
                ->selectRaw("
        sales_transactions.product_id,
        SUM(sales_transactions.quantity) as total_qty,
        MAX(model_incentives.additional_reward) as reward_per_unit,
        MAX(model_incentives.min_qty_for_reward) as min_qty
    ")
                ->get();

            $reward_incentive = $rewardIncentives->reduce(function ($carry, $item) {
                if ($item->total_qty >= $item->min_qty && $item->reward_per_unit > 0) {
                    return $carry + ($item->reward_per_unit * $item->total_qty);
                }
                return $carry;
            }, 0);

            $base_incentive = $sales->base_incentive_total ?? 0;

            // === Bonus Top Bigsize
            $rank = $row->bigsize_rank ?? null;
            $bigsize_top_bonus = 0;
            if ($rank !== null) {
                if ($rank >= 1 && $rank <= 10) {
                    $bigsize_top_bonus = 400_000;
                } elseif ($rank >= 11 && $rank <= 20) {
                    $bigsize_top_bonus = 300_000;
                }
            }

            // 2.a gabungkan base + reward
            $gross_incentive = $base_incentive + $reward_incentive;

            // 2.b terapkan persen pembayaran (97.5 %, 90 %, dst.)
            $paid_incentive  = $gross_incentive * ($total_incentive_percent / 100);

            // 2.c tambahkan bonus Top 10/20 bigsize
            $total_incentive_idr = $paid_incentive + $bigsize_top_bonus;


            return [
                'SPGM' => $row->spgm_name,
                'Company' => $row->company,
                'Rank Bigsize' => $rank,
                'Bigsize Top Bonus (IDR)' => $bigsize_top_bonus,
                'Target (Jt)' => $row->target_amount,
                'Actual (Jt)' => $row->actual_sales,
                '% Achieved' => $achievement,
                'Target Bigsize (Jt)' => $row->target_bigsize,
                'Bigsize Actual (Jt)' => $row->bigsize_sales,
                '% Bigsize' => $bigsize,
                'Paid % Achieved' => $achievement_paid,
                'Paid % Bigsize' => $bigsize_paid,
                'Total Incentive Percent' => $total_incentive_percent,
                'Base Incentive (IDR)' => $base_incentive,
                'Reward Incentive (IDR)' => $reward_incentive,
                'Total Incentive (IDR)' => $total_incentive_idr,
                'Base Incentive (IDR)'    => $base_incentive,
                'Reward Incentive (IDR)'  => $reward_incentive,
                'Gross Incentive (IDR)'   => $gross_incentive,   // opsional untuk debug
                'Paid Incentive (IDR)'    => $paid_incentive,    // setelah persen
                'Total Incentive (IDR)'   => $total_incentive_idr,
                'Products Sold'           => $productsSold,
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
