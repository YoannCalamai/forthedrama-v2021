@extends('backend.layout.app')

@section('content')
    <form action="{{ route('jeux.store') }}" method="POST">
        @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <h2>Création d'un nouveau jeu</h2>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight">

                                <button type="submit" class="btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fas fa-save mr-1"></i><span>Créer</span></span></button>
                            </div>
                        </div>
                    </div>


                    @csrf
                    <div class="row">
                        <div class="col-md-4  bk-white txt-black p-4">
                        <label  for="jeu">Comment s'appelle votre jeu ?</label>

                        </div>
                        <div class="col-md-4  bk-white txt-black p-4">
                            <input type="text"  class="form-control" name="jeu" required >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4  bk-white txt-black p-4">
                        <label  for="jeu">En quelle langue est votre jeu ?</label>

                        </div>
                        <div class="col-md-4  bk-white txt-black p-4">

                            <select class="selectpicker form-control" name="lang" required data-width="fit">
                                <option value=""> Choix de la langue</option>
                                <option value="de" data-content='Deutsch'>Deutsch</option>
                                <option value="en" data-content='English'>English</option>
                                <option value="es" data-content='Español'>Español</option>
                                <option value="fr" data-content='Français'>Français</option>
                                <option value="jp" data-content='日本語'>日本語</option>


                            </select>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    </form>

@endsection

@push('scripts')
    <script>
        $(document).ready(function(){

        });
    </script>
@endpush