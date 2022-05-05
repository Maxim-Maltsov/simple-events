@extends('layouts.my-app');


@section('content')

    <div class="col-12">
        <div class="row text-center flex-column justify-content-center align-items-center">
            

                <section v-if="errored">
                    <div class="card-info m-5" style="width: 40rem">
                        <div class="alert alert-danger mt-5" style="width: 40rem" role="alert">
                            <strong>{{ __('Уведомлене!') }}</strong><div class="text-secondary">{{ __('Не удалось получить данные.') }}</div>
                        </div>  
                    </div>
                </section>
    
                <section v-if="loading" class="d-flex flex-column align-items-center">
                    <div class="card-info m-5" style="width: 40rem">
                        <div class="alert alert-warning mt-5" style="width: 40rem" role="alert">
                            <strong>{{ __('Уведомлене!') }}</strong><div class="text-secondary">{{ __('Данные загружаются...') }}</div>
                        </div>
                        <div class="spinner-border text-warning m-5" role="status">
                            <span class="sr-only"></span>
                        </div>  
                    </div>
                </section>

                <section v-else  class="d-flex flex-column align-items-center">   
                    <div class="card m-5 p-2" style="width: 40rem">
                        <div class="card-body d-flex justify-content-between ">
                            <div class="px-3">{{ __('Общее кол-во голосов') }} <span class="badge badge-secondary">@{{ votes }}</span></div>
                            <div class="px-3">{{ __('До конца голосования осталось') }} <span class="badge badge-secondary">@{{ timerText }}</span></div>
                        </div>
                    </div>
                    <div v-for="event of events" class="card m-2" style="width: 40rem">
                        <div  class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-success">@{{ event.title }}</h5>
                            <button :disabled="send" v-on:click="sendVote(event.id)" type="button" class="btn btn-success bg-success">{{ __('Голосовать') }}</button>
                        </div>
                    </div>
                </section>
                
           
        </div>
    </div>

    <script> var token = "{{ $token }}"; </script>
    
@endsection