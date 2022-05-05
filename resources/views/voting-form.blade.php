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
                        <form action="{{ route('add-voting') }}" method="POST" style="width: 100%">
                            @csrf
                            <div class="form-group">
                                <label for="phaseOne">{{ __('Укажите время первой фазы голосования, мин.') }}</label>
                                <input type="number" name="time_phase_1" class="form-control text-center m-3" id="phaseOne" >
                            </div>
                            <div class="form-group">
                                <label for="phaseTwo">{{ __('Укажите время второй фазы голосования, мин.') }}</label>
                                <input type="number" name="time_phase_2" class="form-control text-center m-3" id="phaseTwo">
                            </div>
                            <button  type="submit" class="btn btn-success bg-success mt-3" style="width: 65%">{{ __('Запустить голосование') }}</button>
                        </form>
                    </div>
                </div>

            
        </div>
    </div>
    
@endsection