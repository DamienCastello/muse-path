@extends('base')

@section('title', $resource->title)
@section('content')
    <article>
        <div class="d-flex flex-column justify-content-center align-items-center mb-1">
            <h1 class="mb-3">{{$resource->title}}</h1>
            @if($resource->link)
                <p>
                    <a href="{{$resource->link}}" class="nav-link">Site de la ressource</a>
                </p>
            @endif
            @if($resource->image)
                <img style="object-fit:cover;border: 3px ridge grey;border-radius:10px;box-shadow:5px 2px 5px black;"
                     src="{{$resource->imageUrl()}}" alt="resource_illustration">
            @endif
        </div>
        <p class="mt-3">{{$resource->description}}</p>
    </article>
    <div class="d-flex justify-content-start align-items-center mb-5">
        <p class="font-italic mr-3">Ressource créée par : </p>
        <a href="{{ route('user.contact', ['user' => $resource->user, 'resource' => $resource]) }}">
            <img class="rounded-circle shadow-1-strong me-3 mr-3"
                 src="{{$avatar}}" alt="avatar" width="65"
                 height="65"/>
        </a>
        <p class="font-weight-bold">{{$resource->user->name}}</p>
    </div>

    <div class="d-flex justify-content-between">
        @auth
            <p>
                <a href="{{ route('resource.admin.edit', ['slug' => $resource->slug, 'resource' => $resource]) }}"
                   class="btn btn-primary">Modifier la ressource</a>
            </p>
            <form action="{{ route('resource.admin.delete', ['slug' => $resource->slug, 'resource' => $resource]) }}"
                  method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">Supprimer la ressource</button>
            </form>

        @endauth
    </div>


    <div class="d-flex flex-column justify-content-center mt-2">
        @auth
            <form action="{{ route('resource.comment', ['slug' => $resource->slug, 'resource' => $resource]) }}"
                  method="post">
                @method('post')
                @csrf
                <x-input label="Commentaire" name="content" placeholder="Super merci !" area="{{true}}"/>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-info">Poster le commentaire</button>
                </div>
            </form>

        @endauth

    </div>
    <div class="d-flex justify-content-center mt-3">
        <section>
            <div class="container my-5 py-5 text-dark">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-11 col-lg-9 col-xl-7">
                        @for($i = 0; $i < count($comments); $i++)

                            <div class="d-flex flex-start my-2">
                                <img class="rounded-circle shadow-1-strong me-3"
                                     src="{{asset(str_contains("soundstore_default_preview_track.jpg", $comments[$i]->user->avatar) ? 'storage/'.$comments[$i]->user->avatar : 'storage/user-asset/'.$comments[$i]->user->avatar)}}" alt="avatar"
                                     width="65"
                                     height="65"/>
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <div class="">
                                            <h5>{{$comments[$i]->user->name}}</h5>
                                            <p class="small">{{$comment_elapsed_time[$i]}}</p>
                                            <p style="width: 1000px;">{{$comments[$i]->content}}</p>

                                            <!-- TODO: Implement reply & like comment
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <a href="#!" class="link-muted me-2 mr-3"><i
                                                            class="fas fa-thumbs-up me-1"></i>158 likes</a>
                                                    <a href="#!" class="link-muted"><i
                                                            class="fas fa-thumbs-down me-1"></i>13 unlikes</a>
                                                </div>
                                                <a href="#!" class="link-muted"><i class="fas fa-reply me-1"></i>Répondre</a>
                                            </div>
                                            -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
