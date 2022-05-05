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

                <section v-else class="d-flex flex-column align-items-center">   
                    <div class="card m-5 p-2" style="width: 40rem">
                        <div class="card-body d-flex justify-content-between align-items-center "> 
                            <div class="px-3">{{ __('До конца голосования осталось:') }}</div>
                            <span class="badge badge-secondary">@{{ timerText }}</span>
                        </div>
                    </div>
                    <div  class="card m-2" style="width: 40rem">
                        <div  class="card-body d-flex flex-column justify-content-center align-items-center p-2 m-2">
                            <h5 class="card-title text-success m-5">Итоги голосования!</h5>
                            <p class=" m-2">{{ __('В голосовании победило мероприятие: ') }} <span class=" text-success p-3">@{{ winnerEvent.title }}</span></p>
                            <p class="m-2">{{ __('В мероприятии участвуют: ') }} <span v-for="member of members" class="text-success text-wrap px-1"> @{{ (member.name)? member.name + ", " : ""}} </span></p>
                            <div class="d-flex justify-content-center align-items-center  m-4">
                                <button :disabled="accepted" v-on:click=" takePart(YES)" type="button" class="btn btn-success bg-success">{{ __('Принять участие') }}</button>
                                <button :disabled="accepted" v-on:click=" takePart(NO)" type="button" class="btn btn-success bg-danger ml-2">{{ __('Отказаться') }}</button>
                            </div>
                        </div>
                    </div>
                    
                    <script> var token = "{{ $token }}"; </script>

                </section>
                
            
        </div>
    </div>
    
@endsection