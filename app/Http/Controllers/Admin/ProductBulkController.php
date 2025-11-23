<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductBulkController extends Controller 
{
    public function showImport() 
    { 
        return view('admin.products.import'); 
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        // 1. Simpan file ke disk public
        $path = $request->file('file')->store('imports', 'public');

        // 2. Import file (HARUS pakai storage_path public)
        $fullPath = storage_path('app/public/' . $path);
        Excel::import(new ProductsImport, $fullPath);

        // 3. Hapus file setelah import (HARUS pakai disk public)
        Storage::disk('public')->delete($path);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Products imported successfully.');
    }
}
