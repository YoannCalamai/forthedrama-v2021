<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contenus;
use Illuminate\Support\Facades\Storage;
use Redirect;

class ContenusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }


    public function index(){
        $contenus = Contenus::orderBy('id', 'asc')->get();
        return view('backend.admin.contenus.index', compact('contenus'));
    }


    public function create(){

        return view('backend.admin.contenus.create');
    }

    public function edit(Request $request, int $id){

        $contenu = Contenus::findorfail( $id );
        return view('backend.admin.contenus.edit', compact('contenu'));
    }

    public function store (Request $request){

        $contenu = new Contenus();
        $contenu->name = $request['name'];
        $contenu->contenu = $request['contenu'];
        $contenu->save();

        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['contenu'=> $contenu->nom ])
            ->log("Contenu : création");

        return Redirect::route('contenus.index')->with('success', 'Contenu créé avec succès');
    }

    public function update (Request $request, int $id ){

        $contenu = Contenus::findorfail( $id );
        $contenu->name = $request['name'];
        $contenu->contenu = $request['contenu'];
        $contenu->save();

        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['contenu'=> $contenu->nom ])
            ->log("Contenu : mise à jour");

        return Redirect::route('contenus.index')->with('success', 'Contenu mis à jour avec succès');
    }



    public function destroy( $id ){
        $contenu = Contenus::findorfail( $id );

        activity()
            ->causedBy(\Auth::user())
            ->withProperties(['contenu'=> $contenu->nom ])
            ->log("Contenu : suppression");

        $contenu->delete();
        return Redirect::route('contenus.index')->with('success', 'Contenu supprimé avec succès');
    }
}
