{{-- \resources\views\users\edit.blade.php --}}

@extends('backend.layout.app')

@section('title', '| Modifier un Utilisateur')

@section('content')
    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with user data --}}


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <h2>Modifier l'utilisateur {{$user->name}}</h2>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left mr-2" aria-hidden="true"></i><span>Retour</span></span> </a>
                                <button type="submit" class="btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fas fa-save mr-2" aria-hidden="true"></i><span>Enregistrer</span></span></button>
                            </div>
                        </div>
                    </div>

                    <nav class="nav nav-tabs">
                        <a class="nav-item nav-link active" href="#p1" data-toggle="tab">Compte</a>
                        <a class="nav-item nav-link" href="#jeu" data-toggle="tab">Jeux</a>
                    </nav>
                    <div class="tab-content">
                        <div class="tab-pane active" id="p1">
                            <div class="m-portlet__body">

                                <div class="form-group">
                                    {{ Form::label('name', 'Nom *') }}
                                    {{ Form::text('name', $user->name , array('class' => 'form-control', 'required')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('name', 'Login *') }}
                                    {{ Form::text('name', $user->name , array('class' => 'form-control', 'required')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('email', 'Email *') }}
                                    {{ Form::email('email', $user->email, array('class' => 'form-control', 'required')) }}

                                </div>


                                <div class="row">
                                    <label class="col-md-2 mt-2" for="jeu">Nom</label>
                                    <input type="text" class="form-control col-md-4" name="auteur_nom" value="{{ $user->auteur_nom }}"  >
                                    <label class="col-md-2 mt-2" for="jeu">Email</label>
                                    <input type="email" class="form-control col-md-4" name="auteur_email" value="{{ $user->auteur_email }}"  >
                                </div>
                                <div class="row">
                                    <label class="col-md-2 mt-2" for="jeu">URL(s)</label>
                                    <input type="text" class="form-control col-md-4" name="auteur_url" value="{{ $user->auteur_url }}"  >
                                    <label class="col-md-2 mt-2" for="jeu">ID réseaux sociaux</label>
                                    <input type="text" class="form-control col-md-4" name="auteur_rs" value="{{ $user->auteur_rs}}"  >
                                </div>


                                <div class="form-group">
                                    {{ Form::label('password', 'Mot de passe *') }}<br>
                                    {{ Form::password('password',  array('class' => 'form-control')) }}

                                </div>
                                <div class="form-group">
                                    {{ Form::label('password_confirmation', 'Confirmer le mot de passe') }}<br>
                                    {{ Form::password('password_confirmation', array('class' => 'form-control')) }}

                                </div>

                                <div class='form-group'>

                                    <label>Groupe *</label>
                                    {{ Form::select('roles', $roles_to_array, $user_role_id , ['class' => 'form-control', 'id' => 'roles', 'required']) }}



                                </div>


                            </div>
                        </div>
                        <div class="tab-pane" id="jeu">
                            <div class="m-portlet__body">

                                <div class="form-group">
                                    {{ Form::label('jeux', "Est l'auteur des jeux :") }}
                                    <div class="m-checkbox-list">
                                        @foreach( $jeux as $jeu )
                                            <label class="m-checkbox">
                                                <input type="checkbox" @if( $user->hasJeu ($jeu ) ) checked="checked" @endif name="jeux[]"  value="{{ $jeu->id }}"> {{ $jeu->jeu }}
                                                <span></span>
                                            </label> <br />
                                        @endforeach
                                    </div>
                                </div>
                            </div>


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
