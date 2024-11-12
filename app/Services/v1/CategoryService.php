<?php

namespace App\Services\v1;

use App\Core\ServiceResponse;
use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Models\User;

class CategoryService
{
    // public User $users;

    public function __construct(public Category $category) {}

    public function getAll(): ServiceResponse
    {
        $categories = $this->category->with('childCategories')->where('parent_id', null)->get();
        return new ServiceResponse(true, 'Categories found', ['categories' => $categories], 200);
    }

    public function getById(int $id): ServiceResponse
    {
        $category = $this->category->with('childCategories')->find($id);
        if (!$category) {
            return new ServiceResponse(false, 'Category not found', null, 404);
        }
        return new ServiceResponse(true, 'Category found', ['category' => $category], 200);
    }

    public function createDTO(CategoryDTO $categoryDTO): ServiceResponse
    {
        $category = $this->category;
        $category->name = $categoryDTO->name;
        $category->slug = $categoryDTO->slug;
        $category->parent_id = $categoryDTO->parent_id;
        $category->user_id = auth('api')->user()->id;
        $category->save();

        return new ServiceResponse(true, 'Category created successfully', ['category' => $category], 200);
    }

    public function create(string $name, string $slug, int $parent_id = null): ServiceResponse
    {
        $category = $this->category->create([
            'name' => $name,
            'slug' => $slug,
            'parent_id' => $parent_id,
            'user_id' => auth('api')->user()->id
        ]);

        return new ServiceResponse(true, 'Category created successfully', ['category' => $category], 200);
    }

    public function updateDTO(int $id, CategoryDTO $categoryDTO): ServiceResponse
    {
        $category = $this->category->find($id);
        if (!$category) {
            return new ServiceResponse(false, 'Category not found', null, 404);
        }
        $category->name = $categoryDTO->name;
        $category->slug = $categoryDTO->slug;
        $category->parent_id = $categoryDTO->parent_id;

        $category->save();

        return new ServiceResponse(true, 'Category updated successfully', ['category' => $category], 200);
    }

    public function update(int $id, string $name, string $slug, int $parent_id = null): ServiceResponse
    {
        $category = $this->category->find($id);
        if (!$category) {
            return new ServiceResponse(false, 'Category not found', null, 404);
        }

        $category->name = $name;
        $category->slug = $slug;
        $category->parent_id = $parent_id;
        $category->save();

        return new ServiceResponse(true, 'Category updated successfully', ['category' => $category], 200);
    }

    public function delete(int $id): ServiceResponse
    {
        $category = $this->category->find($id);
        if (!$category) {
            return new ServiceResponse(false, 'Category not found', null, 404);
        }

        $category->delete();

        return new ServiceResponse(true, 'Category deleted successfully', null, 200);
    }
}
