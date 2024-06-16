<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>For the Drama | @yield('titre_page') </title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/lite-purple.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/libs/perfect-scrollbar.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/libs/pickadate/classic.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/libs/pickadate/classic.date.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/libs/datatables.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/libs/sweetalert2.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/app.css') }}" media="all">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous" media="all">--}}
    <link rel="stylesheet" href="{{ asset('css/backend/libs/fontawesome.css') }}" crossorigin="anonymous" media="all">
    <link rel="stylesheet" href="{{ asset('css/backend/libs/toastr.css') }}" media="all">
    <link href="{{ asset('css/backend/libs/jquery-ui.css') }}" rel="stylesheet" type="text/css"  media="all"/>
    <link href="{{ asset('css/backend/libs/jquery-ui.theme.css') }}" rel="stylesheet" type="text/css"  media="all"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet" media="all">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png" />
    {{--<link href="{{ asset('styles/libs/dropzone.css') }}" rel="stylesheet" type="text/css" />--}}
    @yield('css')
    <script src="{{ asset('js/backend/libs/jquery-3.4.1.min.js') }}"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--[if gte IE 9]>
    <style type="text/css">
        .gradient {
            filter: none;
        }
    </style>
    <![endif]-->

</head>

<body>
<div class="app-admin-wrap">
    <div class="main-header">
        <div class="d-flex align-items-center">
            <div id="titre-application" class="row">
                <div class="app-title"><a href="{{route('home')}}"   title="Retour à l'accueil" style="color:#000 !important;">{{ config('app.name') }}</a></div>
                <div class="menu-toggle" title="Afficher/Masquer menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <div style="margin: auto"></div>

        @if( \Auth::user() != null )
            <div class="header-part-right mr-lg-2">



                <p class=" msg-bonjour mt-3 mr-3">Bonjour {{ \App\User::afficheNom() }}</p>

                @if(  Session::get('rollback') != null )
                    <a href="{{ route('users.rollbacklogin' ) }}" class="btn btn-danger btn-sm mt-1  ml-3" title="Retour à votre compte utilisateur">
                        <i class="fa fa-angle-left"></i>
                    </a>
                @endif

            </div>
        @endif
    </div>


@include('backend.layout.menu')

<!--=============== Left side End ================-->

    <!-- ============ Body content start ============= -->
    <div class="main-content-wrap sidenav-open d-flex flex-column">

    @include('backend.layout.session-message')

    @if ($errors->any())
        {!!  implode('', $errors->all('<div class="alert alert-danger">:message</div>'))  !!}
    @endif

    @yield('content')



    <!-- Footer Start -->
        <div class="flex-grow-1"></div>

    </div>




    <!-- ============ Body content End ============= -->
</div>
<!--=============== End app-admin-wrap ================-->




<script src="{{ asset('js/backend/libs/jquery-ui.js') }}"></script>
<script src="{{ asset('js/backend/libs/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/backend/libs/es5/script.min.js?ver=2') }}"></script>
<script src="{{ asset('js/backend/libs/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/backend/libs/jquery.mask.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/backend/libs/datable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/backend/libs/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/backend/libs/dropzone.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/backend/libs/jquery.validate.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-maxlength/1.7.0/bootstrap-maxlength.min.js"></script>
{{--<script src="{{ asset('js/libs/dropzone.js') }}" type="text/javascript"></script>--}}
<script src="{{ asset('js/backend/app.js?ver='.date('YmdHis') ) }}" type="text/javascript"></script>
<script src="{{ asset('js/backend/global.js?ver='.date('YmdHis') ) }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-uk.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
@stack('scripts')
@yield('js')
</body>

</html>
