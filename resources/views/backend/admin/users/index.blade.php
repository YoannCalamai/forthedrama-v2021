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
                                <h2>Utilisateurs</h2>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('users.create') }}" class="btn btn-danger   btn-sm btn-sm m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fa fa-plus mr-2"></i><span>Créer</span></span> </a>
                                <a href="{{ route('users.export') }}" class="btn btn-excel btn-sm  m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fa fa-file-excel  mr-2"></i><span> Export Excel</span></span> </a>


                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped m-table table-hover">

                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Login</th>
                                <th>Email</th>
                                <th>Profil</th>
                                <th class="m--align-right" width="10%">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($users as $user)
                                <tr>

                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                                    <td class="m--align-right">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 bd-highlight">
                                                <a href="{{ route('users.edit', $user->id) }}" class=" btn btn-danger btn-sm mt-1 " title="Modifier l'utilisateur">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('users.connectAs', $user->id) }}" class=" btn btn-danger btn-sm mt-1 " title="Se connecter comme l'utilisateur">
                                                    <i class="fa fa-angle-right"></i>
                                                </a>


                                            </div>
                                            <div class="p-2 bd-highlight">
                                                {!! Form::open(['method' => 'DELETE', 'class' => 'inline', 'route' => ['users.destroy', $user->id] ]) !!}
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

                        {{--<form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ url('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">--}}
                            {{--@csrf--}}

                            {{--@if ($errors->any())--}}
                                {{--<div class="alert alert-danger">--}}
                                    {{--<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>--}}
                                    {{--<ul>--}}
                                        {{--@foreach ($errors->all() as $error)--}}
                                            {{--<li>{{ $error }}</li>--}}
                                        {{--@endforeach--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--@endif--}}

                            {{--@if (Session::has('success'))--}}
                                {{--<div class="alert alert-success">--}}
                                    {{--<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>--}}
                                    {{--<p>{{ Session::get('success') }}</p>--}}
                                {{--</div>--}}
                            {{--@endif--}}

                            {{--<input type="file" name="import_file" />--}}
                            {{--<button class="btn btn-primary">Import fichier Excel</button>--}}
                        {{--</form>--}}
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.table thead tr').clone(true).appendTo( '.table thead' );
            $('.table thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var table = $('.table').DataTable( {
                "language": {processing:"Traitement en cours...",search:"Rechercher&nbsp;:",lengthMenu:"Afficher _MENU_ &eacute;l&eacute;ments",info:"Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",infoEmpty:"Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",infoFiltered:"(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",infoPostFix:"",loadingRecords:"Chargement en cours...",zeroRecords:"Aucun &eacute;l&eacute;ment &agrave; afficher",emptyTable:"Aucune donnée disponible dans le tableau",paginate:{first:"Premier",previous:"Pr&eacute;c&eacute;dent",next:"Suivant",last:"Dernier"},aria:{sortAscending:": activer pour trier la colonne par ordre croissant",sortDescending:": activer pour trier la colonne par ordre décroissant"}},
                orderCellsTop: true,
                fixedHeader: true,
                "pageLength": 100
            } );
        });
    </script>
@endpush
