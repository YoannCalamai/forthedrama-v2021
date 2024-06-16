@extends('bootstrap')

@section('titre_page', __('messages.jeuxdispos'). ' | ' )
@if( App::getLocale() == 'en')
    @section('page_description', 'App for playing online role-playing games inspired by For The Queen - To play fast and fun drama games!' )
@else
    @section('page_description', 'Une plateforme pour jouer en ligne aux jeux de rôle dérivés de For The Queen' )
@endif
@section('page_image',asset('images/forthegame.png') )


@section('content')

    <section class="page-section">
        <div class="container">

            <!-- Contact Section Heading -->
            <h2 class="page-section-heading text-center text-uppercase mb-0 text-white">{{__('messages.jeuxdispos')}}</h2>
            <!-- Icon Divider -->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div>


            <!-- Contact Section Form -->
            <div class="row">
                <div class="col-lg-8 mx-auto bk-white p-4 m-2">

                    <p>
                        {!! __('messages.jeuxdisposintro') !!}
                    </p>
                </div>  
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto bk-white p-4 m-2">
                    <ul>
                            @foreach( $jeux_dispo as $jeu)

                                @if( $jeu->hasLanguage( App::getLocale() ) )

                                    <li> <a href="{{route('jeus.show', $jeu->slug )}}"> {{ $jeu->jeu }} </a></li>

                                {{--<div class="row">--}}
                                    {{--<div class="col-lg-8 mx-auto bk-white p-4 m-2">--}}

                                    {{--@if( $jeux->image != '') <img src="{{ $jeux->image }}" class="img-fluid"  id="jeu_{{$jeux->id}}">--}}
                                    {{--@else <div id="jeu_{{$jeux->id}}">--}}
                                    {{--@endif--}}
                                    {{--<h3 class="mt-2">{{ $jeux->jeu }}  </h3>--}}
                                    {{--{!! $jeux->presentation !!}--}}
                                    {{--<br>--}}
                                    {{--<a href="{{ route('session', $jeux->id ) }}" class="btn btn-primary btn-xl mt-4"> {{ __('messages.jouer') }}</a>--}}

                                    {{--@if( App::getLocale() == 'en' && $jeux->id == 3 )--}}
                                        {{--<a href="https://jeffstormer.itch.io/doing-the-job" target="_blank" class="btn btn-info btn-xl mt-4 ml-4"> {{ __('messages.telecharger') }} </a>--}}
                                    {{--@else--}}
                                        {{--<a href="{{ route('telecharger', $jeux->id ) }}" class="btn btn-info btn-xl mt-4 ml-4"> {{ __('messages.telecharger') }} </a>--}}
                                    {{--@endif--}}
                                {{----}}


                                    {{--</div>  --}}
                                {{--</div>  --}}



                                @endif
                            @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </section>







@endsection
