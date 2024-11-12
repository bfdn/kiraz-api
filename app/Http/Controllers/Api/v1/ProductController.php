<?php

namespace App\Http\Controllers\Api\v1;

use App\Core\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductController\v1\ProductDestroyRequest;
use App\Http\Requests\Api\ProductController\v1\ProductIndexRequest;
use App\Http\Requests\Api\ProductController\v1\ProductShowRequest;
use App\Http\Requests\Api\ProductController\v1\ProductStoreRequest;
use App\Http\Requests\Api\ProductController\v1\ProductUpdateRequest;
use App\Models\Product;
use App\Services\v1\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HttpResponse;

    public function __construct(private ProductService $productService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ProductIndexRequest $request)
    {
        $response = $this->productService->getAll();
        return $this->httpResponse($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        \DB::beginTransaction();
        try {
            $response = $this->productService->create(
                $request->name,
                $request->slug,
                $request->category_id,
                $request->price,
                $request->stock
            );

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductShowRequest $request, string $id)
    {
        $response = $this->productService->getById($id);
        return $this->httpResponse($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        \DB::beginTransaction();
        try {
            $response = $this->productService->update(
                $id,
                $request->name,
                $request->slug,
                $request->category_id,
                $request->price,
                $request->stock
            );

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDestroyRequest $request, string $id)
    {
        \DB::beginTransaction();
        try {
            $response = $this->productService->delete($id);

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
        }
    }
}
