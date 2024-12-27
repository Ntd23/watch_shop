<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'price', 'inventory', 'description'];

  public function product_details()
  {
    return $this->hasMany(ProductDetail::class);
  }
}
