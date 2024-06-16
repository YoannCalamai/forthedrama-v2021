<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Hash;
use Excel;
use App\Exports\UsersExport;


class UserController extends Controller
{

    public function __construct() {
        $this->middleware(['auth', 'isAdmin'], ['except' => ['rollBackLogin', 'updateinfos']] ); //isAdmin middleware lets only users with a //specific permission permission to access these resources
//        $this->middleware(['permission:Accès Admin']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users_all = User::orderby('name', 'ASC')->get();


        return view('backend.admin.users.index')->with('users', $users_all);
    }

    public function indexOLS()
    {

        $users_all = User::with(['roles' => function($q){
            $q->where('name', 'OLS');
        }])->orderBy('id','desc')->get();


        return view('backend.admin.users.index')->with('users', $users_all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get all roles and pass it to the view
        $roles = Role::get();
        $jeux = \App\Jeu::orderby('jeu', 'asc')->get();

        $roles_to_array = [];
        foreach($roles as $r){ $roles_to_array[$r->id] = $r->name;}


        return view('backend.admin.users.create', compact('roles_to_array', 'jeux' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['nom'=> $request['name'] , 'email' => $request['email'] ])
            ->log("Admin : création d'un utilisateur");

//        $user = User::create($request->only('email', 'name')); //Retrieving only the email and password data
        $user = new User();
        $user->email = $request['email'];
        $user->name = $request['name'];
        $user->name = $request['name'];
        $user->password = Hash::make( $request['password'] );
        $user->auteur_nom = $request['auteur_nom'];
        $user->auteur_email = $request['auteur_email'];
        $user->auteur_url = $request['auteur_url'];
        $user->auteur_rs = $request['auteur_rs'];
        $user->save();


        $roles = $request['roles']; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }


        //Redirect to the users.index view and display message
        return redirect()->route('users.edit', $user->id)
            ->with('success',
                'Utilisateur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles
        $roles_to_array = [];

        $jeux = \App\Jeu::orderby('jeu', 'asc')->get();

        foreach($roles as $r){ $roles_to_array[$r->id] = $r->name;}
        if( isset( $user->roles[0]->id )) $user_role_id = $user->roles[0]->id;
        else $user_role_id = 0;

        return view('backend.admin.users.edit', compact('user', 'roles_to_array', 'user_role_id' , 'jeux')); //pass user and roles data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,

        ]);

        $roles = $request['roles']; //Retreive all roles
        $user->fill($request->except( ['password_confirmation', 'roles', 'password' ]))->save();

        if( $request['password'] != '' ){
            $user->password = Hash::make( $request['password'] );
            $user->save();

        }

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        if( $request['jeux'] != ''){
            $finds = \App\Jeu::get();
            foreach( $finds as $jeu ){
                if(in_array( $jeu->id, $request['jeux']  ) ){
                    $jeu->user_id = $user->id;
                }else{
                    $jeu->user_id = null;
                }
                $jeu->save();
            }

        }
        return redirect()->route('users.edit', $user->id)
            ->with('success','Utilisateur mis à jour avec succès');

    }

    public function updateinfos(Request $request, $id)
    {
        $user = User::findOrFail($id); //Get role specified by id

        if( ! \Auth::user()->hasRole('administrateur') && \Auth::user()->id != $user->id ) abort( '401' );

        $user->auteur_nom = $request['auteur_nom'];
        $user->auteur_email = $request['auteur_email'];
        $user->auteur_url = $request['auteur_url'];
        $user->auteur_rs = $request['auteur_rs'];
        $user->save();

        return redirect()->route('backend.home')
            ->with('success','Vos informations personnelles ont été mises à jour');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if( $id == \Auth::user()->id){
            return redirect()->route('users.index')
                ->with('flash_errors',
                    'Vous ne pouvez pas supprimer votre propre compte utilisateur.');
        }

        $user = User::findOrFail($id);


        //Find a user with a given id and delete
        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['nom'=> $user->name , 'email' => $user->email ])
            ->log("Admin : suppression de l' utilisateur ".$user->email);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success',
                'Uilisateur supprimé.');
    }


    public function password(  User $user){


        return view('users.password', compact('user') ); //pass user and roles data to view
    }
    public function updatepassword( Request $request, $id){
        $user = User::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $this->validate($request, [
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->only(['password']); //Retreive the name, email and password fields
        $user->fill($input)->save();


        return redirect()->route('users.index')
            ->with('success',
                'Mot de passe mis à jour avec succès.');
    }

    public function switch( Request $request, $id ){

        $_SESSION['user_original_id'] = \Auth::user()->id;
        Auth::logout( \Auth::user() );

        $user = User::find( $id );
        Auth::login($user);

        return redirect()->route('home');
    }


    public function connectas( $id ){
        Session::put('rollback', \Auth::user()->id );
        Auth::loginUsingId( $id );
        return Redirect()->route('home');
    }

    public function rollBackLogin( ){

        $id = Session::get('rollback');
        Session::forget('rollback');

        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['id_user'=>  $id ])
            ->log("RollBack Login");

        Auth::loginUsingId( $id );

        return Redirect()->route('users.index');
    }

    public function export(){

        return Excel::download(new UsersExport, date('Y-m-d H-i-s') . ' forthedrama.xlsx');
    }
}
