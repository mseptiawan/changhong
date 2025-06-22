<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Session;

class ExcelImportController extends Controller
{
    public function showForm()
    {
        return view('import-form');
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('excel_file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $data = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            $data[] = $row[0];
        }

        // Simpan sementara di session (bisa juga disimpan di database kalau mau)
        session(['imported_names' => $data]);

        return redirect()->route('import.result');
    }

    public function showResult()
    {
        $data = session('imported_names', []);
        return view('import-result', compact('data'));
    }
}
