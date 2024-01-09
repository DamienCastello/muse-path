<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>


    <title>Sandbox S T 0 R E - @yield('title')</title>
    <!--//////////// Test display react view ///////////
        @//viteReactRefresh
        @//vite('resources/js/app.jsx')
    /////////////////////////////////////////////////-->

    <style>
        .container {
            margin-top: 10rem;
        }

        i {

            font-size: 20px !important;

            padding: 10px;

        }
    </style>
</head>
<body style="background-color: #e7effd;">

@php
    $routeName = request()->route()->getName();

    $user = \App\Models\User::query()->find(Auth::user()->id);
    $avatar = asset("/storage/".$user->avatar);
    if($user->avatar !== "soundstore_default_preview_track.jpg"){
        $avatar = asset("storage/user-asset/$user->avatar");
    }
@endphp

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand link-light" href="{{ route('resource.index') }}">SOUNDSTORE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mr-3">
                    @auth
                        <a @class(["nav-link", "active" => $routeName === 'resource.index' || $routeName === 'resource.show']) href="{{ route('resource.index') }}">Ressources<span
                                class="sr-only"></span></a>
                    @endauth
                </li>
                <li class="nav-item mr-3">
                    @auth
                        <a @class(["nav-link", "active" => $routeName === "track.index" || $routeName === 'track.show']) href="{{ route('track.index') }}">Tracks<span
                                class="sr-only"></span></a>
                    @endauth
                </li>
                <li class="nav-item mr-3">
                    @auth
                        <a @class(["nav-link", "active" => str_starts_with($routeName, 'upload') || $routeName === 'resource.admin.create' || $routeName === 'track.admin.create']) href="{{ route(Auth::user()->role !== 'artist' ? "resource.admin.create" : 'upload.index') }}">Upload<span
                                class="sr-only"></span></a>
                    @endauth
                </li>
                <li class="nav-item mr-3">
                    @auth
                        <a @class(["nav-link", "active" => str_starts_with($routeName, 'notification.')]) href="{{ route('notification.index') }}">Notifications<span
                                class="sr-only"></span></a>
                    @endauth
                </li>
            </ul>


            <div class="navbar-nav mb-lg-0">
                <div class="flex-column">
                    @auth
                        <div class="flex-row">
                            <img src="{{$avatar}}" class="m-2"
                                 style="width: 50px; height: 50px; border: #4b5563 ridge 2px; border-radius: 50%;">
                            <a href="{{route('profile.edit')}}"
                               class="text-warning">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                        </div>
                        <form action="{{ route('logout') }}" method="post" class="nav-item">
                            @method('post')
                            @csrf
                            <button class="btn btn-info mt-2">Se déconnecter</button>
                        </form>
                    @endauth
                    @guest
                        <a class="btn btn-info" href={{ route('login') }}>Se connecter</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>

<!--//////////// Test display react view ///////////
    <div id="app"></div>
/////////////////////////////////////////////////-->
<div class="container">
    @if(session('success'))
        <x-alert type="success" class="fw-bold">
            {{ session('success') }}
        </x-alert>
    @endif
    @yield('content')
</div>
</body>
</html>
