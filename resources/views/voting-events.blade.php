@extends('layouts.my-app')


@section('content')

    <div class="row">
        <div class="col-12 text-center flex-column justify-content-center align-items-center">
            
                <section v-if="errored" class="d-flex flex-column align-items-center">
                    <div class="card-info m-5" style="width: 70%">
                        <div class="alert alert-danger mt-5" role="alert">
                            <strong>{{ __('Уведомлене! ') }}</strong><div class="text-secondary">{{ __('Не удалось получить данные.') }}</div>
                        </div>  
                    </div>
                </section>
    
                <section v-if="loading" class="d-flex flex-column align-items-center">
                    <div class="card-info m-5" style="width: 70%">
                        <div class="alert alert-warning mt-5" role="alert">
                            <strong>{{ __('Уведомлене! ') }}</strong><div class="text-secondary">{{ __('Данные загружаются...') }}</div>
                        </div>
                        <div class="spinner-border text-warning m-5" role="status">
                            <span class="sr-only"></span>
                        </div>  
                    </div>
                </section>

                <section v-else  class="d-flex flex-column align-items-center">
                    
                    <!-- timer --> 
                    <div class="card m-5 p-2" style="width: 70%">
                        <div class="card-body d-flex justify-content-between ">
                            <div class="text-secondary px-3">{{ __('Количество проголосовавших:') }} <span class="badge badge-secondary">@{{ (votes)? votes : '0' }}</span></div>
                            <div class="text-secondary px-3">{{ __('До конца голосования осталось:') }} <span class="badge badge-secondary">@{{ (timerText)? timerText : '00:00' }}</span></div>
                        </div>
                    </div>
                        
                    <!-- pagination -->
                    <nav aria-label="Page navigation example" class="m-5">
                        <ul class="pagination pagination-lg">
                            <li  class="page-item" :class="{disabled: !Boolean(pagination.prev)}" v-on:click.prevent="getVoting(pagination.prev)">
                            <a class="page-link" href="#"> &laquo;  </a>
                            </li>

                            <li class="page-item" :class="{disabled:true}">
                                <a class="page-link" href="javascript:void(0)" disabled > <span class="text-secondary">@{{pagination.current_page}} из @{{pagination.last_page}}</span> </a>
                            </li>
                        
                            <li class="page-item" :class="{disabled: !Boolean(pagination.next)}" v-on:click.prevent="getVoting(pagination.next)">
                                <a class="page-link"  href="#"> &raquo; </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- cards -->
                    <div v-for="event of events" class="card m-2" style="width: 70%">
                        <div  class="card-body d-flex justify-content-between align-items-center">
                            <h6 class="h6 card-title text-success">@{{ event.title }}</h6>
                            <button :disabled="send" v-on:click="sendVote(event.id)" type="button" class="btn btn-success bg-success">{{ __('Голосовать') }}</button>
                        </div>
                    </div>
                </section>
           
        </div>
    </div>

    <script> var token = "{{ $token }}"; </script>
    
@endsection