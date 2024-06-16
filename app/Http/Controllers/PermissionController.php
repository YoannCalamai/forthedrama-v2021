<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Session;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('backend.admin.permissions.index')->with('permissions', $permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();//Get all permissions

        return view('backend.admin.permissions.create', ['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate name and permissions field
        $this->validate($request, [
                'name'=>'required|unique:roles|max:200',
            ]
        );

        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['permission'=> $request['name'] ])
            ->log("Admin : création d'un droit");

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;


        $permission->save();


        return redirect()->route('permissions.index')
            ->with('success',
                'Le Droit '. $permission->name.' a été créé.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.admin.permissions.edit', compact('permission' ));
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
        $permission = Permission::findOrFail($id);//Get role with the given id
        //Validate name and permission fields
        $this->validate($request, [
            'name'=>'required|max:20|unique:roles,name,'.$id,
        ]);

        $input = $request->except(['permissions']);
        $permission->fill($input)->save();




        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['permission'=> $permission->name ])
            ->log("Admin : mise à jour d'un Droit");


        return redirect()->route('permissions.index')
            ->with('success',  'Le Droit '. $permission->name.' a été mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $model_has_permissions = DB::table('model_has_permissions')->where('permission_id', '=', $id)->get();
        if( count( $model_has_permissions) > 0){
            return redirect()->route('permissions.index')
                ->with('error',
                    'Le Droit ne peut être supprimé car des utilisateurs lui sont affectés.');

        }else{
            $role_has_permissions = DB::table('role_has_permissions')->where('permission_id', '=', $id)->get();
            if( count( $role_has_permissions) > 0){
                return redirect()->route('permissions.index')
                    ->with('error',
                        'Le Droit ne peut être supprimé car des rôles lui sont affectés.');

            }else{
                activity()
                    ->causedBy(\Auth::user())
                    ->withProperties(['permission'=> $permission->name ])
                    ->log("Admin : suppression d'un Droit");
                $permission->delete();
                return redirect()->route('permissions.index')
                    ->with('success',
                        'Le Groupe a été supprimé.');
            }
        }
    }
}
