{{-- \resources\views\users\index.blade.php --}}
@extends('backend.layout.app')
@section('title', '| Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <h2>Groupes Utilisateurs</h2>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('roles.create') }}" class="btn btn-warning  btn-sm m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fa fa-plus mr-2"></i><span>Créer</span></span> </a>

                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped m-table table-hover">

                            <thead>
                            <tr>
                                <th>Groupe</th>

                                <th class="m--align-right" width="10%">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($roles as $role)
                                <tr>

                                    <td>{{ $role->name }}</td>

                                    <td class="m--align-right">
                                        <div class="d-flex  bd-highlight">
                                            <div class="p-2 bd-highlight">
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-danger btn-sm mt-1 " title="Modifier le groupe">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>


                                            </div>
                                            <div class="p-2">
                                                {!! Form::open(['method' => 'DELETE', 'class' => 'inline', 'route' => ['roles.destroy', $role->id] ]) !!}
                                                <button class="btn btn-danger btn-sm mt-1  button-delete " title="Supprimer">
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
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.table').DataTable({
                "language": {processing:"Traitement en cours...",search:"Rechercher&nbsp;:",lengthMenu:"Afficher _MENU_ &eacute;l&eacute;ments",info:"Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",infoEmpty:"Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",infoFiltered:"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",infoPostFix:"",loadingRecords:"Chargement en cours...",zeroRecords:"Aucun &eacute;l&eacute;ment &agrave; afficher",emptyTable:"Aucune donnée disponible dans le tableau",paginate:{first:"Premier",previous:"Pr&eacute;c&eacute;dent",next:"Suivant",last:"Dernier"},aria:{sortAscending:": activer pour trier la colonne par ordre croissant",sortDescending:": activer pour trier la colonne par ordre décroissant"}},
            });
        });
    </script>
@endpush
