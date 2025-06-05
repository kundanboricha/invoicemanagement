<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
     public function import(Request $request)
    {
        $file = $request->file('csv');

        $data = array_map('str_getcsv', file($file));
        unset($data[0]); 

        foreach ($data as $row) {
            Product::create([
                'part_type' => $row[0],
                'description' => $row[1],
                'product_info' => $row[2],
                'color' => $row[3],
                'quantity' => $row[4],
                'part_number' => $row[5],
                'single_price' => $row[6],
                'bulk_price' => $row[7],
            ]);
        }

        return redirect()->back()->with('success', 'Products imported.');
    }
}
