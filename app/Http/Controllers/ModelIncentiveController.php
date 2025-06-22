<?php

namespace App\Http\Controllers;

use App\Models\ModelIncentives;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class ModelIncentiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->input('month');
        $search = $request->input('search');

        $incentives = ModelIncentives::with('product');

        if ($month) {
            try {
                $parsedMonth = date('Y-m', strtotime($month));
                $startDate = date('Y-m-01', strtotime($parsedMonth));
                $endDate = date('Y-m-t', strtotime($parsedMonth));

                $incentives->whereDate('effective_start', '<=', $endDate)
                    ->whereDate('effective_end', '>=', $startDate);
            } catch (\Exception $e) {
                // Optional: log error
            }
        }

        if ($search) {
            $incentives->whereHas('product', function ($query) use ($search) {
                $query->where('product_name', 'like', '%' . $search . '%');
            });
        }

        return view('incentives.index', [
            'incentives' => $incentives->paginate(10),
            'selectedMonth' => $month,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::select('id_product', 'product_name')->get();

        return view('incentives.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product_id' => 'required|exists:products,id_product',
            'base_incentive' => 'required|numeric|min:0',
            'additional_reward' => 'nullable|numeric|min:0',
        ]);

        // Hitung kuartal dari bulan sekarang
        $now = Carbon::now();
        $month = $now->month;

        $quarter = match (true) {
            $month >= 1 && $month <= 3 => ['start' => 1, 'end' => 3],
            $month >= 4 && $month <= 6 => ['start' => 4, 'end' => 6],
            $month >= 7 && $month <= 9 => ['start' => 7, 'end' => 9],
            default => ['start' => 10, 'end' => 12],
        };

        $year = $now->year;
        $effective_start = Carbon::create($year, $quarter['start'], 1);
        $effective_end = Carbon::create($year, $quarter['end'], 1)->endOfMonth();

        ModelIncentives::create([
            'product_id' => $request->product_id,
            'base_incentive' => $request->base_incentive,
            'additional_reward' => $request->additional_reward,
            'min_qty_for_reward' => 20,
            'effective_start' => $effective_start,
            'effective_end' => $effective_end,
        ]);

        return redirect()->route('model-incentives.index')->with('success', 'Model insentif berhasil ditambahkan.');
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
        $modelIncentive = ModelIncentives::with('product')->findOrFail($id);
        return view('incentives.edit', compact('modelIncentive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'base_incentive' => 'required|numeric|min:0',
            'additional_reward' => 'nullable|numeric|min:0',
        ]);

        $modelIncentive = ModelIncentives::findOrFail($id);
        $modelIncentive->update($validated);

        return redirect()->route('model-incentives.index')->with('success', 'Model insentif berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function autocomplete(Request $request)
    {
        $term = $request->get('term');

        $products = Product::where('product_name', 'like', '%' . $term . '%')
            ->orWhere('id_product', 'like', '%' . $term . '%')
            ->limit(10)
            ->get();

        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'id' => $product->id_product, // penting agar autocomplete bisa isi hidden input
                'value' => $product->product_name, // ditampilkan di input setelah dipilih
                'label' => $product->product_name . ' (' . $product->id_product . ')', // tampil di dropdown
            ];
        }

        return response()->json($results);
    }
}
