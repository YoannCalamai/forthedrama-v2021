@extends('backend.layout.app')

@section('title', '| Modifier le Profil {{$role->name}}')

@section('content')
    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">

                        <div class="d-flex justify-content-between bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <h2>   Modifier le Profil {{$role->name}} </h2>
                            </div>
                            <div class="p-2 bd-highlight"></div>
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10"><span><i class="fas fa-arrow-left mr-2" aria-hidden="true"></i><span>Retour</span></span> </a>
                                <button type="submit" class="btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md"  style="display:inline"><span><i class="fas fa-save mr-2" aria-hidden="true"></i><span>Enregistrer</span></span></button>
                            </div>
                        </div>
                    </div>



                    <div class="m-portlet__body">
                        <div class="form-group">
                            {{ Form::label('name', 'Role') }}
                            {{ Form::text('name', $role->name, array('class' => 'form-control')) }}
                        </div>
                        <h5>Assigner des Droits</h5>
                        @foreach ($permissions as $permission)
                            {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
                            {{Form::label($permission->name, ucfirst($permission->name)) }}<br>
                        @endforeach
                        <br>


                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
