@extends('bootstrap')

@section('content')


    <section class="page-section">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase mt-4 mb-0 text-white">{{ __('auth.login') }}</h2>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-9 mx-auto bk-white p-4 card-login">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('auth.email') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-left">{{ __('auth.password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-right mt-2">
                                {{ __('auth.login') }}
                            </button>

                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-12 text-right">
                                {{ __('auth.registerquestion') }}
                                <a class="" href="{{ route('register') }}">
                                    {{ __('auth.register') }}
                                </a>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('auth.forgotpassword') }}
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('styles')
    <link href="{{asset('css/login.css')}}?ver={{ filemtime( public_path( ). '/css/login.css' ) }}" media='screen,print' rel="stylesheet">
@endpush