@extends('base')

@section('title', 'Notifications')

@section('content')

    <h1 class="text-center">Liste des Notifications</h1>

    <div class="d-flex justify-content-center">
        <section>
            <div class="container my-5 py-5 text-dark">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-11 col-lg-9 col-xl-7">

                        @for($i = 0; $i < count($notifications); $i++)
                            <ul class="list-group">


                                @switch($notifications[$i]->type)
                                    @case('like_track')
                                        @if(array_key_exists('track', $notifications[$i]->data))
                                            @if($notifications[$i]->data['status'])
                                                <li class="list-group-item list-group-item-success">
                                                    <i class="btn fa-solid fa-heart" style="color: lightgreen"></i>
                                                    {{$notifications[$i]->data['source']['name']}} aime {{$notifications[$i]->data['track']['title']}}
                                                </li>
                                            @else
                                                <li class="list-group-item list-group-item-danger">
                                                    <i class="btn fa-regular fa-heart" style="color: lightcoral"></i>
                                                    {{$notifications[$i]->data['source']['name']}} n'aime plus {{$notifications[$i]->data['track']['title']}}
                                                </li>
                                            @endif
                                        @endif
                                    @case('like_resource')
                                        @if(array_key_exists('resource', $notifications[$i]->data))

                                            @if($notifications[$i]->data['status'])
                                                <li class="list-group-item list-group-item-success">
                                                    <i class="btn fa-solid fa-heart" style="color: lightgreen"></i>
                                                    {{$notifications[$i]->data['source']['name']}} aime la resource {{$notifications[$i]->data['resource']['title']}}
                                                </li>
                                            @else
                                                <li class="list-group-item list-group-item-danger">
                                                    <i class="btn fa-regular fa-heart" style="color: lightcoral"></i>
                                                    {{$notifications[$i]->data['source']['name']}} n'aime pas la resource {{$notifications[$i]->data['resource']['title']}}
                                                </li>
                                            @endif



                                        @endif


                                @endswitch
                            </ul>

                        @endfor
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
