@extends('bootstrap')

@if( $jeu->hasLanguage( App::getLocale() ) )

    @section('titre_page', $jeu->jeu . ' | ' . $jeu->intro )
@section('page_description', $jeu->intro )
@section('page_image', url($jeu->urlIllustration()) )
@else
    <?php
    $missing_translation = $jeu->getTranslations();
    ?>

    @section('titre_page', $missing_translation[ 'jeu'] [ array_key_first( $missing_translation[ 'jeu'] ) ] )
@section('page_description', $missing_translation[ 'intro'] [ array_key_first( $missing_translation[ 'intro'] ) ] )
@section('page_image', url($jeu->urlIllustration()) )
@endif



@section('content')


    @if( $jeu->hasLanguage( App::getLocale() ) )

        <section class="page-section">
            <div class="container">
                <h1 class="page-section-heading text-center text-uppercase mt-4 mb-0 text-white">{{ $jeu->jeu }} </h1>
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="divider-custom-line"></div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto bk-white p-4 text-center">

                        @if( $jeu->urlIllustration() != '') <img src="{{ $jeu->urlIllustration() }}" class="img-fluid">@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto bk-white p-4">
                        <h2 class="mt-2">{{ $jeu->jeu }}  </h2>
                        {!! $jeu->presentation !!}
                        <br>

            @if(isset( $jeu->auteur_nom ) && $jeu->auteur_nom != 'Admin' )

                @if(isset( $jeu->auteur_nom ) && $jeu->auteur_nom != null )
                    <br><strong>Auteur : </strong> {{ $jeu->auteur_nom }}
                @elseif(isset( $jeu->user->auteur_nom ) && $jeu->user->auteur_nom != null )
                    <br><strong>Auteur : </strong> {{ $jeu->user->auteur_nom }}
                @endif
                @if( isset( $jeu->auteur_url ) && $jeu->auteur_url != null )
                    <br><strong>URL : </strong> <a href="{{ $jeu->auteur_url }}" target="_blank">{{ $jeu->auteur_url }}</a>
                @elseif($jeu->user->auteur_nom  != 'Admin' && isset( $jeu->user->auteur_url ) && $jeu->user->auteur_url != null )
                    <br><strong>URL : </strong> <a href="{{ $jeu->user->auteur_url }}" target="_blank">{{ $jeu->user->auteur_url }}</a>
                @endif

                @if(isset( $jeu->auteur_email ) && $jeu->auteur_email != null )
                    <br><strong>Email : </strong> {{ $jeu->auteur_email }}
                @elseif($jeu->user->auteur_nom  != 'Admin' && isset( $jeu->user->auteur_email ) && $jeu->user->auteur_email != null )
                    <br><strong>Email : </strong> {{ $jeu->user->auteur_email }}
                @endif

                @if(isset( $jeu->auteur_rs ) && $jeu->auteur_rs != null )
                    <br><strong>ID Réseaux sociaux : </strong> {{ $jeu->auteur_rs }}
                @elseif($jeu->user->auteur_nom  != 'Admin' && isset( $jeu->user->auteur_rs ) && $jeu->user->auteur_rs != null )
                    <br><strong>ID Réseaux sociaux : </strong> {{ $jeu->user->auteur_rs }}
                @endif
        @endif
                                <br>
                                <a href="{{ route('session', $jeu->id ) }}" class="btn btn-primary  mt-4"> {{ __('messages.jouer') }}</a>

                                @if( App::getLocale() == 'en' && $jeu->id == 3 )
                                    <a href="https://jeffstormer.itch.io/doing-the-job" target="_blank" class="btn btn-info mt-4 ml-2"> {{ __('messages.telecharger') }} </a>
                                @else
                                    <a href="{{ route('telecharger', $jeu->id ) }}" class="btn btn-info  mt-4 ml-2"> {{ __('messages.telecharger') }} </a>
                                @endif

                                <a href="{{ route('listejeux' ) }}" class="btn btn-default mt-4"> {{ __('messages.jeuxdispos') }}</a>

                            </div>
                        </div>
                    </div>
                </section>


            @else


                <section class="page-section">
                    <div class="container">
                        <h1 class="page-section-heading text-center text-uppercase mt-4 mb-0 text-white">{{ $missing_translation[ 'jeu'] [ array_key_first( $missing_translation[ 'jeu'] ) ] }} </h1>
                        <div class="divider-custom divider-light">
                            <div class="divider-custom-line"></div>
                            <div class="divider-custom-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="divider-custom-line"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 mx-auto bk-white p-4 text-center">

                                @if( $jeu->urlIllustration() != '') <img src="{{ $jeu->urlIllustration() }}" class="img-fluid">@endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 mx-auto bk-white p-4">
                                <h3 class="mt-2"> Unfortunately, this game is not available in your language </h3>
                                <p>
                                    If you want to contribute by translating this game or by creating your own,  you can contact us:
                                <ul>
                                    <li>by mail : matthieu [ at ] mateline . fr</li>
                                    <li>on <a href="https://discord.gg/9GGtpzr" target="_blank">our Discord Server</a></li>
                                </ul>


                                </p>
                                <br>


                            </div>
                        </div>
                    </div>
                </section>

            @endif

        @stop
