@extends('base')

@section('title', $product->title)
@section('content')
        <article>
            <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                <h1 class="mb-3">{{$product->title}}</h1>
                @if($product->image)
                    <img style="object-fit:cover;border: 3px ridge grey;border-radius:10px;box-shadow:5px 2px 5px black;" src="{{$product->imageUrl()}}" alt="product_illustration">
                @endif
            </div>
            <p class="mt-3">{{$product->description}}</p>
        </article>

        <p>
            <a href="{{ route('product.edit', ['slug' => $product->slug, 'product' => $product]) }}" class="btn btn-primary">Modifier le produit</a>
        </p>
@endsection
