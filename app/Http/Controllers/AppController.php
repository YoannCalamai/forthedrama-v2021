<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Session;
use App\Jeu;
use VerumConsilium\Browsershot\Facades\PDF;
use App\Contenus;
use App;
use Spatie\Browsershot\Browsershot;

class AppController extends Controller
{ 
    public function home(){
		
		$jeux_dispo = \App\Jeu::where('is_publie',1)->inRandomOrder()->get();
        return view('home', compact('jeux_dispo' ));
    }

    public function telecharger( Request $request, $jeu_id ){

        $jeu  = \App\Jeu::findorfail( $jeu_id );

    
        // en cas de bug : la solution est d'installer : npm install puppeteer@^10.4.0
         return PDF::loadView('contenu.imprimer', compact('jeu')) 
            //->margins(5, 5, 5, 5)->storeAs('pdfs/', 'google.pdf');
            ->download( $jeu->jeu.'-'.now().'.pdf');  
    }


    public function creerjeu(){
        $contenu = Contenus::where('name','=', 'creerjeu')->first();
        return view('contenu.creerjeu', compact('contenu') );
    }
    public function mentionslegales(){
        $contenu = Contenus::where('name','=', 'mentionslegales')->first();
        return view('contenu.mentionslegales', compact('contenu') );
    }
    public function aide(){
        $contenu = Contenus::where('name','=', 'aide')->first();
        return view('contenu.aide', compact('contenu') );
    }
    public function listejeux(){
//        $jeux_dispo = \App\Jeu::where('is_publie',1)->inRandomOrder()->get();
        $jeux_dispo = \App\Jeu::where('is_publie',1)->orderby('jeu','asc')->get();
        return view('contenu.listejeux', compact('jeux_dispo' ));
    }

    public function session( Request $request ){
        if( $request['code_room'] != ''){
            $session = Session::where('code_room','=', $request['code_room'] )->first();
            if( $session == null ){
                return Redirect::back()->with('flash_errors', 'Aucun jeu sélectionné');
            }else{
                $code_room =  $session->code_room;
                $id_session = $session->id_session;
                return redirect()->route('session.play', array( $session->code_room, $session->carte_active)  );
            }
        }else{
            if( $request['jeu_choisi'] != 0){

                $jeu = Jeu::findorfail( $request['jeu_choisi'] );

                $session = new Session();
                $session->date = date('Y-m-d h:i:s');
                $session->jeu_id = $request['jeu_choisi'];
                $session->carte_active = -1;
                $session->code_room = $jeu->genereCodeRoom();
                $session->save();
                return redirect()->route('session.duree', $session->code_room);

            }else{
                return Redirect::back()->with('flash_errors', 'Aucune partie en cours n\'a été trouvée avec le code saisi :'.$request['code_room']);
            }
        }

    }

    public function sessionGetDuree( $code_room ){
        $session = Session::where( 'code_room', '=', $code_room )->first();
        $id_session = $session->id_session;
        return view('session.duree', compact('id_session', 'code_room'));

    }
    public function sessionSetDuree( Request $request, $code_room ){
				
        $session = Session::where( 'code_room', '=', $code_room )->first();
        $id_session = $session->id_session;
        $session->cartes = serialize( $session->jeu->genereCartes( $request['duree'] ) );
        $session->save();
        return redirect()->route('session.play', $session->code_room);
    }

    public function play( $code_room , $carte_active = ''){
        $session = Session::where( 'code_room', '=', $code_room )->first();
        $code_room = $session->code_room;
        $id_session = $session->id_session;
        if( $carte_active =='') $carte_active = $session->carte_active;
        return view('session.play', compact( 'code_room', 'id_session', 'carte_active' ) );
    }


    public function pageJeu( $slug){
        $jeu = Jeu::where('slug', '=', $slug)->first();
        if( $jeu === null ) abort('404');

        return view('contenu.jeu', compact( 'jeu'));
    }

}
