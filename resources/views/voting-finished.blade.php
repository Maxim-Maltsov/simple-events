@extends('layouts.my-app');


@section('content')

    <div class="row">
        <div class="col-12 text-center flex-column justify-content-center align-items-center">
            
            <section class="d-flex flex-column align-items-center p-5">   
                <div class="card m-5 p-2" style="width: 80%">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center "> 
                        <h5 class="h5 text-success m-5">{{ __('Голосование окончено!') }}</h5>
                        <h6 class="h6 text-secondary d-flex flex-column align-items-center py-2 ">{{ __('В мероприятии участвуют: ') }}</h6>
                        @foreach ($users as $user)
                            <div class=" text-success "> {{ ($user->name)? $user->name . ', ' : ' ' }} </div>
                        @endforeach
                    </div>
                </div>
            </section>

        </div>       
    </div>

@endsection