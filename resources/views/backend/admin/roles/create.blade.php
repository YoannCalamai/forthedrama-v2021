@extends('backend.layout.app')

@section('title', '| Créer un Profil')

@section('content')
    {{ Form::open(array('route' => 'roles.store')) }}
    <div class='col-lg-12 col-lg-offset-4'>
        <div class="row">
            <div class="col-md-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Ajouter un profil
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left mr-2" aria-hidden="true"></i><span>Retour</span></span> </a>
                            <button type="submit" class="btn btn-primary m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fas fa-save mr-2" aria-hidden="true"></i><span>Enregistrer</span></span> </button>
                        </div>


                    </div>

                    <div class="m-portlet__body">


                        <div class="form-group">
                            {{ Form::label('name', 'Nom') }}
                            {{ Form::text('name', null, array('class' => 'form-control')) }}
                        </div>

                        <h5><b>Attribuer des Droits</b></h5>

                        <div class='form-group'>
                            @foreach ($permissions as $permission)
                                {{ Form::checkbox('permissions[]',  $permission->id ) }}
                                {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>

                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}



@endsection
