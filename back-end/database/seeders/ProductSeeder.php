<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Product::create([
      'name' => Str::random(100),
      'price' => '100000',
      'inventory' => 10,
      'description' => Str::random(1000)
    ]);
  }
}
