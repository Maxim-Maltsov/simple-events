@extends('layouts.my-app')


@section('content')

    <div class="row">
        <div class="col-12 text-center flex-column justify-content-center align-items-center">
           
            <section v-if="errored" class="d-flex flex-column align-items-center">
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
                
                <!-- pagination -->
                <nav aria-label="Page navigation example" class="m-5">
                    <ul class="pagination pagination-lg">
                        <li  class="page-item" :class="{disabled: !Boolean(pagination.prev)}" v-on:click.prevent="getEvents(pagination.prev)">
                          <a class="page-link" href="#"> &laquo;  </a>
                        </li>

                        <li class="page-item" :class="{disabled:true}">
                            <a class="page-link" href="javascript:void(0)"> <span class="text-secondary">@{{pagination.current_page}} из @{{pagination.last_page}}</span> </a>
                        </li>
                    
                        <li class="page-item" :class="{disabled: !Boolean(pagination.next)}" v-on:click.prevent="getEvents(pagination.next)">
                            <a class="page-link"  href="#" > &raquo; </a>
                        </li>
                    </ul>
                </nav>

                <!-- cards -->
                <div v-for="event of events" :key="event.id" class="card m-2" style="width: 70%">
                    <div class="card-body">
                        <h5 class="h5 card-title text-success"> @{{ event.title }} </h5>
                        <p class="card-text text-secondary"> @{{ event.description }} </p>
                    </div>
                </div>

                
            </section>
            
        </div>
    </div>
    
    <script> var token = "{{ $token }}"; </script>

@endsection