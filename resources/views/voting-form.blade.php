@extends('layouts.my-app')


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

                    <form action="{{ route('add-voting') }}" method="POST">
                        @csrf
                        <div class="form-group">
                        <label for="phaseOne">{{ __('Продолжительность 1-ой фазы голосования, мин.') }}</label>
                            <input type="number" name="time_phase_1" class="form-control text-center my-2" id="phaseOne" aria-describedby="phaseOneHelp">
                        </div>
                        <div class="form-group">
                            <label for="phaseTwo">{{ __('Продолжительность 2-ой фазы голосования, мин.') }}</label>
                            <input type="number" name="time_phase_2" class="form-control text-center my-2" id="phaseTwo" aria-describedby="phaseTwoHelp">
                          </div>
                        <button type="submit" class="btn btn-success bg-success mt-3" style="width:55%">{{ __('Запустить голосование') }}</button>
                    </form>
                </div>
            </div>
            
        </div>
   </div>  
    
@endsection