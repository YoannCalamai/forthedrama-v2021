@extends('backend.layout.app')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <h2>Contenus</h2>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('contenus.create') }}" class="btn btn-warning btn-sm m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fa fa-plus mr-2"></i><span>Créer</span></span> </a>

                            </div>
                        </div>

                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-default">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contenus as $contenu)
                                    <tr>
                                        <td>{{$contenu->id}}</td>
                                        <td>{{$contenu->name}}</td>
                                        <td class="m--align-right">
                                            <div class="d-flex  bd-highlight">
                                                <div class="p-2 bd-highlight">
                                                    <a href="{{ route('contenus.edit', $contenu->id) }}" class="btn btn-danger btn-sm    " title="Modifier le droit">
                                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                                    </a>


                                                </div>
                                                <div class="p-2">
                                                    {!! Form::open(['method' => 'DELETE', 'class' => 'inline', 'route' => ['contenus.destroy', $contenu->id] ]) !!}
                                                    <button class="btn btn-danger btn-sm    button-delete " title="Supprimer">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                    {!! Form::close() !!}
                                                </div>

                                            </div>

                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@push('scripts')
    <script>
        $(function() {

            var table = $('.table').DataTable( {
                "language": {processing:"Traitement en cours...",search:"Rechercher&nbsp;:",lengthMenu:"Afficher _MENU_ &eacute;l&eacute;ments",info:"Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",infoEmpty:"Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",infoFiltered:"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",infoPostFix:"",loadingRecords:"Chargement en cours...",zeroRecords:"Aucun &eacute;l&eacute;ment &agrave; afficher",emptyTable:"Aucune donnée disponible dans le tableau",paginate:{first:"Premier",previous:"Pr&eacute;c&eacute;dent",next:"Suivant",last:"Dernier"},aria:{sortAscending:": activer pour trier la colonne par ordre croissant",sortDescending:": activer pour trier la colonne par ordre décroissant"}},
                orderCellsTop: true,
                fixedHeader: true,
                "pageLength": 100
            } );
        });
    </script>
@endpush
