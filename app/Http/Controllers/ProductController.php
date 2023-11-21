<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormPostRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image as ResizeImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('product.index', [
            'products' => Product::with('tags', 'category')->orderBy('created_at', 'desc')->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();
        return view('product.create', [
            'product' => $product,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get(),
            'post' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormPostRequest $request)
    {
        $product = Product::create($this->extractData(new Product(), $request));
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
    public function edit($productID)
    {
       $product = Product::query()->where('id', $productID)->first();
        return view('product.edit', [
            'product' => $product,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get(),
            'post' => false,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormPostRequest $request, Product $product)
    {
        $product->update($this->extractData($product, $request));
        $product->tags()->sync($request->validated('tags'));
        return redirect()->route('product.show', ['slug' => $product->slug, 'product' => $product->id])->with('success', 'Le produit a bien été modifié');
    }

    private function extractData(Product $product, FormPostRequest $request):array
    {
        $image = $request->validated('image');
        $data = $request->validated();

        if($image === null) {
            return $data;
        } else {
            $path = public_path('storage\\product\\');
            $name = time() . '.' . $request->image->extension();
            ResizeImage::make($request->file('image'))
                ->resize(300, 200)
                ->save($path . $name);

            $img = ResizeImage::make('storage\\product\\'.$name);


            if($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = 'product/'.$img->basename;
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        $product->delete();
        return to_route('product.index')->with('success', 'Le produit a bien été supprimé');
    }
}
