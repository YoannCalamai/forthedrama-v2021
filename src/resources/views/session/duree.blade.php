@extends('bootstrap')
@section('content')
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            @if(session('flash_errors'))
                <div class="form-group">
                    @if( !is_array( session('flash_errors')))

                        <div class="alert alert-danger">
                            {{ session('flash_errors') }}
                        </div>
                    @else
                        @foreach( session('flash_errors') as $erreur )
                            <div class="alert alert-danger">
                                {{ $erreur }}
                            </div>
                        @endforeach
                    @endif

                </div>
            @endif
            <form method="post" action="{{ route('session.duree', $code_room) }}">
                @csrf
                <h2 class="page-section-heading text-center text-uppercase mb-2 mt-4 text-white">{{__('messages.duree')}}</h2>
                <div class="input-group">
                    <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fa fa-angle-right blanc"></i>
                              </span>
                    </div>
                    <select required class="form-control m-input bigselect text-center" id="duree" name="duree">

                        <option value="1">{{__('messages.duree1')}}</option>
                        <option value="2">{{__('messages.duree2')}}</option>
                        <option value="3">{{__('messages.duree3')}}</option>
                        <option value="4">{{__('messages.duree4')}}</option>
                    </select>
                </div>
                <button class="btn btn-primary mt-4" id="next2">{{ __('messages.suivant') }} > </button>
            </form>
        </div>
    </header>
@endsection
