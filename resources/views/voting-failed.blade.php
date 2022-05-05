@extends('layouts.my-app');


@section('content')

    <div class="col-12">
        <div class="row text-center flex-column justify-content-center align-items-center">
            
            <section class="d-flex flex-column align-items-center p-5">   
                <div class="card m-5 p-2" style="width: 40rem">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center "> 
                        <h5 class="card-title text-secondary m-5">{{ __('Голосование окончилось неудачно!') }}</h5>
                       
                        <div class="alert alert-danger mt-5" style="width: 40rem" role="alert">
                            <div class="text-secondary">{{ __('Голосование не выявило победителей, так как два или более мероприятия набрали одинаковое кол-во голосов.') }}</div>
                        </div>
                    </div>
                </div>
            </section>

        </div>       
    </div>

@endsection