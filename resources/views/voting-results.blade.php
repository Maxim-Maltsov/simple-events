@extends('layouts.my-app');


@section('content')

    <div class="row">
        <div class="col-12 text-center flex-column justify-content-center align-items-center">
            
                <section v-if="errored">
                    <div class="card-info m-5" style="width: 80%">
                        <div class="alert alert-danger mt-5" role="alert">
                            <strong>{{ __('Уведомлене! ') }}</strong><div class="text-secondary">{{ __('Не удалось получить данные.') }}</div>
                        </div>  
                    </div>
                </section>
    
                <section v-if="loading" class="d-flex flex-column align-items-center">
                    <div class="card-info m-5" style="width: 80%">
                        <div class="alert alert-warning mt-5" role="alert">
                            <strong>{{ __('Уведомлене! ') }}</strong><div class="text-secondary">{{ __('Данные загружаются...') }}</div>
                        </div>
                        <div class="spinner-border text-warning m-5" role="status">
                            <span class="sr-only"></span>
                        </div>  
                    </div>
                </section>

                <section v-else class="d-flex flex-column align-items-center">   
                    <div class="card m-5 p-2" style="width: 80%">
                        <div class="card-body d-flex justify-content-between align-items-center "> 
                            <div class="text-secondary px-3">{{ __('До конца голосования осталось:') }}</div>
                            <span class="badge badge-secondary">@{{ timerText }}</span>
                        </div>
                    </div>
                    <div  class="card m-3" style="width: 80%">
                        <div  class="card-body d-flex flex-column justify-content-center align-items-center p-2 m-2">
                            <h5 class="h5 card-title text-secondary m-5">{{ __('Итоги голосования!') }}</h5>
                            <p class="text-secondary mt-2">{{ __('В голосовании победило мероприятие: ') }} <span class=" text-success py-3">@{{ winnerEvent.title }}</span></p>
                            <p class="text-secondary mt-2">{{ __('За мероприятие голосовали: ') }} 
                                @foreach ($users as $user)
                                    <span class=" text-success py-3"> {{ ($user->name)? $user->name . ', ' : ' ' }} </span>
                                @endforeach
                            </p>
                            <p class="text-secondary m-2">{{ __('В мероприятии участвуют: ') }} <span v-for="member of members" class="text-success text-wrap px-1"> @{{ (member.name)? member.name + ', ' : ' '}} </span></p>
                            <div class="d-flex justify-content-center align-items-center  m-4">
                                <button :disabled="accepted" v-on:click=" takePart(YES)" type="button" class="btn btn-success bg-success">{{ __('Принять участие') }}</button>
                                <button :disabled="accepted" v-on:click=" takePart(NO)" type="button" class="btn btn-success bg-danger ml-2">{{ __('Отказаться') }}</button>
                            </div>
                        </div>
                    </div>
                </section>

        </div>
    </div>
    
    <script> var token = "{{ $token }}"; </script>

@endsection