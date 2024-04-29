<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'user')->get();
        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
            ]
        ]);
    }

    public function getProduct($productId)
    {
        $product = Product::with('category', 'user')->where('id', $productId)->get();
        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
            ]
        ]);
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::with('user')->where('category_id', $categoryId)->get();
        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
            ],
        ]);
    }

    public function create(CreateProductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'user_id' => $request->user()->id,
            'category_id' => $data['category_id'],
        ]);
        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
            ],
        ]);
    }

    public function update($productId, UpdateProductRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $product = Product::where('id', $productId)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'data' => [
                    'error' => 'Product with id ' . $productId . ' does not exists',
                ]
            ]);
        }

        if ($product->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'data' => [
                    'error' => 'User can update only own products',
                ]
            ]);
        }
        $product->fill($data)->save();
        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
            ],
        ]);
    }

    // ? middleware('guest')
}
