<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Spgm;
use App\Models\Store;
use Illuminate\Http\Request;

class SpgmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Spgm::with(['store', 'company', 'targets']);

        // Tambahkan fitur pencarian jika ada query search
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('store', fn($q) => $q->where('name', 'like', '%' . $searchTerm . '%'))
                ->orWhereHas('company', fn($q) => $q->where('group_name', 'like', '%' . $searchTerm . '%'));
        }

        $spgms = $query->paginate(9)->withQueryString(); // Agar pagination tetap membawa query search

        return view('spgms.index', compact('spgms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $companies = Company::all();
        $stores = Store::all();

        // Cari angka terbesar dari id_spgms yang sudah ada
        $lastNumber = Spgm::selectRaw('MAX(CAST(SUBSTRING(id_spgms, 4) AS UNSIGNED)) as max_id')
            ->value('max_id');

        $nextNumber = $lastNumber ? $lastNumber + 1 : 100;
        $nextId = 'SPG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('spgms.create', compact('companies', 'stores', 'nextId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'id_spgms' => 'required|unique:spgms,id_spgms',
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id_companies',
            'store_id' => 'required|exists:stores,id_store',
        ]);

        Spgm::create($request->all());

        return redirect()->route('promoters.index')->with('success', 'Promotor berhasil ditambahkan.');
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
    public function edit($promoter, Request $request)
    {
        //
        $promoter = Spgm::findOrFail($promoter);
        $companies = Company::all();
        $stores = Store::all();
        return view('spgms.edit', compact('promoter', 'companies', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id_companies',
            'store_id'   => 'required|exists:stores,id_store',
        ]);

        $promoter = Spgm::where('id_spgms', $id)->firstOrFail();
        $promoter->update([
            'name' => $request->name,
            'company_id' => $request->company_id,
            'store_id' => $request->store_id,
        ]);

        return redirect()->route('promoters.index')->with('success', 'Data promoter berhasil diperbarui.');
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

        $spgms = Spgm::where('name', 'like', '%' . $term . '%')
            ->limit(10)
            ->get();

        $results = [];

        foreach ($spgms as $spgm) {
            $results[] = [
                'id' => $spgm->id_spgms,
                'label' => $spgm->name,
            ];
        }

        return response()->json($results);
    }
}
