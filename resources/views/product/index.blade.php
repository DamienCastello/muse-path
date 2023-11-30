@extends('base')

@section('title', 'Produits')

@section('content')

    <h1 class="text-center">Liste des produits</h1>

    <div class="row mb-5">
        <div class="col-4 offset-8">
            <form action="" method="get" >
                <div class="d-flex flex-column align-items-end">
                    @include('shared.input', ['name' => 'title', 'placeholder' => "Mot clef"])
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
        </div>
    </div>



    @forelse($products as $product)
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
    @empty
        <p class="text-center">Aucun produit ne correspond à la recherche</p>
    @endforelse
    <div class="fixed-bottom">
        {{$products->links()}}
    </div>
@endsection
