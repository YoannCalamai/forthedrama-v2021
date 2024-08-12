{{-- \resources\views\users\edit.blade.php --}}

@extends('backend.layout.app')

@section('title', '| Edit User')

@section('content')

    <div class='col-lg-10 col-lg-offset-4'>

        <h1> Modifier l'utilisateur {{$user->name}}</h1>
        <hr>
    </div>
    <div class='col-lg-4 col-lg-offset-4'>
        {{ Form::model($user, array('route' => array('users.updatepassword', $user->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with user data --}}


        <div class="form-group">
            {{ Form::label('password', 'Mot de passe') }}<br>
            {{ Form::password('password', array('class' => 'form-control')) }}

        </div>

        <div class="form-group">
            {{ Form::label('password', 'Confirmer le mot de passe') }}<br>
            {{ Form::password('password_confirmation', array('class' => 'form-control')) }}

        </div>

        {{ Form::submit('Modifier', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection
