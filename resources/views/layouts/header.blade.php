<!DOCTYPE HTML>
<html  lang="{{ app()->getLocale() }}">
<head>
    <!--
    ________     ,-----.    .-------.            ,---------. .---.  .---.     .-''-.           ______     .-------.       ____    ,---.    ,---.   ____
    |        |  .'  .-,  '.  |  _ _   \           \          \|   |  |_ _|   .'_ _   \         |    _ `''. |  _ _   \    .'  __ `. |    \  /    | .'  __ `.
    |   .----' / ,-.|  \ _ \ | ( ' )  |            `--.  ,---'|   |  ( ' )  / ( ` )   '        | _ | ) _  \| ( ' )  |   /   '  \  \|  ,  \/  ,  |/   '  \  \
    |  _|____ ;  \  '_ /  | :|(_ o _) /               |   \   |   '-(_{;}_). (_ o _)  |        |( ''_'  ) ||(_ o _) /   |___|  /  ||  |\_   /|  ||___|  /  |
    |_( )_   ||  _`,/ \ _/  || (_,_).' __             :_ _:   |      (_,_) |  (_,_)___|        | . (_) `. || (_,_).' __    _.-`   ||  _( )_/ |  |   _.-`   |
    (_ o._)__|: (  '\_/ \   ;|  |\ \  |  |            (_I_)   | _ _--.   | '  \   .---.        |(_    ._) '|  |\ \  |  |.'   _    || (_ o _) |  |.'   _    |
    |(_,_)     \ `"/  \  ) / |  | \ `'   /           (_(=)_)  |( ' ) |   |  \  `-'    /        |  (_.\.' / |  | \ `'   /|  _( )_  ||  (_,_)  |  ||  _( )_  |
    |   |       '. \_/``".'  |  |  \    /             (_I_)   (_{;}_)|   |   \       /         |       .'  |  |  \    / \ (_ o _) /|  |      |  |\ (_ o _) /
    '---'         '-----'    ''-'   `'-'              '---'   '(_,_) '---'    `'-..-'          '-----'`    ''-'   `'-'   '.(_,_).' '--'      '--' '.(_,_).'

    For The Drama est une application gratuite (et qui le restera) ayant pour but de proposer des jeux de rôles sous licence Descended From the Queen, c'est à dire
    dérivés du jeu de rôle For The Queen créé par Alex Roberts et publié par Evil Hat Production

    @auteurs des jeux : voir la page Jeux Disponibles https://www.forthedrama.com/listejeux
	@twitter: https://twitter.com/matthieub_
	@blog:  https://www.cestpasdujdr.fr
	@contact éditorial : matthieu __AT__ mateline __DOT__ fr
    -->

    @if( App::getLocale() == 'en')
        <title> @yield('titre_page') </title>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="description" content="@yield('page_description') "/>
        <link rel="next" href="https://www.cestpasdujdr.fr" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="@yield('titre_page')" />
        <meta property="og:description" content="@yield('page_description')" />
        <meta property="og:site_name" content="{{ config('app.name') }} : App for playing online role-playing games inspired by For The Queen - To play fast and fun drama games!" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@matthieub_" />
        <meta name="twitter:image" content="@yield('page_image')?<?php echo uniqid();?>" />
        <meta name="twitter:description" content="@yield('page_description')" />
        <meta name="twitter:title" content="{{ config('app.name') }} : App for playing online role-playing games inspired by For The Queen - To play fast and fun drama games!" />
        <meta name="twitter:image:alt" content="{{ config('app.name') }} : App for playing online role-playing games inspired by For The Queen - To play fast and fun drama games!" />
        <meta property="og:image" content="@yield('page_image')?<?php echo uniqid();?>"/>
        <meta property="og:image:width" content="200" />
        <meta property="og:image:height" content="200" />
       {{-- <meta property="og:image:width" content="250"/>
        <meta property="og:image:height" content="250"/>
        <meta itemprop="image" content="@yield('page_image')"/>--}}
    @else
        <title> @yield('titre_page') {{ config('app.name') }} : Une application de jeux de rôle en ligne inspirés par For The Queen - Pour jouer à des jeux rapides, funs et forts en drama !</title>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="description" content="@yield('page_description')"/>
        <link rel="next" href="https://www.cestpasdujdr.fr" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ config('app.name') }} :  Une application de jeux de rôle en ligne inspirés par For The Queen - Pour jouer à des jeux rapides, funs et forts en drama !" />
        <meta property="og:description" content="@yield('page_description')" />
        <meta property="og:url" content="https://ftq.cestpasdujdr.fr" />
        <meta property="og:site_name" content="{{ config('app.name') }} : Une application de jeux de rôle en ligne inspirée par For The Queen - Pour jouer à des jeux rapides, funs et forts en drama !" />
        <meta property="og:image" content="@yield('page_image')?<?php echo uniqid();?>"/>
        <meta property="og:image:width" content="200" />
        <meta property="og:image:height" content="200" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:description" content="@yield('page_description')" />
        <meta name="twitter:image" content="@yield('page_image')?<?php echo uniqid();?>" />
        {{--<meta name="twitter:image:alt" content="@yield('page_description')" />--}}
        <meta name="twitter:title" content="{{ config('app.name') }} - plateforme de jeu en ligne" />

{{--        <meta property="og:image" content="@yield('page_image')"/>--}}
{{--        <meta itemprop="image" content="@yield('page_image')"/>--}}
    @endif


    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/img/fav/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/img/fav/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/img/fav/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/fav/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/img/fav/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/fav/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/img/fav/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/fav/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/fav/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/favicon192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon16.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/fav/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/fav/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
{{--    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" media='screen,print' rel="stylesheet" type="text/css">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" media='screen,print' rel="stylesheet" type="text/css">
    <link href="{{asset('css/vendor/sweetalert2.min.css')}}" media='screen,print' rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" media='screen,print' rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arimo&display=swap" media='screen,print' rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" media='screen,print' rel="stylesheet">
    <link href="{{asset('css/freelancer.css')}}?ver={{ filemtime( public_path( ). '/css/freelancer.css' ) }}" media='screen,print' rel="stylesheet">
    <link href="{{asset('css/custom.css')}}?ver={{ filemtime( public_path( ). '/css/custom.css' ) }}" media='screen,print' rel="stylesheet">
    <link href="{{asset('css/card-list.css')}}?ver={{ filemtime( public_path( ). '/css/card-list.css' ) }}" media='screen,print' rel="stylesheet">


    @stack('styles')

<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143290214-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-143290214-1');
    </script>

</head>

