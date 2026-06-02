<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductType\StoreProductTypeRequest;
use App\Http\Requests\ProductType\UpdateProductTypeRequest;
use App\Models\ProductType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductTypeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();

        $productTypes = ProductType::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orderBy('id_product_type')
            ->paginate(10)
            ->withQueryString();

        return view('features.product-types.index', compact('productTypes', 'search'));
    }

    public function create(): View
    {
        return view('features.product-types.create');
    }

    public function store(StoreProductTypeRequest $request): RedirectResponse
    {
        ProductType::query()->create($request->validated());

        return redirect()
            ->route('product-types.index')
            ->with('success', 'Jenis produk berhasil ditambahkan.');
    }

    public function show(ProductType $productType): View
    {
        return view('features.product-types.show', compact('productType'));
    }

    public function edit(ProductType $productType): View
    {
        return view('features.product-types.edit', compact('productType'));
    }

    public function update(UpdateProductTypeRequest $request, ProductType $productType): RedirectResponse
    {
        $productType->update($request->validated());

        return redirect()
            ->route('product-types.index')
            ->with('success', 'Jenis produk berhasil diperbarui.');
    }

    public function destroy(ProductType $productType): RedirectResponse
    {
        $productType->delete();

        return redirect()
            ->route('product-types.index')
            ->with('success', 'Jenis produk berhasil dihapus.');
    }
}
