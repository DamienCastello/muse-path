<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormPostRequest;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('product.index', [
            'products' => Product::paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        return view('product.create', [
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormPostRequest $request)
    {
        $product = Product::create($request->validated());
        return redirect()->route('product.show', ['slug' => $product->slug, 'product' => $product->id])->with('success', 'Le produit a bien été sauvegardé');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, Product $product): RedirectResponse | View
    {
        if ($product->slug != $slug){
            return to_route('product.show', ['slug' => $product->slug, 'product' => $product->id]);
        }
        return view('product.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($productId)
    {
       $product = Product::query()->where('id', $productId)->first();
        return view('product.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormPostRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('product.show', ['slug' => $product->slug, 'product' => $product->id])->with('success', 'Le produit a bien été modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
