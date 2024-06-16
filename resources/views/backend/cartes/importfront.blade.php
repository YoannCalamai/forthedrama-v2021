@extends('backend.layout.app')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ route('cartes.import') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="jeu_id" value="{{ $jeu->id }}">
                        @csrf
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
                               <a href="{{ route('cartes.index', $jeu->id) }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left mr-2" aria-hidden="true"></i><span>Retour</span></span> </a>
                           </div>
                        </div>
                    </div>

                        <div class="row" style="width:100%">
                            <div class="col-lg-12  bk-white txt-black p-4">
                                <p>
                                    Pour importer des cartes, vous devez déposer un fichier au format Excel ".xlsx" dans un format identiques à celui de la fonction
                                    <a href="{{ route('cartes.export', $jeu->id) }}" target="_blank">Télécharger</a>.
                                </p>
                                <p>
                                    Cette action va remplacer toutes les cartes du jeu par celles figurant dans le fichier Excel
                                </p>



                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (Session::has('success'))
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                            <p>{{ Session::get('success') }}</p>
                                        </div>
                                    @endif

                                    <input type="file" name="import_file" />



                            </div>
                        </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button id="ajout-carte" class="btn btn-danger btn-lg col-md-12" >
                                <span><i class="fas fa-upload mr-2" aria-hidden="true"></i><span>Importer des cartes</span></span>
                            </button>
                        </div>
                    </div>
                    </form>
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
                                toastr.success("Carte supprimée", "Carte supprimée", {
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
                    success:function(  ){
                        toastr.success("Carte modifiée", "Carte modifiée", {
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
                    success:function(  ){
                        toastr.success("Carte modifiée", "Carte modifiée", {
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
                    success:function(  ){
                        toastr.success("Carte modifiée", "Carte modifiée", {
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
                        toastr.success("Carte créée", "Carte créée", {
                            timeOut: "3000", closeButton: !0
                        });
                        $trLast.after($trNew);
                        $trNew.attr('id', retour_id);
                        $textecarteLast = $tableBody.find(".texte-carte:last");
                        $textecarteLast.val('');
                        $textecarteLast.attr('data-id', retour_id);
                        $typecarteLast = $tableBody.find(".type-carte:last");
                        $typecarteLast.val('question');
                        $typecarteLast.attr('data-id', retour_id);
                        $groupeLast = $tableBody.find(".groupe:last");
                        $groupeLast.attr('data-id', retour_id);
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