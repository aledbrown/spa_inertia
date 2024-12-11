<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->latest()->paginate(10);
        return inertia('Product/Index', [
            'products' => ProductResource::collection($products)
        ]);
    }

    public function create()
    {
        return inertia('Product/Create', [
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $request->user()->products()->create($request->validated());
        return redirect()
            ->route('products.index')
            ->with('message', 'Product has been created successfully.');
    }

    public function show(Product $product)
    {
        return inertia('Product/Show', [
            'product' => ProductResource::make($product)
        ]);
    }

    public function edit(Product $product)
    {
        return inertia('Product/Edit', [
            'product' => ProductResource::make($product),
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()
            ->route('products.index')
            ->with('message', 'Product has been updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()
            ->route('products.index')
            ->with('message', 'Product has been deleted successfully.');
    }
}
