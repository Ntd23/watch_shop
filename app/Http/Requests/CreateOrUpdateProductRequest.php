<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateProductRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    $rules = [
      'name' => 'required|string',
      'price' => 'required|string',
      'inventory' => 'required|integer',
      'description' => 'string|max:300',
      'quantity' =>  'required|integer',
      'image.*' => 'required|mimes:png,jpg,pdf,jpeg,webp|max:30720'
    ];
    if (in_array($this->method(), ['PUT', 'PATCH'])) {
      $rules['name'] = 'string';
      $rules['price'] = 'string';
      $rules['inventory'] = 'integer';
      $rules['quantity'] = 'integer';
      $rules['image.*'] = 'mimes:png,jpg,pdf,jpeg,webp|max:30720';
    }
    return $rules;
  }
}
