@extends('bootstrap')


@section('titre_page',  config('app.name')  .' | '.'Play tabletop role-playing games with your friends in less than one hour !' )

@if( App::getLocale() == 'en')
    @section('page_description', 'App for playing online role-playing games inspired by For The Queen - To play fast and fun drama games!' )
@else
    @section('page_description', 'Une plateforme pour jouer en ligne aux jeux de rôle dérivés de For The Queen' )
@endif
@section('page_image',asset('images/forthegame.png') )

@section('content')
    <div id="panel1" data-parallax="true" >
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h1 class="masthead-heading text-uppercase mb-0">{*~ DEV ~*} - {{ config('app.name') }} </h1>
                <!-- Icon Divider -->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="divider-custom-line"></div>
                </div>


                <img class="img-fluid illustration-principale" src="{{ url('images/ftq-light.png') }}" alt="3 cartes montrant 3 Reines">

                <div class="row">
                    <div class="col-xs-4">
                        <button id="next3" class="btn btn-primary my-2">{{ __('messages.nouvellepartie') }} </button>
                    </div>
                    <div class="col-xs-4 ml-2">
                        <button id="next2" class="btn btn-secondary my-2">{{ __('messages.rejoindre') }}</button>
                    </div>
                    <div class="col-xs-4 ml-2">
                        <a href="{{ url('login') }}" class="btn btn-danger my-2">{{ __('messages.menucreersonjeu') }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <a href="{{route('aide')}}" class="text-center text-white mt-2" title="{{__('messages.aidetexte')}}">{{__('messages.aidetexte')}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <a href="{{route('changelog')}}" class="text-center text-white mt-2" id="changelog" title="{{__('messages.historiquetexte')}}"> {{ __('messages.historique') }}</a>
                    </div>
                </div>






            </div>
        </header>

    </div>

    <div id="panel2" data-parallax="true" style="display:none; background-color:#787978; background-image: url('{{config('app.fond_ecran')}}')">

        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h1 class="masthead-heading text-uppercase mb-0">{{ config('app.name') }}</h1>

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

                <form method="post" id="form_goto_session" action="{{ route('session') }}" class="mt-4">
                    @csrf
                    <h2>{{ __('messages.titrerejoindre') }}</h2>
                    <input type="text" class="form-control m-input text-center text-uppercase" id="code_room" name="code_room" placeholder="{{__('messages.joindreplaceholder')}}" data-toggle="tooltip" data-placement="right" title="{{__('messages.rejoindreplaceholder')}}">

                    <button class="btn btn-primary mt-4" id="next2"> {{ __('messages.rejoindre') }} </button>
                </form>

            </div>
        </header>

    </div>

    <div id="panel3" data-parallax="true" style="display:none; background-color:#787978; background-image: url('{{config('app.fond_ecran')}}')">

        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">

                <form method="post" id="form_goto_session_jeu" action="{{ route('session') }}">
                    <input type="hidden" id="jeu_choisi" name="jeu_choisi" value="">
                    @csrf

                            <div class="row">

                            @foreach( $jeux_dispo as $clef => $jeu )
								@if( $jeu->hasLanguage( App::getLocale() ) )
                                    <div class="col-md-6 @if($jeu->is_publie == 0) hide @endif">
                                        <div class="cartejeu my-2  p-relative bg-white shadow-1" style="overflow: hidden; border-radius: 1px;">
                                            @if( $jeu->image != '') <img src="{{ $jeu->urlIllustration() }}" alt="" class="w-full illustration-jeu"> @endif
                                            <div class="px-2 py-2">

                                                <h1 class="ff-serif font-weight-normal text-black card-heading mt-0 mb-1" style="line-height: 1.25;">
                                                    {{ $jeu->jeu }}
                                                </h1>

                                                <p class="mb-1 text-black intro">
                                                    {!!  $jeu->intro  !!}
                                                </p>
                                                <p class="mb-0 small font-weight-medium text-uppercase mb-1 text-muted lts-2px">
                                                    <a href="{{url('games', $jeu->slug )}}">{{__('messages.ensavoirplus')}}</a>
                                                </p>

                                            </div>
                                            <button class="btn btn-primary mt-2 mb-2 btn-lg  selecteur_jeu_choisi" value="{{ $jeu->id }}"> {{ __('messages.jouer') }} </button>

                                            @if( App::getLocale() != 'jp' )
                                                @if( App::getLocale() == 'en' && $jeu->id == 3 )
                                                    <a href="https://jeffstormer.itch.io/doing-the-job" target="_blank" class="btn btn-info mt-2 ml-4" title="Télécharger PDF">  <i class="fas fa-download"></i> </a>
                                                @else
                                                    <a href="{{ route('telecharger', $jeu->id ) }}" class="btn btn-info mt-2 ml-4" title="Télécharger PDF">  <i class="fas fa-download"></i> </a>
                                                @endif
                                            @endif

                                        </div>
                                    </div>
								@endif
                            @endforeach
                            </div>


                </form>


            </div>
        </header>

    </div>





@endsection

@push('scripts')
    <script>

        $(document).ready(function(){

            $('.selecteur_jeu_choisi').on('click', function(event){
                    event.preventDefault();
                    $('#jeu_choisi').val( $(this).val() );
                    $('#form_goto_session_jeu').submit();

                }
            );

            $("#next2").click(function(){
                $("#panel1").hide( );
                $("#panel3").hide( );
                $("#panel2").show();

            });

            $("#next3").click(function(){
                $("#panel1").hide( );
                $("#panel2").hide( );
                $("#panel3").show();

            });

            @if(session('flash_errors'))
            $('#panel2').show();
            $('#panel1').hide();
            $('#panel3').hide();
            $('.illustration-principale').hide();
            $('#changelog').hide();
            @endif


        });


    </script>
@endpush