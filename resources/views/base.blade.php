<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Sandbox  S T 0 R E - @yield('title')</title>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>

@php
$routeName = request()->route()->getName();
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('product.index') }}">SANDBOX STORE</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <a @class(["nav-link", "active" => str_starts_with($routeName, 'product.')]) href="{{ route('product.create') }}">Ajouter Produit<span class="sr-only"></span></a>



            <!--
            <li @class(["nav-item", 'active' => str_starts_with($routeName, 'product.')])>
              <a href="{{ route('product.index') }}">Ajouter Produit<span class="sr-only"></span></a>
            </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">PAGE 1</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">PAGE 2</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">PAGE 3</a>
              </li>
            -->
        </ul>
      </div>
  </div>
</nav>


    <div class="container">
        @if(session('success'))
            <div class="alert alert-success" >
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>
