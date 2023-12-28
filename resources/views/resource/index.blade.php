@extends('base')

@section('title', 'Ressources')

@section('content')

    <h1 class="text-center">Liste des ressources</h1>

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



    @forelse($resources as $resource)

        @php
            $liked = $resource->users()->pluck('id')->contains(function (int $value) {
                return $value === Auth::user()->id ? true : false;
            })
        @endphp

        <article>
            <h2>{{$resource->title}}</h2>
            <p class="small">
                Catégorie: <strong>{{ $resource->category->name }}</strong>
                <span class="ml-3">
                    @if(!$resource->tags->isEmpty())
                        Tags:
                        @foreach($resource->tags as $tag)
                            <span class="badge badge-secondary">{{$tag->name}}</span>
                        @endforeach
                    @endif
                </span>
                <span class="ml-3">
                    {{$liked ? 'Liké <3' : ''}}
                </span>
            </p>



            <div class="flex-col justify-content-center">
                @if($resource->image)
                    <img style="object-fit:cover;border: 3px ridge grey;border-radius:10px;box-shadow:5px 2px 5px black;" src="{{$resource->imageUrl()}}" alt="resource_illustration">
                @endif
                <p class="mt-3">{{$resource->description}}</p>
            </div>
            <div class="d-flex justify-content-between">
                <p>
                    <a href="{{ route('resource.show', ['slug' => $resource->slug, 'resource' => $resource]) }}" class="btn btn-primary">Lire la suite</a>
                </p>

                @auth
                <form action="{{ route('resource.admin.like', ['resource' => $resource]) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="form-check form-switch">
                        <input class="invisible" type="hidden" value="{{$liked}}" name="like" role="switch" id="like">
                    </div>
                    <button type="submit" @class(["btn", $liked ? 'fa-solid fa-heart btn-like' : 'fa-regular fa-heart btn-unlike']) @error('like') is-invalid @enderror></button>
                </form>
                @endauth
            </div>

        </article>
    @empty
        <p class="text-center">Aucune ressource ne correspond à la recherche</p>
    @endforelse
    <div class="fixed-bottom">
        {{$resources->links()}}
    </div>
@endsection
