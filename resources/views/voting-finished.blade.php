@extends('layouts.my-app');


@section('content')

    <div class="col-12">
        <div class="row text-center flex-column justify-content-center align-items-center">
            
            <section class="d-flex flex-column align-items-center p-5">   
                <div class="card m-5 p-2" style="width: 40rem">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center "> 
                        <h1 class="card-title text-success m-5">{{ __('Голосование окончено!') }}</h1>
                        
                        <div class="alert alert-success mt-5" style="width: 40rem" role="alert">
                            <div class="text-secondary">{{ __('Итоги голосования подведены. Победившее мероприятие определено.') }}</div>
                        </div>
                    </div>
                </div>
            </section>

        </div>       
    </div>

@endsection