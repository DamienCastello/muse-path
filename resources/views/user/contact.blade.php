@extends('base')

@section('title', 'USER')
@section('content')

        <article>
            <div class="d-flex flex-column justify-content-center align-items-center mb-1">
                <h1 class="mb-3">{{$user->name}}</h1>
                <img class="rounded-circle shadow-1-strong me-3 mr-3"
                        src="{{$avatar}}" alt="avatar" width="200"
                        height="200" />
            </div>
            <form action="{{ route('user.contact', ['user' => $user, 'resource' => $resource]) }}" method="post" class="vstack gap-2" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                @endif
                <div class="row">
                    <div class="col">
                        @include('shared.input',['label' => 'Message', 'name' => 'message', 'placeholder' => 'Ton message', 'area' => true])
                    </div>
                </div>



                <button type="submit" class="btn btn-primary mb-2">
                    Envoyer
                </button>
            </form>
        </article>

@endsection
