@extends('backend.layout.app')

@section('titre_page',  'Backend - Homepage' )

@section('content')

    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body"><i class="i-Add-User"></i>
                    <div class="content" style="max-width:90%">
                        <h4>Bienvenue votre espace auteur</h4>
                        <p>
                            La communauté de For The Drama est fière de vous proposer cet outil qui vous donne la main pour créer et
                            modifier vos jeux en toute autonomie !
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body"><i class="i-Add-User"></i>
                    <div class="content" style="max-width:90%">
                        <h4>Choisissez votre langue</h4>
                        <select class="selectpicker" data-width="fit">
                            <option>> Choose your language</option>
                            <option data-url="{{url('locale/de')}}" data-content='Deutsch'>Deutsch</option>
                            <option data-url="{{url('locale/en')}}" data-content='English'>English</option>
                            <option data-url="{{url('locale/es')}}" data-content='Español'>Español</option>
                            <option data-url="{{url('locale/fr')}}" data-content='Français'>Français</option>
                            <option data-url="{{url('locale/jp')}}" data-content='日本語'>日本語</option>


                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body"><i class="i-Add-User"></i>
                    <div class="content" style="max-width:90%">
                        <h4  class="mt-4">  <i class="fas fa-user" aria-hidden="true"></i> Vos informations personnelles</h4>
                        <p>Ces informations seront accessibles dans la page dédiée à vos jeux</p>

                        {{ Form::model( \Auth::user(), array('route' => array('users.update.infos', \Auth::user()->id), 'method' => 'PUT', 'id' => 'form_auteur')) }}
                        <div class="row">
                            <label class="col-md-4 mt-2" for="jeu">Nom</label>
                            <input type="text" class="form-control col-md-8" name="auteur_nom" value="{{ \Auth::user()->auteur_nom }}"  >
                        </div>
                        <div class="row">
                            <label class="col-md-4 mt-2" for="jeu">Email</label>
                            <input type="email" class="form-control col-md-8" name="auteur_email" value="{{ \Auth::user()->auteur_email }}"  >
                        </div>
                        <div class="row">
                            <label class="col-md-4 mt-2" for="jeu">URL(s)</label>
                            <input type="text" class="form-control col-md-8" name="auteur_url" value="{{ \Auth::user()->auteur_url }}"  >
                        </div>
                        <div class="row">
                            <label class="col-md-4 mt-2" for="jeu">ID réseaux sociaux</label>
                            <input type="text" class="form-control col-md-8" name="auteur_rs" value="{{ \Auth::user()->auteur_rs}}"  >
                        </div>


                        <button type="submit" class="btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fas fa-save mr-2" aria-hidden="true"></i><span>Enregistrer</span></span></button>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection

@push('scripts')
    <script>
        $(function(){

            $('.selectpicker').on('change', function(){
                var url = $(this).find(':selected').data('url');
                window.location = url;
            });


        });
    </script>
@endpush