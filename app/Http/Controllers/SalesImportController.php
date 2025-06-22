<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true); // pakai header: A, B, C...

        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                if ($index == 1) continue; // skip baris header

                $tanggal     = trim($row['A']); // '2025-02-28'
                $storeName   = trim($row['B']);
                $spgmName    = trim($row['C']);
                $productId   = trim($row['D']);
                $category    = trim($row['E']);
                $qty         = intval($row['F']);
                $saleType    = strtolower(trim($row['G'])); // retail/subdealer

                // Cari foreign key
                $store = DB::table('stores')->where('name', $storeName)->first();
                $spgm = DB::table('spgms')->where('name', $spgmName)->first();
                $product = DB::table('products')->where('id_product', $productId)->first();

                if (!$store || !$spgm || !$product) {
                    Log::warning("Data tidak ditemukan: store=$storeName, spgm=$spgmName, product=$productId");
                    continue;
                }

                DB::table('sales_transactions')->insert([
                    'transaction_date' => $tanggal,
                    'store_id'         => $store->id_store,
                    'spgms_id'         => $spgm->id_spgms,
                    'product_id'       => $product->id_product,
                    'quantity'         => $qty,
                    'sale_type'        => $saleType,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Data berhasil di-import.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal import Excel: ' . $e->getMessage());
            return back()->with('error', 'Gagal import data. Lihat log untuk detail.');
        }
    }
}
