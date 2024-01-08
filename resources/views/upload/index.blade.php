@extends('base')

@section('Upload', 'Nouveau partage')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>Que voulez-vous upload ?</h1>
        <div class="d-flex justify-content-around align-items-center w-50 my-5">
            <a href="{{route('resource.admin.create')}}" class="btn btn-info">Resource</a>
            <a href="{{route('track.admin.create')}}" class="btn btn-info">Track</a>
        </div>
    </div>
@endsection
