<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return new ProductResource(Product::with(['product_details'])->all());
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CreateOrUpdateProductRequest $request)
  {
    $validated = $request->validated();
    $images = $validated['image'];

    $product = Product::create([
      'name' => $validated['name'],
      'price' => $validated['price'],
      'inventory' => $validated['inventory'],
      'description' => $validated['description'],
    ]);

    $product_detail = new ProductDetail();
    $product_detail->product_id = $product->id;
    $product_detail->quantity = $validated['quantity'];
    $imageLinks = $this->saveImages($images);
    $product_detail->image = json_encode($imageLinks);
    $product_detail->save();

    return new ProductResource($product->product_details()->get());
  }
  private function saveImages($images)
  {
    $imageLinks = [];
    foreach ($images as $image) {
      $path = $image->store('products/', 'public');
      $imageLinks[] = Storage::url($path);
    }
    return $imageLinks;
  }
  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CreateOrUpdateProductRequest $request, Product $product)
  {
    $validated = $request->validated();
    $images = $validated['image'];
    $imageLinks = $this->saveImages($images);
    $product->update([
      'name' => $validated['name'],
      'price' => $validated['price'],
      'inventory' => $validated['inventory'],
      'description' => $validated['description'],
    ]);
    $product->product_details()->update([
      'image' => json_encode($imageLinks),
      'quantity' => $validated['quantity']
    ]);

    return new ProductResource($product->product_details()->get());
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
