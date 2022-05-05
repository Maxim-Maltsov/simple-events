@extends('layouts.my-app');


@section('content')

    <div class="col-12">
        <div class="row text-center d-flex flex-column justify-content-center align-items-center">
            

                <div class="card-info mt-5" style="width: 40rem">
                    @if (session('message'))
                        <div class="alert alert-{{ session('alert-type') }}" style="width: 100%" role="alert">
                            <strong>Уведомлене!</strong><div class="text-secondary">{{ session('message') }}</div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            
                <div class="card m-5" style="width: 40rem">
                    <div class="card-body">
                        <form action="{{ route('add-event') }}" method="POST" style="width: 100%">
                            @csrf
                            <div class="form-group">
                                <label for="eventTitle">{{ __('Название мероприятия') }}</label>
                                <input type="text" name="title" class="form-control m-3" id="eventTitle">
                            </div>
                            <div class="form-group">
                                <label for="eventDesc">{{ __('Описание мероприятия') }}</label>
                                <textarea type="text" name="description" class="form-control m-3" id="eventDesc" rows="8"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success bg-success mt-3" style="width: 65%">{{ __('Отправить') }}</button>
                        </form>
                    </div>
                </div>

            
        </div>
    </div>
    
@endsection