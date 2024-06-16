@extends('backend.layout.app')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Droits</h2>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-default">
                                <tr>
                                    <th>#</th>
                                    <th>Permission</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activitiesPaginator as $activity)
                                    <tr>
                                        <td>{{$activity->id}}</td>
                                        <td>{{$activity->name}}</td>

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
                fixedHeader: true
            } );
        });
    </script>
@endpush
