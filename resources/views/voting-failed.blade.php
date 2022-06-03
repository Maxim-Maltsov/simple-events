@extends('layouts.my-app')


@section('content')

    <div id="failed" class="row pt-3">
        <div class="col-12 text-center flex-column justify-content-center align-items-center">
            
            <section class="d-flex flex-column align-items-center p-5">   
                <div class="card m-5 p-2" style="width: 80%">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center "> 
                        <h5 class="h5 card-title text-secondary">{{ __('Голосование окончилось неудачно!') }}</h5>
                       
                        <div class="alert alert-danger mt-5" role="alert">
                            <div class="text-secondary">{{ __('Голосование не выявило победителей, так как два или более мероприятия набрали одинаковое кол-во голосов.') }}</div>
                        </div>
                    </div>
                </div>
            </section>

        </div>       
    </div>

    <script src="{{ asset('js/failed.js') }}"></script>

@endsection