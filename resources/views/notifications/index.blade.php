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
                            @dd($notifications[$i])
                            <div class="d-flex flex-start my-2">
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <div class="">
                                            <h5>{{$notifications[$i]->user->name}} vous a donné un feedback sur la track {{$notifications[$i]->track->title}}</h5>
                                            <p style="width: 1000px;">Message : {{$notifications[$i]->message}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor

                        @for($i = 0; $i < count($feedbacks); $i++)
                            <div class="d-flex flex-start my-2">
                                <div class="card w-100">
                                    <div class="card-body p-4">
                                        <div class="">
                                            <h5>{{$feedbacks[$i]->user->name}} vous a donné un feedback sur la track {{$feedbacks[$i]->track->title}}</h5>
                                            <p style="width: 1000px;">Message : {{$feedbacks[$i]->message}}</p>
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
