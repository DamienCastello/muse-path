@extends('base')

@section('title', 'Partage de tracks')

@section('content')

    <h1 class="text-center">Partage des Tracks en cours de production</h1>

    <div class="row mb-5">
        <div class="col-4">
            <div class="d-flex justify-content-center align-items-center h-100">
                <a href="{{ route('track.admin.create') }}" class="btn btn-primary">Partager une track</a>
            </div>
        </div>
        <div class="col-4 offset-4">
            <form action="" method="get">
                <div class="d-flex flex-column align-items-end">
                    @include('shared.input', ['name' => 'title', 'placeholder' => "Mot clef"])
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-center row">
        @forelse($tracks as $track)

            <div class="card col-3 m-1" style="background-color:#000000;
                    background-image:url('https://www.transparenttextures.com/patterns/brushed-alum.png');
                    border: 5px ridge grey;border-radius:30px;width: 18rem;">

                <div class="card-body">
                    <a style="color:#e7effd;text-decoration:none;font-weight: bold;font-size: 1.2rem;"
                       href="{{ route("track.show", ['track' => $track->id]) }}">
                        @if($track->image)
                            <img style="border: 2px ridge black;border-radius:30px;" class="card-img-top"
                                 src="{{asset("storage/user-asset/$track->image")}}" alt="Card track preview">
                        @else
                            <img class="my-2"
                                 style="object-fit:cover;border: 3px ridge grey;border-radius:10px;width:300px;height:200px"
                                 src="{{asset("storage/soundstore_default_preview_track.jpg")}}"
                                 alt="resource_illustration">
                        @endif

                        {{$track->title}}
                    </a>
                    <div>
                      <span class="mr-3">
                            @if(!$track->genres->isEmpty())
                              @foreach($track->genres as $genre)
                                  <span class="badge badge-secondary">{{$genre->name}}</span>
                              @endforeach
                             @endif
                      </span>
                    </div>
                </div>
            </div>

        @empty
            <p class="text-center">Aucune track ne correspond à votre recherche</p>
        @endforelse
    </div>

@endsection
