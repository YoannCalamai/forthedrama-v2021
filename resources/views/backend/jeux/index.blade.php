@extends('backend.layout.app')

@section('content')



            <div class="row">
                <div class="col-lg-12  bk-white txt-black p-4">
{{--                    <h1>{{ count( $jeux) }} jeux</h1>--}}

                    <table class="table table-striped table-hover" id="jeus-index">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Nom
                                </th>
                                @if( \Auth::user()->hasRole('administrateur')  )
                                    <th>Auteur.e</th>
                                @endif
                                <th>
                                    Publié ?
                                </th>
                                <th>
                                    Demande publication
                                </th>

                                <th>
                                    Création
                                </th>
                                <th>
                                    Modification
                                </th>
                                {{--<th></th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $jeux as $jeu)
                                @if( $jeu->jeu != '')
                                    <tr class=" clickable-row" data-href="{{ route('jeux.edit', $jeu->id) }}">
                                        <td>
                                            <a href="{{ route('jeux.edit', $jeu->id) }}" class="btn btn-primary"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $jeu->jeu  }}</td>
                                        @if( \Auth::user()->hasRole('administrateur')  )
                                            <td>
                                                {{ $jeu->afficheNomUser() }}
                                            </td>
                                        @endif
                                        <td>@if( $jeu->is_publie == 1) Oui @endif</td>
                                        <td>@if( $jeu->is_demande_publie == 1) <span class="badge-pill badge-danger">  Oui </span> @endif</td>
                                        <td>{{ Helper::getDateHumanFr( $jeu->created_at )  }}</td>
                                        <td>{{ Helper::getDateHumanFr( $jeu->updated_at )  }}</td>


                                    </tr>
                                @endif

                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });

            var table = $('.table').DataTable( {
                "language": {processing:"Traitement en cours...",search:"Rechercher&nbsp;:",lengthMenu:"Afficher _MENU_ &eacute;l&eacute;ments",info:"Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",infoEmpty:"Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",infoFiltered:"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",infoPostFix:"",loadingRecords:"Chargement en cours...",zeroRecords:"Aucun &eacute;l&eacute;ment &agrave; afficher",emptyTable:"Aucune donnée disponible dans le tableau",paginate:{first:"Premier",previous:"Pr&eacute;c&eacute;dent",next:"Suivant",last:"Dernier"},aria:{sortAscending:": activer pour trier la colonne par ordre croissant",sortDescending:": activer pour trier la colonne par ordre décroissant"}},
                orderCellsTop: true,
                fixedHeader: true,
                "pageLength": 100,
                "order": [[ 5, "desc" ]],
                "stateSave": true
            } );
        });
    </script>
@endpush