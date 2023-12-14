@extends('base')

@section('title', 'Track '.$track->title.' partagée')
@section('content')
<div class="d-flex justify-content-end w-100">
    <!-- TODO: implement modify -->
        @if(Auth::user()->id === $track->user_id)
            <form action="{{ route('track.admin.delete', ['track' => $track]) }}"
                  method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">Supprimer la track</button>
            </form>

        @endif
    </div>
    <figure class="d-flex flex-column justify-content-center align-items-center mw-25 p-4">

        <h1>{{$track->title}}</h1>
        {{--            @dd(Storage::disk('users-data')->getVisibility(auth()->user()->name ."/". $track->image))--}}

        @if($track->image)
            <img
                class="my-2"
                style="object-fit:cover;border: 3px ridge grey;border-radius:10px;"
                src="{{asset("storage/user-asset/$track->image")}}" alt="resource_illustration">
        @else
            <img class="my-2"
                style="object-fit:cover;border: 3px ridge grey;border-radius:10px;width:300px;height:200px"
                 src="{{asset("storage/soundstore_default_preview_track.jpg")}}" alt="resource_illustration">
        @endif
        @if($track->description)
            <p class="text-center p-3">{{$track->description}}</p>
        @endif

        <audio style="border: 10px ridge grey;border-radius:300px;" controls
               src="{{asset("storage/user-asset/$track->music")}}" type="audio/mpeg">
            <a href="{{asset("storage/user-asset/$track->music")}}">Download audio</a>
        </audio>
    </figure>

    @if(Auth::user()->id !== $track->user_id)
        <div class="d-flex flex-column justify-content-center my-2">
            @auth
                <form action="{{ route('track.feedback', ['track' => $track->id]) }}" method="post">
                    @method('post')
                    @csrf
                    <h3>Feedback</h3>
                    <x-input name="message" placeholder="Nice ! 🔥🔥🔥" area="{{true}}"/>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-info">Poster le feedback</button>
                    </div>
                </form>

            @endauth

        </div>
    @endif

    <div class="d-flex justify-content-center">
        <section>
            <div class="container my-5 py-5 text-dark">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-11 col-lg-9 col-xl-7">

                        @for($i = 0; $i < count($feedbacks); $i++)
                            <div class="d-flex flex-start my-2">
                                <img class="rounded-circle shadow-1-strong me-3"
                                     src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(27).webp" alt="avatar"
                                     width="65"
                                     height="65"/>
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <div class="">
                                            <h5>{{$feedbacks[$i]->user->name}}</h5>
                                            <p class="small">{{$feedback_elapsed_time[$i]}}</p>
                                            <p style="width: 1000px;">{{$feedbacks[$i]->message}}</p>
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
