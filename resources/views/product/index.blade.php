@extends('base')

@section('title', 'Produits')

@section('content')

        <div class="row">
          <div class="col-6 offset-4">
              <h1>Liste des produits</h1>
          </div>
          <div class="col-2">
              <p>
                  <a href="{{ route('product.create') }}" class="btn btn-primary">Ajouter un produit</a>
              </p>
          </div>
        </div>

    @foreach($products as $product)
        <article>
            <h2>{{$product->title}}</h2>
            <p class="small">
                Catégorie: <strong>{{ $product->category->name }}</strong>
                <span class="ml-3">
                    @if(!$product->tags->isEmpty())
                        Tags:
                        @foreach($product->tags as $tag)
                            <span class="badge badge-secondary">{{$tag->name}}</span>
                        @endforeach
                    @endif
                </span>
            </p>

            <div class="flex-col justify-content-center">
                @if($product->image)
                    <img style="object-fit:cover;border: 3px ridge grey;border-radius:10px;box-shadow:5px 2px 5px black;" src="{{$product->imageUrl()}}" alt="product_illustration">
                @endif
                <p class="mt-3">{{$product->description}}</p>
            </div>
            <p>
                <a href="{{ route('product.show', ['slug' => $product->slug, 'product' => $product]) }}" class="btn btn-primary">Lire la suite</a>
            </p>
        </article>
    @endforeach
    <div class="fixed-bottom">
        {{$products->links()}}
    </div>
@endsection
