<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['modelIncentives', 'sales', 'discontinuedProduct']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('product_name', 'like', '%' . $searchTerm . '%');
        }

        $products = $query->paginate(15)->withQueryString();

        return view('products.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = ProductCategory::all();

        // Variants berdasarkan kategori
        $variantOptions = [
            'TV' => 'TV ( OVER 50 )',
            'AC' => 'AC ( OVER 1,5P )',
            'REFF' => 'NO FROST',
            'WM' => 'Front Loading',
        ];

        return view('products.create', compact('categories', 'variantOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|exists:product_categories,category_code', // penting: pastikan kategori valid
            'product_name' => 'required|string|unique:products,product_name',
            'variant' => 'nullable|string',
            'sell_out_price' => 'required|numeric|min:0',
        ]);

        // Buat ID produk berdasarkan category_code dan nama produk (tanpa spasi, kapital)
        $id_product = strtoupper($validated['category']) . '-' . strtoupper(str_replace(' ', '', $validated['product_name']));

        try {
            Product::create([
                'id_product'       => $id_product,
                'category_code'    => $validated['category'], // kolom foreign key-nya adalah category_code
                'product_name'     => $validated['product_name'],
                'variant'          => $validated['variant'] ?? null,
                'sell_out_price'   => $validated['sell_out_price'],
                'bigsize'          => $validated['variant'] ? true : false,
            ]);

            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage()]);
        }
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
    public function edit(string $id, Request $request)
    {
        //
        $product = Product::with('category')->findOrFail($id); // pastikan relasi 'category' ada di model Product

        // Ambil harga langsung dari kolom di tabel products
        $activePrice = $product->sell_out_price;

        // Ambil semua kategori dari tabel product_categories
        $categories = ProductCategory::all();

        return view('products.edit', compact('product', 'activePrice', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validated = $request->validate([
            'sell_out_price' => 'required|numeric|min:0',
            'product_name' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'bigsize' => 'required|boolean',
        ]);

        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Update field yang boleh diubah
        $product->sell_out_price = $validated['sell_out_price'];
        $product->product_name = $validated['product_name'];
        $product->variant = $validated['variant'];
        $product->bigsize = $validated['bigsize'];

        // Simpan perubahan
        $product->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
