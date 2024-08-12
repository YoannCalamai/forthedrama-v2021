
@include('layouts.header')

<div class="row mr-0 ml-0">
        <div class="col-lg-8 mx-auto pr-3">

                <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
                        <div class="container">
                                <a class="navbar-brand js-scroll-trigger" href="/" title="{{ config('app.name') }}">
                                        <i class="fas fa-home mr-2"></i>
                                        {{--@if( !Request::is('/')) For the Game @endif--}}
                                </a>
                                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">

                                        <i class="fas fa-bars"></i>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarResponsive">
                                        @include('layouts.menu')
                                </div>
                        </div>
                </nav>
                <div class="main-container">

                        @yield('content')

                        @include('layouts.footer')
                </div>

        </div>


</div>


