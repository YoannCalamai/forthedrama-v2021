@extends('bootstrap')

@section('titre_page', __('messages.avenir'). ' | ' )
@if( App::getLocale() == 'en')
    @section('page_description', 'App for playing online role-playing games inspired by For The Queen - To play fast and fun drama games!' )
@else
    @section('page_description', 'Une plateforme pour jouer en ligne aux jeux de rôle dérivés de For The Queen' )
@endif
@section('page_image',asset('images/forthegame.png') )
@section('content')


    <section class="page-section">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase mt-4 mb-0 text-white">{{__('messages.avenir')}}}</h2>
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto bk-white p-4">
                    {!! $contenu->contenu !!}
                </div>
            </div>
        </div>
    </section>








@endsection
