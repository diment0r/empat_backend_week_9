<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
            ],
        ]);
    }

    public function getCategory($categoryId)
    {
        $category = Category::where('id', $categoryId)->first();
        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
            ],
        ]);
    }

    public function create(CreateCategoryRequest $request)
    {
        $request->validated();
        $category = Category::create(['name' => $request->name]);
        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
            ],
        ]);
    }

    public function update($categoryId, UpdateCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::where('id', $categoryId)->first();
        if (!$category) {
            return response()->json([
                'success' => false,
                'data' => [
                    'error' => 'Category with id ' . $categoryId . ' does not exists',
                ]
            ]);
        }
        $category->fill($data)->save();
        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
            ],
        ]);
    }
}
