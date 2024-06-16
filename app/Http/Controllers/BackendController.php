<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jeu;
use App\Carte;
use Auth;
use Redirect;
use Spatie\Activitylog\Models\Activity;

class BackendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jeus = Jeu::where('user_id', '=', \Auth::user()->id )->get();
        return view('backend.welcome', compact('jeus'));
    }



    public function creercarte(){
        return view('backend.cartes.create');
    }

    public function storecarte( Request $request){
        $jeu = Jeu::findorfail( $request['jeu_id']);
        if( $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        $carte = new Jeu();
        $carte->jeu_id = $jeu->id;
        $carte->type = $request['type'];
        $carte->carte = $request['carte'];
        $carte->save();
        return redirect()->route('backend.cartes.edit', $carte->id)
            ->with('success','Jeu créé avec succès');
    }

    public function editcarte( int $id){
        $carte = Carte::findorFail($id);
        $jeu = Jeu::findorfail( $carte->jeu_id );
        if( $jeu->user_id != \Auth::user()->id ){ abort('401'); }
        return view('backend.cartes.edit', compact('carte'));
    }

}
