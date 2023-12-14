<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Sandbox  S T 0 R E - @yield('title')</title>
    <!--//////////// Test display react view ///////////
        @//viteReactRefresh
        @//vite('resources/js/app.jsx')
    /////////////////////////////////////////////////-->

    <style>
        .container{
            margin-top: 7rem;
        }
    </style>
</head>
<body>

@php
$routeName = request()->route()->getName();
@endphp

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand link-light" href="{{ route('resource.index') }}">SOUNDSTORE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            @auth
            <a @class(["nav-link", "active" => str_starts_with($routeName, 'resource.')]) href="{{ route('resource.admin.create') }}">Ajouter Ressource<span class="sr-only"></span></a>
            @endauth
        </li>
      </ul>
        <div class="navbar-nav mb-lg-0">
            <div class="flex-column">
                @auth
                    <p class="text-warning">{{ \Illuminate\Support\Facades\Auth::user()->name }}</p>
                    <form action="{{ route('auth.logout') }}" method="post" class="nav-item">
                        @method('delete')
                        @csrf
                        <button class="btn btn-info">Se déconnecter</button>
                    </form>
                @endauth
                @guest
                        <a class="btn btn-info" href={{ route('auth.login') }}>Se connecter</a>
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
