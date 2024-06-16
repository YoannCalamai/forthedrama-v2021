@extends('backend.layout.app')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-0">

                        <div class="d-flex justify-content-between bd-highlight">
                            <div class="p-2 bd-highlight">
                                <h2>{{ $jeu->jeu}}</h2>
                            </div>
                            <div class="p-2 bd-highlight">
                                <label>Traduire :</label>
                                <select class="selectpicker" data-width="fit">
                                    <option>> Choix de la langue</option>
                                    <option @if( $lang == 'de' ) selected="selected" @endif data-url="{{url('locale/de')}}" data-content='Deutsch'>Deutsch</option>
                                    <option @if( $lang == 'en' ) selected="selected" @endif data-url="{{url('locale/en')}}" data-content='English'>English</option>
                                    <option @if( $lang == 'es' ) selected="selected" @endif data-url="{{url('locale/es')}}" data-content='Español'>Español</option>
                                    <option @if( $lang == 'fr' ) selected="selected" @endif data-url="{{url('locale/fr')}}" data-content='Français'>Français</option>
                                    <option @if( $lang == 'jp' ) selected="selected" @endif data-url="{{url('locale/jp')}}" data-content='日本語'>日本語</option>


                                </select>

                            </div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('cartes.export', $jeu->id) }}" class="btn btn-excel m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-download mr-2" aria-hidden="true"></i><span>Télécharger</span></span> </a>
                                <a href="{{ route('cartes.importfront', $jeu->id) }}" class="btn btn-excel m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-upload mr-2" aria-hidden="true"></i><span>Importer</span></span> </a>
                                <a href="{{ url('games/' . $jeu->slug) }}" target="_blank"  class="btn btn-info " >Tester</a>
                                <a href="{{ route('jeux.edit', $jeu->id) }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left mr-2" aria-hidden="true"></i><span>Retour au jeu</span></span> </a>
                           </div>
                        </div>
                    </div>

                        <div class="row" style="width:100%">
                            <div class="col-lg-12  bk-white txt-black p-4">
                                <meta name="csrf-token" content="{{ csrf_token() }}">


                                {{ Form::open(['route' => ['cartes.filtre', $jeu->id], 'method' => 'post', 'id' => 'filtrecarte']) }}
                                    @csrf

                                    <div class="d-flex flex-row">
                                        <div class="p-2 mt-3"><label for="filtre_annee">Filtrer par type : </label> </div>
                                        <div class="p-4">   {!! Form::select('filtre_carte', [''=>'-- tous --', 'instruction' => 'instruction', 'question'=>'question', 'finale'=>'finale' ]  , $filtre_carte, [  'id' => 'filtre_statut', 'class' => 'form-control ' ]) !!} </div>
                                        <div class="p-2 mt-3"><button id="filtrer" class="btn btn-danger btn-sm mt-1"><i class="fas fa-filter" aria-hidden="true"></i></button></div>
                                    </div>
                                {{ Form::close() }}

                                <table class="table table-striped table-hover" id="carte-index">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                            Carte
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            Groupe (optionnel)
                                        </th>
                                        <th></th>

                                    </tr>
                                    </thead>
                                    <tbody class="clickable-row">

                                    @foreach( $cartes as $carte)
                                        <tr data-href="" id="{{ $carte->id }}">
                                            <td> <i class="fas fa-arrows-alt" aria-hidden="true"></i> </td>
                                            <td>
                                                <textarea rows="3" cols="150" maxlength="800" data-id="{{  $carte->id  }}" class="form-control maxlength texte-carte" name="texte-carte">{{ $carte->carte  }}</textarea>

                                            </td>
                                            {{--<td>{{ $carte->type  }}</td>--}}
                                            <td>
                                                <select name="type-carte" class="type-carte" data-id="{{  $carte->id  }}">
                                                    <option></option>
                                                    <option @if( $carte->type == 'instruction') selected="selected" @endif>instruction</option>
                                                    <option @if( $carte->type == 'question') selected="selected" @endif>question</option>
                                                    <option @if( $carte->type == 'finale') selected="selected" @endif>finale</option>
                                                </select>
                                            </td>
                                            <td>
                                               <input type="number" min="0" step="1" value="{{ $carte->groupe }}" class="form-control groupe  @if( $carte->type != 'question') hide @endif " name="groupe" data-id="{{  $carte->id  }}" style="max-width:75px;">
                                            </td>
                                            <td>

                                                <button class="btn btn-danger btn-sm mt-1  button-delete-carte " title="Supprimer la carte" data-id="{{  $carte->id  }}">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    <div class="row mt-1">
                        <div class="col-md-12">
                            @if( count ( $cartes ) > 0 )
                                <button id="ajout-carte" class="btn btn-danger btn-lg col-md-12" >Ajouter une carte</button>
                            @else
                                <a href="{{ route('cartes.premierecarte', $jeu->id) }}"  class="btn btn-danger btn-lg col-md-12" >Ajouter une première carte</a>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset( 'js/vendor/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('.selectpicker').on('change', function(){
                var url = $(this).find(':selected').data('url');
                window.location = url;
            });

            $('body').on('click', '.button-delete-carte', function (e) {
                e.preventDefault();
                var form = $(this).parents('form');
                var carte_id = $(this).attr("data-id");
                swal({
                    title: "Etes-vous sûr?",
                    text: "Cette carte sera supprimée si vous confirmez",
                    icon: "warning",
                    buttons: [
                        'Annuler',
                        'Oui, supprimer'
                    ],
                    dangerMode: true,

                }).then( function(willDelete)  {
                    if (willDelete == true) {

                        jQuery.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"{{ route('cartes.delete') }}",
                            type:'put',
                            data:{carte_id:carte_id},
                            success:function(  ){
                                toastr.success("Carte supprimée", "", {
                                    timeOut: "3000", closeButton: !0
                                });
                            },
                            error: function(){
                                toastr.error("Une erreur est survenue", "Carte supprimée", {
                                    timeOut: "3000", closeButton: !0
                                });
                            }
                        });
                        $('table#carte-index tr#' + carte_id).remove();
                    } else {

                    }
                });
            });

            $('body').on('change', '.groupe', function(){
                var carte_id = $(this).attr("data-id");
                var groupe = $(this).val();

                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('cartes.update') }}",
                    type:'post',
                    data:{carte_id:carte_id,groupe:groupe},
                    // success:function(  ){
                    //     toastr.success("Carte modifiée", "Carte modifiée", {
                    //         timeOut: "3000", closeButton: !0
                    //     });
                    //
                    // },
                    error: function(){
                        toastr.error("Une erreur est survenue", "Carte modifiée", {
                            timeOut: "3000", closeButton: !0
                        });
                    }
                });
            });

            $('body').on('change', '.type-carte', function(){
                var carte_id = $(this).attr("data-id");
                var carte_type = $(this).val();

                if( carte_type == 'question' ) {
                    $(this).closest('td').next().find('.groupe').removeClass('hide');
                }else{
                    $(this).closest('td').next().find('.groupe').addClass('hide');
                }

                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('cartes.update') }}",
                    type:'post',
                    data:{carte_id:carte_id,carte_type:carte_type},
                    // success:function(  ){
                    //     toastr.success("Carte modifiée", "Carte modifiée", {
                    //         timeOut: "3000", closeButton: !0
                    //     });
                    //
                    // },
                    error: function(){
                        toastr.error("Une erreur est survenue", "Carte modifiée", {
                            timeOut: "3000", closeButton: !0
                        });
                    }
                });
            });

            $('body').on('change', '.texte-carte', function(){
                var carte_id = $(this).attr("data-id");
                var carte_texte = $(this).val();

                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('cartes.update') }}",
                    type:'post',
                    data:{carte_id:carte_id,carte_texte:carte_texte},
                    // success:function(  ){
                    //     toastr.success("Carte modifiée", "Carte modifiée", {
                    //         timeOut: "3000", closeButton: !0
                    //     });
                    //
                    // },
                    error: function(){
                        toastr.error("Une erreur est survenue", "Carte modifiée", {
                            timeOut: "3000", closeButton: !0
                        });
                    }
                });
            });

            $('#ajout-carte').on('click', function(){
                var $tableBody = $('#carte-index').find("tbody"),
                    $trLast = $tableBody.find("tr:last"),
                    $trNew = $trLast.clone();
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{ route('cartes.create') }}",
                    type:'post',
                    data:{jeu_id:{{ $jeu->id }} },
                    success:function( retour_id ){
                        toastr.success("Carte créée", "", {
                            timeOut: "3000", closeButton: !0
                        });
                        $trLast.after($trNew);
                        $trNew.attr('id', retour_id);
                        $textecarteLast = $tableBody.find(".texte-carte:last");
                        $textecarteLast.val('');
                        $textecarteLast.attr('data-id', retour_id);
                        $typecarteLast = $tableBody.find(".type-carte:last");
                        $typecarteLast.val('');
                        $typecarteLast.attr('data-id', retour_id);
                        $groupeLast = $tableBody.find(".groupe:last");
                        $groupeLast.attr('data-id', retour_id);
                        $groupeLast.val('');
                        $deleteLast = $tableBody.find(".button-delete-carte:last");
                        $deleteLast.attr('data-id', retour_id);
                    }
                })



            })

            var table = $('#carte-index').DataTable( {
                "language": {processing:"Traitement en cours...",search:"Rechercher&nbsp;:",lengthMenu:"Afficher _MENU_ &eacute;l&eacute;ments",info:"Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",infoEmpty:"Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",infoFiltered:"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",infoPostFix:"",loadingRecords:"Chargement en cours...",zeroRecords:"Aucun &eacute;l&eacute;ment &agrave; afficher",emptyTable:"Aucune donnée disponible dans le tableau",paginate:{first:"Premier",previous:"Pr&eacute;c&eacute;dent",next:"Suivant",last:"Dernier"},aria:{sortAscending:": activer pour trier la colonne par ordre croissant",sortDescending:": activer pour trier la colonne par ordre décroissant"}},
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { type: 'date-uk', targets: 3 }
                ],
                "pageLength": 300,
                "paging":   false,
                "ordering": false,
                "info":     false
            } );

            jQuery( ".clickable-row" ).sortable({
                delay: 150,
                stop: function() {
                    var selectedData = new Array();
                    $('.clickable-row>tr').each(function() {
                        selectedData.push($(this).attr("id"));
                    });
                    updateOrder(selectedData, {{ $jeu->id }});
                }
            });


            function updateOrder(data, jeu_id ) {

                jQuery.ajax({

                    url:"{{ route('cartes.changenumero') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:'post',
                    data:{position:data,jeu_id:jeu_id },
                    success:function(){
                        toastr.success("Carte déplacée", "Carte déplacée", {
                            timeOut: "3000", closeButton: !0
                        });
                    }
                })
            }
        });
    </script>
@endpush