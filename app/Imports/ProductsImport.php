<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Buat kategori jika perlu
        $category = null;
        if (!empty($row['category_slug'])) {
            $category = Category::firstOrCreate(
                ['slug' => $row['category_slug']],
                ['name' => ucwords(str_replace('-', ' ', $row['category_slug']))]
            );
        }

        // Cek stok lama
        $existing = Product::where('sku', $row['sku'])->first();

        $currentStock = $existing ? $existing->stock : 0;
        $addedStock   = is_numeric($row['stock']) ? (int)$row['stock'] : 0;

        // Stok akhir = stok lama + stok di excel
        $newStock = $currentStock + $addedStock;

        // Update or insert
        Product::updateOrCreate(
            ['sku' => $row['sku']],
            [
                'name'        => $row['name'],
                'description' => $row['description'] ?? null,
                'price'       => $row['price'] ?? 0,
                'stock'       => $newStock,
                'category_id' => $category ? $category->id : null
            ]
        );

        return null; // penting! supaya tidak bikin baris kosong
    }
}
