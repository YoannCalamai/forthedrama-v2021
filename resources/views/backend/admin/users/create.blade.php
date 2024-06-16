{{-- \resources\views\users\create.blade.php --}}
@extends('backend.layout.app')

@section('title', '| Créer un Utilisateur')

@section('content')

    {{ Form::open(array('route' => 'users.store')) }}



        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">

                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    <h2>Ajouter un utilisateur </h2>
                                </div>
                                <div class="p-2 bd-highlight"></div>
                                <div class="p-2 bd-highlight">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left mr-2" aria-hidden="true"></i><span>Retour</span></span> </a>
                                    <button type="submit" class="btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fa fa-plus mr-2"></i><span>Créer</span></span></button>
                                </div>
                            </div>
                        </div>



                    <div class="m-portlet__body">


                        <div class="form-group">
                            {{ Form::label('name', 'Nom *') }}
                            {{ Form::text('name', '', array('class' => 'form-control', 'required')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('name', 'Login *') }}
                            {{ Form::text('name', '', array('class' => 'form-control', 'required')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('email', 'Email *') }}
                            {{ Form::email('email', '', array('class' => 'form-control', 'required')) }}
                        </div>

                        <div class="row">
                            <label class="col-md-2 mt-2" for="jeu">Nom</label>
                            <input type="text" class="form-control col-md-4" name="auteur_nom"  >
                            <label class="col-md-2 mt-2" for="jeu">Email</label>
                            <input type="email" class="form-control col-md-4" name="auteur_email"   >
                        </div>
                        <div class="row">
                            <label class="col-md-2 mt-2" for="jeu">URL(s)</label>
                            <input type="text" class="form-control col-md-4" name="auteur_url"  >
                            <label class="col-md-2 mt-2" for="jeu">ID réseaux sociaux</label>
                            <input type="email" class="form-control col-md-4" name="auteur_rs"   >
                        </div>

                        <div class="form-group">
                            {{ Form::label('password', 'Mot de passe *') }}<br>
                            {{ Form::text('password', str_random( 10 ) , array('class' => 'form-control-plaintext', 'required')) }}

                        </div>


                        <div class='form-group'>
                            {{ Form::label('roles', 'Profil *') }}
                            {{ Form::select('roles', ['null' => '' ] + $roles_to_array, array('required', 'id'=>'roles')) }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}



@endsection
@push('scripts')
    <script>
        $(function() {

        });
    </script>
@endpush
