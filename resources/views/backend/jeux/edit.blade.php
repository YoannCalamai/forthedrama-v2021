@extends('backend.layout.app')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('jeux.update', $jeu) }}" id="form_jeu" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-title">

                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    <h2 class="titre-rose">Modification du jeu {{ $jeu->jeu}}</h2>
                                </div>
                                <div class="p-2 bd-highlight"></div>
                                <div class="p-2 bd-highlight">
                                    <a href="{{ route('jeux.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left mr-2" aria-hidden="true"></i><span>Retour</span></span> </a>
                                    <a href="{{ route('cartes.index', $jeu->id) }}" class="btn btn-danger" >Cartes</a>
                                    <a href="{{ url('games/' . $jeu->slug) }}" target="_blank"  class="btn btn-info " >Tester</a>
                                    <a class="btn btn-default  mt-1" title="Supprimer" href="{{ route('jeux.predestroy', $jeu->id ) }}">
                                        <i class="fas fa-trash" aria-hidden="true"></i> Supprimer le jeu
                                    </a>


                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12  bk-white txt-black p-4">


                                <div class="row">
                                    <div class="col-md-4">
                                        @if( $jeu->is_demande_publie == 1 && $jeu->is_publie != 1)
                                            <p>Votre demande de publication est en cours de traitement.
                                            </p>
                                        @else
                                            @if(  !\Auth::user()->hasRole('administrateur')  )
                                                @if( $jeu->is_publie == 1)
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" value="1" name="is_publie"  id="is_publie" checked="checked"><span>Publié </span><span class="checkmark"></span>
                                                    </label>
                                                @else
                                                    <label class="checkbox checkbox-primary">
                                                        <input type="checkbox" value="1" name="is_demande_publie"  id="is_demande_publie" @if( $jeu->is_demande_publie == 1) checked="checked" @endif><span>Demander la publication du jeu </span><span class="checkmark"></span>
                                                    </label>
                                                @endif
                                            @endif
                                        @endif
                                    </div>

                                    @if(  \Auth::user()->hasRole('administrateur')  )
                                        <div class="col-md-4">


