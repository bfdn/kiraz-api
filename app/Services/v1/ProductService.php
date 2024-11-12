<?php

namespace App\Services\v1;

use App\Core\ServiceResponse;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    // public User $users;

    public function __construct(public Product $product) {}

    public function getAll(): ServiceResponse
    {
        $products = Cache::remember('products', 3600, function () {
            return $this->product->with('category')->get();
        });
        return new ServiceResponse(true, 'Products found', ['products' => $products], 200);
    }

    public function getById(int $id): ServiceResponse
    {
        $product = $this->product->with('category')->find($id);
        if (!$product) {
            return new ServiceResponse(false, 'Product not found', null, 404);
        }
        return new ServiceResponse(true, 'Product found', ['product' => $product], 200);
    }

    public function create(string $name, string $slug, int $category_id, int $price, int $stock): ServiceResponse
    {
        $product = $this->product->create([
            'name' => $name,
            'slug' => $slug,
            'category_id' => $category_id,
            'price' => $price,
            'stock' => $stock,
            'user_id' => auth('api')->user()->id
        ]);

        return new ServiceResponse(true, 'Product created successfully', ['product' => $product], 200);
    }

    public function update(int $id, string $name, string $slug, int $category_id, int $price, int $stock): ServiceResponse
    {
        $product = $this->product->find($id);
        if (!$product) {
            return new ServiceResponse(false, 'Product not found', null, 404);
        }

        $product->name = $name;
        $product->slug = $slug;
        $product->category_id = $category_id;
        $product->price = $price;
        $product->stock = $stock;
        $product->save();

        return new ServiceResponse(true, 'Product updated successfully', ['product' => $product], 200);
    }

    public function delete(int $id): ServiceResponse
    {
        $product = $this->product->find($id);
        if (!$product) {
            return new ServiceResponse(false, 'Product not found', null, 404);
        }

        $product->delete();
        return new ServiceResponse(true, 'Product deleted successfully', null, 200);
    }
}
