@extends('backend.layout.app')

@section('content')



            <div class="row">
                <div class="col-lg-12  bk-white txt-black p-4">

                    <table class="table table-striped table-hover" id="jeus-index">
                        <thead>
                            <tr>
                                <th>
                                    Nom
                                </th>
                                <th>
                                    Suppression
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $jeux as $jeu)
                                <tr class=" clickable-row" data-href="{{ route('jeux.edit', $jeu->id) }}">
                                    <td>{{ $jeu->jeu  }}</td>
                                    <td>@if( $jeu->is_publie == 1) Oui @endif</td>
                                    <td>{{ Helper::getDateHumanFr( $jeu->deleted_at )  }}</td>
                                    <td class="m--align-right">

                                                <div class="row">
                                                    <div class="col-md-2">
                                                        {!! Form::open(['method' => 'PUT', 'class' => 'inline', 'route' => ['jeux.restore', $jeu->id] ]) !!}
                                                        <button class="btn btn-danger btn-sm mt-1  button-restore " title="Restaurer">
                                                            <i class="fas fa-trash-restore" aria-hidden="true"></i>
                                                        </button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <div class="col-md-2">
                                                        {!! Form::open(['method' => 'delete', 'class' => 'inline', 'route' => ['jeux.harddestroy', $jeu->id] ]) !!}
                                                        <button class="btn btn-warning btn-sm mt-1  button-delete " title="Supprimer définitivement">
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

            <div class="card-body">
                <div class="row mt-4 ml-4">


                    <div class="col-md-12 pull-md-right">
                        {{ Form::open(['route' => ['jeux.vidercorbeille'], 'method' => 'delete', 'id' => 'formdeletejeu']) }}
                            @csrf
                            {{--<button class="btn btn-success  mt-1  button-delete-jeu btn-lg col-md-12" title="Supprimer">--}}
                            <button class="btn btn-success button-delete-jeu mt-1 btn-lg col-md-12 videcorbeille" title="Vider la corbeille" type="submit">
                                <i class="fas fa-trash" aria-hidden="true"></i> Vider la corbeille
                            </button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('body').on('click', '.videcorbeille', function (e) {
                e.preventDefault();

                var form = $(this).parents('form');
                swal({
                    title: "Etes-vous sûr?",
                    text: "Tous les jeux dans la corbeille seront définitivement supprimés",
                    icon: "warning",
                    buttons: [
                        'Annuler',
                        'Oui, vider'
                    ],
                    dangerMode: true,

                }).then( function(willDelete)  {
                    if (willDelete == true) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush