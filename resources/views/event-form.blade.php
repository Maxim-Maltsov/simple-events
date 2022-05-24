@extends('layouts.my-app');


@section('content')

    <div class="row text-center">
        <div class="col-12 d-flex direction-column align-items-center justify-content-center p-5">
 
            <div class="card m-3" style="width:60%">
                <div class="card-body">
                   
                    @if (session('message'))
                        <div class="alert alert-{{ session('alert-type') }}">
                            <strong>{{ __('Уведомлене! ') }}</strong>{{ session('message') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="pt-2">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    
                    <form action="{{ route('add-event') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="eventTitle">{{ __('Название мероприятия') }}</label>
                            <input type="text" name="title" class="form-control m-3" style="width: -webkit-fill-available;" id="eventTitle" aria-describedby="eventHelp" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="eventDesc">{{ __('Описание мероприятия') }}</label>
                            <textarea type="text" name="description" class="form-control m-3" style="width: -webkit-fill-available;" id="eventDesc" rows="12" value="{{ old('description') }}"></textarea>
                          </div>
                        <button type="submit" class="btn btn-success bg-success mt-3" style="width:55%">{{ __('Отправить') }}</button>
                    </form>
                </div>
              </div>
        </div>
   </div>  
    
@endsection