{{--                                                <input type="checkbox" value="1" name="is_publie_admin"  id="is_publie" @if( $jeu->is_publie == 1) checked="checked" @endif><span>Publié ? (admin) </span><span class="checkmark"></span>--}}
                                            <label>Publication :</label>
                                            <select name="is_publie_admin">
                                                <option></option>
                                                <option value="Publié"  @if( $jeu->is_publie == 1) selected="selected" @endif>Publié</option>
                                                <option value="Non Publié" @if( $jeu->is_publie != 1) selected="selected" @endif >Non Publié</option>
                                            </select>

                                        </div>
                                    @endif

                                </div>
                                <div class="row">
                                    <label class="col-md-2 mt-2" for="jeu">Nom</label>
                                    <input type="text" class="form-control col-md-9" name="jeu" value="{{ $jeu->jeu }}" required >
                                </div>
                                <div class="row mt-2 mb-4">
                                    <label class="col-md-2 mt-2" for="jeu">Intro (limité à 200 car., s'affiche dans la liste de sélection des jeux)</label>
                                    <textarea rows="5" maxlength="200" class="form-control col-md-9 maxlength" name="intro">{{ $jeu->intro }}</textarea>
                                </div>
                                <div class="row mt-2">
                                    <label class="col-md-2 mt-2" for="jeu">Texte présentation complet (s'affiche dans la page dédiée au jeu)</label>
                                    <textarea rows="8" class="form-control col-md-9" name="presentation">{{ $jeu->presentation }}</textarea>
                                </div>
                                <div class="row mt-2">
                                    <label class="col-md-2 mt-2" for="jeu">Licence de publication</label>
                                    <select name="licence" id="licence" class="form-control col-md-3">
                                        <option @if( $jeu->licence =="Domaine Publique") selected="selected" @endif>Domaine Publique</option>
                                        <option @if( $jeu->licence =="Creative Commons - CC BY-SA") selected="selected" @endif>Creative Commons - CC BY-SA</option>
                                        <option @if( $jeu->licence =="Creative Commons - CC BY-NC-SA") selected="selected" @endif>Creative Commons - CC BY-NC-SA</option>
                                        <option @if( $jeu->licence =="Creative Commons - CC BY-NC-ND") selected="selected" @endif>Creative Commons - CC BY-NC-ND</option>
                                    </select>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="titre-violet">Illustration</h2>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label class="col-md-2 mt-2" for="jeu">Image</label>
                                    <input type="file" class="col-md-2" name="illustration">
                                    <div class="col-md-3">
                                        <button type="submit" class="ml-5 btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fas fa-save mr-2" aria-hidden="true"></i><span>Enregistrer l'image</span></span></button>
                                    </div>
                                    @if( $jeu->image != '')

                                            <div class="col-md-4">
                                                <a href="{{ $jeu->urlIllustration() }}" class="btn btn-danger col-md-3 ml-2" target="_blank"> <span><i class="fas fa-eye mr-2" aria-hidden="true"></i><span>Voir</span></span> </a>
                                            </div>

                                    @endif
                                </div>


                                <div class="row">
                                    <label class="col-md-2 mt-2" for="jeu">Licence de l'image</label>
                                    <input type="text" class="form-control col-md-9" name="image_licence" value="{{ $jeu->image_licence }}"  >
                                </div>
                                <div class="row mt-2">
                                    <label class="col-md-2 mt-2" for="jeu">Auteur.e de l'image</label>
                                    <input type="text" class="form-control col-md-9" name="image_auteur" value="{{ $jeu->image_auteur }}"  >
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <h2 class="titre-violet">Catégorie</h2>
                                        <p>
                                            Attribuer une catégorie à votre jeu
                                        </p>
                                    </div>
                                    <div class="col-md-9">

                                        <select name="categorie_id" class="form-control col-3">
                                            <option></option>
                                            @foreach( \App\Categorie::orderBy('categorie', 'asc')->get() as $categorie )
                                                <option value="{{ $categorie->id }}">{{ $categorie->categorie }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="titre-violet">Auteur (si ce n'est pas vous)</h2>
                                    </div>
                                </div>
                                @if( \Auth::user()->hasRole('administrateur')  )
                                    <div class="row mt-2">
                                        <label class="col-md-2 mt-2" for="jeu">Utilisateur</label>
                                        {{ Form::select('user_id', $users, $jeu->user_id , ['class' => 'form-control col-md-4', 'id' => 'user_id']) }}

                                    </div>

                                @endif
                                <div class="row mt-2">
                                    <label class="col-md-2 mt-2" for="jeu">Nom</label>
                                    <input type="text" class="form-control col-md-4" name="auteur_nom" value="{{ $jeu->auteur_nom }}"  >
                                    <label class="col-md-2 mt-2" for="jeu">Email</label>
                                    <input type="email" class="form-control col-md-4" name="auteur_email" value="{{ $jeu->auteur_email }}"  >
                                </div>
                                <div class="row mt-2">
                                    <label class="col-md-2 mt-2" for="jeu">URL(s)</label>
                                    <input type="text" class="form-control col-md-4" name="auteur_url" value="{{ $jeu->auteur_url }}"  >
                                    <label class="col-md-2 mt-2" for="jeu">ID réseaux sociaux</label>
                                    <input type="text" class="form-control col-md-4" name="auteur_rs" value="{{ $jeu->auteur_rs}}"  >
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h2 class="titre-violet">Durée d'une partie</h2>
                                <p>Vous pouvez modifier le nombre de cartes proposées par défaut pour chaque option de durée au lancement d'une partie</p>
                                <p>
                                    <strong>Attention</strong> : la valeur de ces options ne doit pas excéder le nombre de cartes questions de votre jeux.
                                </p>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th>Durée</th>
                                        <th>Nombre de cartes</th>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Rapide (< 1 H)</td>
                                            <td>
                                                <input type="text" class="form-control col-md-4" name="duree_rapide" value="{{ $jeu->duree_rapide }}"  >
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Moyenne (2 H)</td>
                                            <td>
                                                <input type="text" class="form-control col-md-4" name="duree_moyenne" value="{{ $jeu->duree_moyenne }}"  >
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Longue (3 H)</td>
                                            <td>
                                                <input type="text" class="form-control col-md-4" name="duree_longue" value="{{ $jeu->duree_longue }}"  >
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Très longue ( 3+ h)</td>
                                            <td>
                                                <p>Cette option comprend toutes les cartes de votre jeu</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>
                                    A prévoir :
                                    <ul>
                                        <li> option avancée avec gestion du nombre de cartes tirées en +</li>
                                        <li> nombre de cartes à tirer par groupe.</li>
                                        <li> options de durée accessibles lors de l'initialisation d'une partie</li>
                                    </ul>

                                </p>
                            </div>
                        </div> <!-- / row -->


                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-4 ml-4">

            <div class="col-md-12 mt-2">
                <a href="{{ url('games/' . $jeu->slug) }}" target="_blank" class="btn btn-info btn-lg col-md-12" >Tester</a>
            </div>

            <div class="col-md-12 mt-2">
                <a href="{{ route('cartes.index', $jeu->id) }}" class="btn btn-danger btn-lg col-md-12" >Gérer les cartes</a>
            </div>

            <div class="col-md-12 pull-md-right">
                <a class="btn btn-success  mt-1 btn-lg col-md-12" title="Supprimer" href="{{ route('jeux.predestroy', $jeu->id ) }}">
                    <i class="fas fa-trash" aria-hidden="true"></i> Supprimer le jeu
                </a>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function(){

            // auto save
            function saveToDB( champ )
            {

                $.ajax({
                    type: 'post',
                    url: '{{ route('jeux.update.ajax', $jeu->id  ) }}',
                    data: $('#form_jeu').serialize()
                });

            }

            var timeoutId;
            $('#form_jeu textarea').on('input propertychange change', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function( )  {
                    // Runs 1 second (1000 ms) after the last change
                    saveToDB(  );
                }, 1000);
            });

            $('#form_jeu input').on('input propertychange change', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    // Runs 1 second (1000 ms) after the last change
                    saveToDB(  );
                }, 1000);
            });

            $('#form_jeu select').on('input propertychange change', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    // Runs 1 second (1000 ms) after the last change
                    saveToDB(  );
                }, 1000);
            });

            // touche ENTREE
            $('form input').keydown(function (e) {
                if (e.keyCode == 13) {
                    var inputs = $(this).parents("form").eq(0).find(":input");
                    if (inputs[inputs.index(this) + 1] != null) {
                        inputs[inputs.index(this) + 1].focus();
                    }
                    e.preventDefault();
                    return false;
                }
            });

            $('body').on('click', '#is_demande_publie', function (e) {
                e.preventDefault();

                if( $("#is_demande_publie"). is(":checked") ){
                    swal({
                        title: "Etes-vous sûr?",
                        text: "Vous allez demander la publication de votre jeu ! Les modérateurs de For the Drama vont étudier votre jeu puis prendre une décision quant à sa publication.",
                        icon: "success",
                        buttons: [
                            'Annuler',
                            "Ok, j'ai bien compris !"
                        ]

                    }).then( function(willDelete)  {
                        if (willDelete == true) {
                            $("#is_demande_publie").prop("checked", true);
                            $( "#is_demande_publie" ).trigger("change");
                        }
                    });
                }else{
                    swal({
                        title: "Etes-vous sûr?",
                        text: "Attention : cette action va dépublier votre jeu : il ne sera plus accessible à tous. ",
                        icon: "warning",
                        buttons: [
                            'Annuler',
                            "Ok, j'ai bien compris !"
                        ],
                        dangerMode: true,

                    }).then( function(willDelete)  {
                        if (willDelete == true) {
                            $( "#is_demande_publie" ).prop( "checked", false );
                            $( "#is_demande_publie" ).trigger("change");
                        }
                    });
                }

            });

            $('body').on('click', '#is_publie', function (e) {
                e.preventDefault();

                if( $("#is_publie"). is(":checked") ){
                    swal({
                        title: "Etes-vous sûr?",
                        text: "Cette action va publier le jeu",
                        icon: "success",
                        buttons: [
                            'Annuler',
                            "Ok, j'ai bien compris !"
                        ]

                    }).then( function(willDelete)  {
                        if (willDelete == true) {
                            $("#is_publie").prop("checked", true);
                            $( "#is_publie" ).trigger("change");
                        }
                    });
                }else{
                    swal({
                        title: "Etes-vous sûr?",
                        text: "Attention : cette action va dépublier le jeu",
                        icon: "warning",
                        buttons: [
                            'Annuler',
                            "Ok, j'ai bien compris !"
                        ],
                        dangerMode: true,

                    }).then( function(willDelete)  {
                        if (willDelete == true) {
                            $( "#is_publie" ).prop( "checked", false );
                            $( "#is_publie" ).trigger("change");
                        }
                    });
                }

            });

        });
    </script>
@endpush