<?php

namespace App\Http\Controllers;

use App\Jeu;
use App\Session;
use Illuminate\Http\Request;
use Pusher;
use Redirect;
use Mail;

class JeuController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['only' => ['journal']]);
        $this->middleware('auth', [ 'except' => ['distribue', 'retourCarte', 'distribueSansIncrement', 'xcard'] ]);
    }



    public function index( Request $request){

        $locale =  $request->session()->get('locale');
        if( \Auth::user()->hasRole('administrateur') ){
            $r_jeux = Jeu::where('jeu->'.$locale,'!=', '')->orderBy('id', 'desc');
        }
        else{
            $r_jeux = Jeu::where('user_id', \Auth::user()->id )->where('jeu->'.$locale,'!=', '')->orderBy('id', 'desc');
        }

        if( isset( $request['filtre_publie'] ) && $request['filtre_publie'] != '' ){
            $r_jeux->where('is_publie', $request['filtre_publie']);
        }

        $jeux = $r_jeux->get();

        return view('backend.jeux.index', compact('jeux'));

    }

    public function corbeille( Request $request){


        $jeux = Jeu::onlyTrashed()->orderBy('id', 'desc')->get();

        return view('backend.jeux.corbeille', compact('jeux' ));

    }

    public function create(){

        return view('backend.jeux.create');
    }

    public function store( Request $request){
        $jeu = new Jeu();
        $jeu->is_publie = 0;
        $jeu->user_id = \Auth::user()->id;
        $jeu->addLanguage( $request['lang'] );
        $jeu
            ->setTranslation('jeu', $request['lang'] , $request['jeu'] )
            ->save();
        $jeu->duree_rapide = 10;
        $jeu->duree_moyenne = 20;
        $jeu->duree_longue = 30;

        $jeu->save();
        $jeu->genereSlug();

        return redirect()->route('jeux.edit', $jeu->id )
            ->with('success','Jeu créé avec succès');
    }

    public function edit( int $id){
        $jeu = Jeu::findorfail( $id );
        $users = \App\User::orderby('name')->pluck('name', 'id');
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }
        return view('backend.jeux.edit', compact('jeu', 'users'));
    }

    public function predestroy(int $id){
        $jeu = Jeu::findorfail( $id );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }
        return view('backend.jeux.predestroy', compact('jeu'));
    }

    public function updateAjax( Request $request, $id ){
        $jeu = Jeu::findorfail( $id );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        if( isset( $request['user_id'] ) ) $jeu->user_id = $request['user_id'];
        if( isset( $request['categorie_id'] ) ) $jeu->categorie_id = $request['categorie_id'];

        if( isset( $request['is_demande_publie'] ) && $request['is_demande_publie'] == 1){
            $jeu->is_demande_publie = 1;

            Mail::raw("Demande pour : ". $jeu->jeu , function ($message) {
                $message->from('no-reply@forthedrama.com', 'For the Drama');
                $message->to( 'shmurtzy@gmail.com', 'Matthieu' )->subject('Nouvelle demande de publication d\'un jeu');
            });

        }else{
            $jeu->is_demande_publie = 0;
            $jeu->is_publie = 0;
        }

/*        if( !\Auth::user()->hasRole('administrateur')  ){
            if( isset( $request['is_publie'] ) && $request['is_publie'] == 1){
                $jeu->is_publie = 1;
                $jeu->is_demande_publie = 0;
            }else{
                $jeu->is_publie = 0;
                $jeu->is_demande_publie = 0;
            }
        }*/


        if( isset( $request['is_publie_admin'] )  && $request['is_publie_admin'] == 'Non Publié'){
            $jeu->is_publie = 0;
            $jeu->is_demande_publie = 0;
        }
        if( isset( $request['is_publie_admin'] )  && $request['is_publie_admin'] == 'Publié'){
            $jeu->is_publie = 1;
            $jeu->is_demande_publie = 0;
        }

        $jeu->jeu = $request['jeu'];
        $jeu->intro = $request['intro'];
        $jeu->presentation = $request['presentation'];
        $jeu->jeu = $request['jeu'];
        $jeu->licence = $request['licence'];
        $jeu->image_licence = $request['image_licence'];
        $jeu->image_auteur = $request['image_auteur'];
        $jeu->duree_rapide = $request['duree_rapide'];
        $jeu->duree_moyenne = $request['duree_moyenne'];
        $jeu->duree_longue = $request['duree_longue'];

        if( $jeu->user_id != '' && $request['auteur_nom'] == null ){
            $user = \App\user::findorfail( $jeu->user_id );
            $jeu->auteur_nom = $user->auteur_nom;
            $jeu->auteur_email = $user->auteur_email;
            $jeu->auteur_url = $user->auteur_url;
            $jeu->auteur_rs = $user->auteur_rs;
        }else{
            $jeu->auteur_nom = $request['auteur_nom'];
            $jeu->auteur_email = $request['auteur_email'];
            $jeu->auteur_url = $request['auteur_url'];
            $jeu->auteur_rs = $request['auteur_rs'];
        }

        $jeu->save();
    }


    public function update( Request $request, int $id ){

        $jeu = Jeu::findorfail( $id );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        if( isset( $request['user_id'] ) ) $jeu->user_id = $request['user_id'];
        $jeu->jeu = $request['jeu'];
        $jeu->intro = $request['intro'];
        $jeu->presentation = $request['presentation'];
        $jeu->jeu = $request['jeu'];
        $jeu->licence = $request['licence'];
        $jeu->image_licence = $request['image_licence'];
        $jeu->image_auteur = $request['image_auteur'];
        $jeu->duree_rapide = $request['duree_rapide'];
        $jeu->duree_moyenne = $request['duree_moyenne'];
        $jeu->duree_longue = $request['duree_longue'];

        if( $jeu->user_id != '' && $request['auteur_nom'] == null ){
            $user = \App\user::findorfail( $jeu->user_id );
            $jeu->auteur_nom = $user->auteur_nom;
            $jeu->auteur_email = $user->auteur_email;
            $jeu->auteur_url = $user->auteur_url;
            $jeu->auteur_rs = $user->auteur_rs;
        }else{
            $jeu->auteur_nom = $request['auteur_nom'];
            $jeu->auteur_email = $request['auteur_email'];
            $jeu->auteur_url = $request['auteur_url'];
            $jeu->auteur_rs = $request['auteur_rs'];
        }

        $jeu->setFichierJoint( $request, 'image' );
        if( isset( $request['user_id'] ) ) $jeu->user_id = $request['user_id'];

        if( !\Auth::user()->hasRole('administrateur')  ) {
            if (isset($request['is_demande_publie']) && $request['is_demande_publie'] == 1) {
                $jeu->is_demande_publie = 1;
            } else {
                $jeu->is_demande_publie = 0;
                $jeu->is_publie = 0;
            }
        }
        $jeu->save();





        return Redirect::route('jeux.edit', $jeu->id)->with('success','Jeu mis à jour avec succès');
    }



    public function destroy( $id ){
        $jeu = \App\Jeu::findorfail( $id );
        if( ! \Auth::user()->hasRole('administrateur') ){
            if( ! \Auth::user()->hasJeu( $jeu) ) abort('401');
        }

        $jeu->supprimeTout();

        return redirect()->route('jeux.index' )
            ->with('success','Le jeu a été supprimé avec succès');

    }

    public function harddestroy( $id ){


        $jeu = \App\Jeu::withTrashed()->findorfail( $id );
        if( ! \Auth::user()->hasRole('administrateur') ){
            if( ! \Auth::user()->hasJeu( $jeu) ) abort('401');
        }

        $jeu->supprimeTout( $harddestroy = true );

        return redirect()->route('jeux.corbeille' )
            ->with('success','Le jeu a été supprimé avec succès');

    }

    public function vidercorbeille(){
        $jeux = \App\Jeu::onlyTrashed()->get();
        foreach( $jeux as $jeu ){
            $jeu->supprimeTout( $harddestroy = true );
        }
        return redirect()->route('jeux.corbeille' )
            ->with('success','La corbeille a été vidée');
    }


    public function restore( $id ){
        $jeu = \App\Jeu::withTrashed()->findorfail( $id );

        $jeu->restore();

        foreach( $jeu->cartes as $carte ){
            $carte->restore();
        }

/*        foreach( $jeu->illustrations as $illustration ){
            $illustration->restore();
        }*/

        return redirect()->route('jeux.corbeille' )
            ->with('success','Le jeu restoré avec succès');

    }
}
