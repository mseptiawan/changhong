<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataImportController extends Controller
{
    public function index()
    {
        return view('data-import.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        DB::beginTransaction();

        try {
            $inserted = 0;

            foreach ($rows as $i => $row) {
                if ($i == 1) continue; // Skip header

                $tanggal     = trim($row['A']);
                $storeName   = trim($row['B']);
                $spgmName    = trim($row['C']);
                $productName = trim($row['D']);
                $category    = trim($row['E']);
                $qty         = intval($row['F']);
                $saleType    = strtolower(trim($row['G']));

                $store   = DB::table('stores')->where('name', $storeName)->first();
                $spgm    = DB::table('spgms')->where('name', $spgmName)->first();
                $product = DB::table('products')->where('product_name', $productName)->first();

                if (!$store || !$spgm || !$product) {
                    Log::warning("Data tidak ditemukan: store=$storeName, spgm=$spgmName, product=$productName");
                    continue;
                }

                $sellOutPrice           = $product->sell_out_price;
                $pricePerUnitInMillions = $sellOutPrice / 1000000;
                $totalAmount            = round($pricePerUnitInMillions * $qty);

                DB::table('sales_transactions')->insert([
                    'transaction_date' => $tanggal,
                    'store_id'         => $store->id_store,
                    'spgms_id'         => $spgm->id_spgms,
                    'product_id'       => $product->id_product,
                    'category_code'    => $product->category_code,
                    'quantity'         => $qty,
                    'total_amount'     => $totalAmount,
                    'bigsize'          => $product->bigsize ?? false,
                    'variant'          => $product->variant ?? null,
                    'sale_type'        => $saleType,
                ]);

                $inserted++;
            }

            DB::commit();

            return redirect()->route('transaksi.rincian')
                ->with('success', "Berhasil mengimpor $inserted data transaksi (duplikat diperbolehkan).");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import.');
        }
    }
}
