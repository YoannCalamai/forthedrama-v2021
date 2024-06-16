@extends('backend.layout.app')

@section('title', '| Modifier le fichier {{$fichier->nom}}')

@section('content')
    {{ Form::model($fichier, array('route' => array('contenus.fichiers.update', $fichier) , 'method' => 'PUT', 'files' => true )) }}

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <h2>   Modifier le fichier {{$fichier->nom}} </h2>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('home') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left" aria-hidden="true"></i><span>Retour</span></span> </a>
                                <button type="submit" class="btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fas fa-save" aria-hidden="true"></i><span>Enregistrer</span></span></button>
                            </div>
                        </div>
                    </div>



                    <div class="m-portlet__body">
                        <div class="form-group">
                            {{ Form::label('nom', 'Nom') }}
                            {{ Form::text('nom', $fichier->nom, array('class' => 'form-control') ) }}
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="form-group">
                            {{ Form::label('categorie', 'Catégorie') }}
                            {{ Form::select('categorie', [ 'documentation' => 'Documentation Cadre', 'supportcommunication' => 'Support de communication' ],
                                $fichier->categorie , array('class' => 'form-control') ) }}

                        </div>
                    </div>

                    <div class="m-portlet__body">
                        <div class="form-group">
                            {{ Form::label('url', 'Remplacer le fichier') }}
                            <div class="p-2 bd-highlight">
                                <input type="file" class="<?= config('ui.add_class') ?> mt-3" id="url" name="url">
                                <p>Types acceptés : pdf,doc,docx,xls,xlsx,jpg,jpeg,gif,png</p>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
