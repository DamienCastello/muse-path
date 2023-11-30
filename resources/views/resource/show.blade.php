@extends('base')

@section('title', $resource->title)
@section('content')
        <article>
            <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                <h1 class="mb-3">{{$resource->title}}</h1>
                @if($resource->link)
                <p>
                    <a href="{{$resource->link}}" class="nav-link">Site de la ressource</a>
                </p>
                @endif
                @if($resource->image)
                    <img style="object-fit:cover;border: 3px ridge grey;border-radius:10px;box-shadow:5px 2px 5px black;" src="{{$resource->imageUrl()}}" alt="resource_illustration">
                @endif
            </div>
            <p class="mt-3">{{$resource->description}}</p>
        </article>

        <div class="d-flex justify-content-between">
            @auth
                <p>
                    <a href="{{ route('resource.admin.edit', ['slug' => $resource->slug, 'resource' => $resource]) }}" class="btn btn-primary">Modifier la ressource</a>
                </p>
                <form action="{{ route('resource.admin.delete', ['slug' => $resource->slug, 'resource' => $resource]) }}" method="post">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Supprimer la ressource</button>
                </form>

            @endauth
        </div>
@endsection
