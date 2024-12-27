<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
  use HasFactory;
  protected $fillable = ['quantity', 'image'];
  protected $casts = [
    'image' => 'array', // Chuyển đổi trường images thành mảng
  ];
  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }
}
