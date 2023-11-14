@extends('base')

@section('title', $product->title)

@section('content')
        <article>
            <h1>{{$product->title}}</h1>
            <p>{{$product->description}}</p>
        </article>
@endsection
