<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
//Importing laravel-permission models
use function MongoDB\BSON\toJSON;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Session;

class RoleController extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roles = Role::all();//Get all roles

        return view('backend.admin.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::all();//Get all permissions

        return view('backend.admin.roles.create', ['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //Validate name and permissions field
        $this->validate($request, [
                'name'=>'required|unique:roles|max:20',
                'permissions' =>'required',
            ]
        );

        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['role'=> $request['name'] ])
            ->log("Admin : création d'un Profil");

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();

        //Looping thru selected permissions
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }


        return redirect()->route('roles.index')
            ->with('success',
                'Le Profil '. $role->name.' a été créé.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('backend.admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $role = Role::findOrFail($id);//Get role with the given id
        //Validate name and permission fields
        $this->validate($request, [
            'name'=>'required|max:20|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();




        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['role'=> $role->name ])
            ->log("Admin : mise à jour d'un Profil");


        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }

        $permissions = Permission::all();
        return view('backend.admin.roles.edit', compact('role', 'permissions'))
            ->with('success',  'Le Profil '. $role->name.' a été mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $role = Role::findOrFail($id);
        $model_has_roles = DB::table('model_has_roles')->where('role_id', '=', $id)->get();
        if( count( $model_has_roles) > 0){
            return redirect()->route('roles.index')
                ->with('error',
                    'Le Groupe ne peut être supprimé car des utilisateurs lui sont affectés.');

        }else{
            activity()
                ->causedBy(\Auth::user())
                ->withProperties(['role'=> $role->name ])
                ->log("Admin : suppression d'un rôle");


            $role->delete();

            return redirect()->route('roles.index')
                ->with('success',
                    'Le Groupe a été supprimé.');
        }

      

    }
}
