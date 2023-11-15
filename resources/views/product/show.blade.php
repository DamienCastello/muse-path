@extends('base')

@section('title', $product->title)

@section('content')
        <article>
            <h1>{{$product->title}}</h1>
            <p>{{$product->description}}</p>
        </article>

        <p>
            <a href="{{ route('product.edit', ['slug' => $product->slug, 'product' => $product->id]) }}" class="btn btn-primary">Modifier le produit</a>
        </p>
@endsection
