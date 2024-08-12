@extends('backend.layout.app')

@section('titre_page',  'Backend - Homepage' )

@section('content')
    <div id="panel1" data-parallax="true" >
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <h1 class="masthead-heading text-uppercase mb-0">{{ config('app.name') }} </h1>
                <!-- Icon Divider -->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="divider-custom-line"></div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <p>Bonjour et bienvenue dans l'arrière boutique de For the Drama !</p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <a href="{{ route('backend.jeus.create') }}" class="btn btn-primary my-2">{{ __('backend.creerjeu') }} </a>

                        @if( count( $jeus ) > 0 )
                        <a href="{{ route('backend.jeus.index') }}" class="btn btn-primary my-2">{{ __('backend.gererjeux') }} </a>
                        @endif
						
						@if( App::getLocale() == 'fr')
  
        <a href="{{ url('locale/en') }}" class="btn btn-primary my-2" title="{{__('messages.langueen')}}"><i class="fa fa-language"></i> EN</a>
    @endif
    @if( App::getLocale() == 'en')
        <a href="{{ url('locale/fr') }}" class="btn btn-primary my-2"  title="{{__('messages.languefr')}}"><i class="fa fa-language"></i> FR</a>
    @endif
						
                        <a id="logout" href="" class="btn btn-primary my-2"><i class="fas fa-sign-out-alt"></i> {{ __('backend.deconnexion') }} </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @push('scripts')
                            <script>
                                $('body').on('click', '#logout', function (e) {
                                    e.preventDefault();
                                    var form = $('#logout-form');
                                    swal.fire({
                                        title: "{{__('backend.confirmlogout')}}",
                                        text: "",
                                        type: "warning",
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText:  "{{__('backend.confirmbuttonlogout')}}",
                                        cancelButtonText: "{{__('backend.cancelbuttonlogout')}}",
                                        showCancelButton: true,
                                    }).then((willDelete)  => {
                                        if (willDelete.value == true) {
                                            form.submit();
                                        }
                                    });
                                });
                            </script>

                        @endpush

                    </div>
                    <div class="col-xs-8">

                    </div>

                </div>


            @yield('backendcontent')




            </div>
        </header>

    </div>









@endsection

@push('scripts')
    <script>

        $(document).ready(function(){




        });

    </script>
@endpush