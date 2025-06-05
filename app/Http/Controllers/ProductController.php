<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  show list of products
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    // Show the form to upload CSV
    public function importForm()
    {
        return view('products.import');
    }

    // Handle CSV import
    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // Excel::import(new ProductImport, $request->file('csv'));
            Excel::queueImport(new ProductImport, $request->file('csv'));

            return redirect()->route('products.import')->with('success', 'Import started. It will complete in the background.');
        } catch (\Throwable $e) {
            Log::error("Excel import failed: " . $e->getMessage());
            return back()->with('error', 'Import failed. Check logs for details.');
        }
    }
}
