<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductImport implements ToCollection ,WithChunkReading,ShouldQueue
{
    public function collection(Collection $rows)
    {
        // Remove header
        $rows->shift();

        Log::info("Starting row import from Excel. Total rows: " . count($rows));

        $last = ['', '', '']; // for forward fill
        $imported = 0;

        foreach ($rows as $index => $row) {
            for ($i = 0; $i <= 2; $i++) {
                if (!empty($row[$i])) {
                    $last[$i] = $row[$i];
                } else {
                    $row[$i] = $last[$i];
                }
            }

            try {
                Product::updateOrCreate(
                    ['part_number' => $row[5]],
                    [
                        'part_type'     => $row[0],
                        'description'   => $row[1],
                        'product_info'  => $row[2],
                        'color'         => $row[3],
                        'quantity'      => $row[4],
                        'single_price'  => $row[6],
                        'bulk_price'    => $row[7],
                    ]
                );

                Log::info("Imported row " . ($index + 2) . ": " . $row[5]);
                $imported++;
            } catch (\Throwable $e) {
                Log::error("Failed row " . ($index + 2) . ": " . $e->getMessage(), ['row' => $row]);
            }
        }

        Log::info("Product import complete. Successfully imported: $imported");
    }
      public function chunkSize(): int
    {
        return 100;
    }
}
