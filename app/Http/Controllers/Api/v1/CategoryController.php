<?php

namespace App\Http\Controllers\Api\v1;

use App\Core\HttpResponse;
use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryController\v1\CategoryDestroyRequest;
use App\Http\Requests\Api\CategoryController\v1\CategoryIndexRequest;
use App\Http\Requests\Api\CategoryController\v1\CategoryShowRequest;
use App\Http\Requests\Api\CategoryController\v1\CategoryStoreRequest;
use App\Http\Requests\Api\CategoryController\v1\CategoryUpdateRequest;
use App\Services\v1\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use HttpResponse;

    public function __construct(private CategoryService $categoryService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(CategoryIndexRequest $request)
    {
        $response = $this->categoryService->getAll();
        return $this->httpResponse($response);
    }

    public function storeDTO(CategoryStoreRequest $request)
    {
        \DB::beginTransaction();
        try {
            $categoryDTO = new CategoryDTO(
                name: $request->name,
                slug: $request->slug,
                parent_id: $request->parent_id
            );

            $response = $this->categoryService->createDTO($categoryDTO);

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        \DB::beginTransaction();
        try {
            $response = $this->categoryService->create(
                $request->name,
                $request->slug,
                $request->parent_id
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
    public function show(CategoryShowRequest $request, int $id)
    {
        $response = $this->categoryService->getById($id);
        return $this->httpResponse($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, int $id)
    {
        \DB::beginTransaction();
        try {
            $response = $this->categoryService->update(
                $id,
                $request->name,
                $request->slug,
                $request->parent_id
            );

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
        }
    }

    public function updateDTO(CategoryUpdateRequest $request, int $id)
    {
        \DB::beginTransaction();
        try {
            $response = $this->categoryService->updateDTO(
                $id,
                new CategoryDTO(
                    name: $request->name,
                    slug: $request->slug,
                    parent_id: $request->parent_id
                )
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
    public function destroy(CategoryDestroyRequest $request, int $id)
    {
        \DB::beginTransaction();
        try {
            $response = $this->categoryService->delete($id);

            \DB::commit();
            return $this->httpResponse($response);
        } catch (\Throwable $th) {
            \DB::rollBack();
        }
    }
}
