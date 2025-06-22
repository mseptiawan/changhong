<?php

namespace App\Http\Controllers;

use App\Models\Spgm;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $targets = Target::with(['spgm'])
            ->when($search, function ($query, $search) {
                $query->whereHas('spgm', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('month', 'desc')
            ->paginate(15);

        return view('targets.index', compact('targets', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $spgms = Spgm::all(); // ambil semua SPGM

        return view('targets.create', compact('spgms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'spgms_id' => 'required|exists:spgms,id_spgms',
            'month' => 'required|date',
            'target_amount' => 'required|numeric|min:0',
            'share_bigsize_percent' => 'required|numeric|min:0|max:100',
        ]);

        // Bersihkan dan hitung nilai
        $target_amount = floatval(str_replace('.', '', $request->target_amount));
        $share_percent = floatval($request->share_bigsize_percent);
        $target_bigsize = $target_amount * ($share_percent / 100);

        // Simpan ke database
        Target::create([
            'spgms_id' => $request->spgms_id,
            'month' => $request->month,
            'target_amount' => $target_amount,
            'share_bigsize_percent' => $share_percent,
            'target_bigsize' => $target_bigsize,
        ]);

        return redirect()->route('targets.index')->with('success', 'Target berhasil ditambahkan.');
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
    public function edit(Target $target)
    {
        return view('targets.edit', compact('target'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Target $target)
    {
        $request->validate([
            'month' => 'required|date',
            'target_amount' => 'required',
            'share_bigsize_percent' => 'required|numeric|min:0|max:100',
        ]);

        // Bersihkan dan hitung ulang nilai target
        $target_amount = floatval(str_replace('.', '', $request->target_amount));
        $share_percent = floatval($request->share_bigsize_percent);
        $bigsize = $target_amount * ($share_percent / 100);

        $target->update([
            'month' => $request->month,
            'target_amount' => $target_amount,
            'share_bigsize_percent' => $share_percent,
            'target_bigsize' => $bigsize,
        ]);

        return redirect()->route('targets.index')->with('success', 'Target berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function filterByDate(Request $request)
    {
        // Validasi input tanggal/bulan (boleh flexible, misal 'date' optional)
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $month = $request->input('month');
        [$year, $bulan] = explode('-', $month);

        $targets = Target::with('spgm')
            ->whereYear('month', $year)
            ->whereMonth('month', $bulan)
            ->paginate(15); // ← fix-nya

        return view('targets.index', compact('targets'));
        // return 'seaaf';
    }
}
