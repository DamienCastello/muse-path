@extends('base')

@section('title', 'Produits')

@section('content')
    <h1>Liste des produits</h1>

    @foreach($products as $product)
        <article>
            <h2>{{$product->title}}</h2>
            <p>{{$product->description}}</p>
            <p>
                <a href="{{ route('product.show', ['slug' => $product->slug, 'id' => $product->id]) }}" class="btn btn-primary">Lire la suite</a>
            </p>
        </article>
    @endforeach

    {{$products->links()}}
@endsection
