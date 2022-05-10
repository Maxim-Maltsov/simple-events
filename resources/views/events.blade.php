@extends('layouts.my-app');


@section('content')

    <div class="row">
        <div class="col-12 text-center flex-column justify-content-center align-items-center">
           
            <section v-if="errored">
                <div class="card-info mt-5" style="width: 70%">
                    <div class="alert alert-danger mt-5" role="alert">
                        <strong>{{ __('Уведомлене! ') }}</strong><div class="text-secondary">{{ __('Не удалось получить данные.') }}</div>
                    </div>  
                </div>
            </section>

            <section v-if="loading" class="d-flex flex-column align-items-center">
                <div class="card-info mt-5" style="width: 70%">
                    <div class="alert alert-warning mt-5" role="alert">
                        <strong>{{ __('Уведомлене! ') }}</strong><div class="text-secondary">{{ __('Данные загружаются...') }}</div>
                    </div>
                    <div class="spinner-border text-warning m-5" role="status">
                        <span class="sr-only"></span>
                    </div>  
                </div>
            </section>

            <section v-else class="text-center d-flex flex-column justify-content-center align-items-center mt-5">
                <div v-for="event of events" class="card m-2" style="width: 70%">
                    <div class="card-body">
                        <h5 class="card-title text-success"> @{{ event.title }} </h5>
                        <p class="card-text text-secondary"> @{{ event.description }} </p>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
    
@endsection