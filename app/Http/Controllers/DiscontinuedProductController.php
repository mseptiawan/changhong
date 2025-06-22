<?php

namespace App\Http\Controllers;

use App\Models\DiscontinuedProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscontinuedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indx() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        return view('discontinued.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id_product',
            'discontinue_date' => 'required|date',
        ]);

        // Cek apakah sudah ada data discontinue untuk produk tersebut
        $existing = DiscontinuedProduct::where('product_id', $request->product_id)->first();

        if ($existing) {
            return redirect()->route('products.index')->with('error', 'Produk ini sudah didiscontinue.');
        }

        // Simpan data discontinue
        DiscontinuedProduct::create([
            'product_id' => $request->product_id,
            'discontinue_date' => $request->discontinue_date,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil didiscontinue.');
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
    public function edit($id)
    {
        $discontinuedProduct = DiscontinuedProduct::with('product')->findOrFail($id);
        return view('discontinued.edit', compact('discontinuedProduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'discontinue_date' => 'required|date',
        ]);

        $discontinuedProduct = DiscontinuedProduct::findOrFail($id);
        $discontinuedProduct->discontinue_date = $request->discontinue_date;
        $discontinuedProduct->save();

        return redirect()->route('products.index')->with('success', 'Tanggal discontinue berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $discontinued = DiscontinuedProduct::findOrFail($id);
        $discontinued->delete();

        return response()->json(['message' => 'Discontinued product removed']);
    }
}
