<?php

namespace App\Http\Requests\Api\ProductController\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', "unique:products,slug", 'max:255'],
            'category_id' => ['required', 'integer'],
            'price' => ['required', 'decimal:2,10'],
            'stock' => ['required', 'integer'],
        ];
    }
}