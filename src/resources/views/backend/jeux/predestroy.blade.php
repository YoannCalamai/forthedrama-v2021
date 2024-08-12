@extends('backend.layout.app')

@section('content')

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">

                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                    <h2>Suppression de votre jeu {{ $jeu->jeu }}</h2>
                                </div>
                                <div class="p-2 bd-highlight"></div>
                                <div class="p-2 bd-highlight">


                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12  bk-white txt-black p-4">
                                <p>
                                <h2>Attention ! </h2> Vous êtes sur le point de supprimer votre jeu ainsi que l'ensemble de ses cartes.

                                </p>
                                <p>
                                    Etes-vous certain(e) de bien vouloir le supprimer ?
                                </p>
                            </div>
                            <div class="col-md-12  bk-white txt-black p-4">
                                    {{ Form::open(['route' => ['jeux.destroy', $jeu->id], 'method' => 'delete', 'id' => 'formdeletejeu']) }}
                                        @csrf
                                        {{--<button class="btn btn-success  mt-1  button-delete-jeu btn-lg col-md-12" title="Supprimer">--}}
                                        <button class="btn btn-success button-delete-jeu mt-1 btn-lg col-md-12" title="Supprimer" type="submit">
                                            <i class="fas fa-trash" aria-hidden="true"></i> Oui je veux supprimer {{ $jeu->jeu }}
                                        </button>
                                    {{ Form::close() }}

                            </div>

                        </div>




                    </div>
                </div>
            </div>
        </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('body').on('click', '.button-delete-jeu', function (e) {
                e.preventDefault();

                var form = $(this).parents('form');
                swal({
                    title: "Etes-vous sûr?",
                    text: "Ce jeu sera supprimé si vous confirmez",
                    icon: "warning",
                    buttons: [
                        'Annuler',
                        'Oui, supprimer'
                    ],
                    dangerMode: true,

                }).then( function(willDelete)  {
                    if (willDelete == true) {
                        console.log('ok');
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush