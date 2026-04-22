<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        $makanan = Category::query()->create(['name' => 'Makanan']);
        $minuman = Category::query()->create(['name' => 'Minuman']);

        Item::query()->create([
            'category_id' => $makanan->id,
            'name' => 'Nasi Goreng',
            'price' => 25000,
            'stock' => 50,
        ]);
        Item::query()->create([
            'category_id' => $makanan->id,
            'name' => 'Mie Goreng',
            'price' => 22000,
            'stock' => 40,
        ]);
        Item::query()->create([
            'category_id' => $minuman->id,
            'name' => 'Es Teh',
            'price' => 5000,
            'stock' => 100,
        ]);
        Item::query()->create([
            'category_id' => $minuman->id,
            'name' => 'Es Jeruk',
            'price' => 8000,
            'stock' => 80,
        ]);
    }
}
