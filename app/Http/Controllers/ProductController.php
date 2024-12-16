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
        $products = auth()->user()
            ->products()
            ->with('category')
            ->where(function ($query) {
                if ($search = request('search')) {
                    $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                }
            })
            ->when(!request()->query('sort_by'), function ($query) {
                $query->latest();
            })
            ->when(in_array(request()->query('sort_by'), ['name', 'price', 'weight']), function ($query) {
                $sortBy = request('sort_by');
                $direction = $sortBy[0] === '-' ? 'desc' : 'asc';
                $field = ltrim($sortBy, '-');
                $query->orderBy($field, $direction);
            })
            ->paginate(10)
            ->withQueryString();

        return inertia('Product/Index', [
            'products' => ProductResource::collection($products),
            'query' => (object) request()->query(),
            'categories' => CategoryResource::collection(Category::orderBy('name')->get()),
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

    public function bulkDestroy(string $ids)
    {
        $ids = explode(',', $ids);
        Product::destroy($ids);

        return redirect()
            ->route('products.index')
            ->with('message', 'Selected products deleted successfully.');
    }
}
