<?php

namespace App\Http\Controllers;

use App\Carte;
use Illuminate\Http\Request;
use Excel;
use App\Imports\CartesImport;
use App\Exports\CartesExport;
use \App\Session;

class CarteController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth' );
    }
    public function changenumero( Request $request )
    {
//        dd( $request );
        $position = $_POST['position'];
        foreach($position as $k=>$v){
            $carte = \App\Carte::findorfail( $v);
            $carte->numero = $k;
            $carte->save();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request, int $id_game )
    {
        $lang = $request->session()->get('locale');
        $jeu = \App\Jeu::findorfail( $id_game );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        if( ! isset( $request['filtre_carte'] ) || $request['filtre_carte'] === null  ){
            $cartes = \App\Carte::where('jeu_id', $id_game )->orderBy('numero', 'asc')->get();
            $filtre_carte = null;
            return view('backend.cartes.index', compact('cartes', 'jeu', 'lang', 'filtre_carte' ) );
        }else{
            $cartes = \App\Carte::where('jeu_id', $id_game )->where('type', $request['filtre_carte'] )->orderBy('numero', 'asc')->get();
            $filtre_carte = $request['filtre_carte'];
            return view('backend.cartes.index', compact('cartes', 'jeu', 'lang', 'filtre_carte') );
        }

    }

    public function premierecarte( Request $request, int $id_game ){

        $lang = $request->session()->get('locale');
        $jeu = \App\Jeu::findorfail( $id_game );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        $carte = new \App\Carte();
        $carte->jeu_id = $id_game;
        $carte->numero = 0;
        $carte->save();

        return Redirect()->route('cartes.index', $id_game)->with('success', 'Félicitations ! Vous avez créé une première carte');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {

        $carte = new \App\Carte();
        $carte->jeu_id = $request['jeu_id'];
        $carte->numero = \App\Carte::where('jeu_id', $request['jeu_id'] )->max('numero') + 1;
        $carte->save();

        return $carte->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function show(Carte $carte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function edit(Carte $carte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lang = $request->session()->get('locale');
        $carte = \App\Carte::findorfail( $request['carte_id']);
        $jeu = \App\Jeu::findorfail( $carte->jeu_id );

        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        if( isset( $request['carte_texte'] )){
            $carte
                ->setTranslation('carte', $lang, $request['carte_texte'] )
                ->save();
        }
        if( isset( $request['carte_type'] )){
            $carte->type = $request['carte_type'];
            $carte->save();
        }
        if( isset( $request['groupe'] )){
            $carte->groupe = $request['groupe'];
            $carte->save();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $carte = \App\Carte::findorfail( $request['carte_id'] );
        $jeu = \App\Jeu::findorfail( $carte->jeu_id );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        $carte->forceDelete( );
    }

    public function export( int $game_id )
    {
        $jeu = \App\Jeu::findorfail( $game_id );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        return Excel::download(new CartesExport( $game_id ),  $jeu->jeu.'-'.date('Y-m-d H-i-s') .'.xlsx');
    }

    public function importfront( Request $request, int $game_id )
    {
        $lang = $request->session()->get('locale');
        $jeu = \App\Jeu::findorfail( $game_id );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        return view('backend.cartes.importfront', compact('jeu' , 'lang' ) );
    }

    public function import( Request $request )
    {
        $request->validate([
            'import_file' => 'required'
        ]);

        $lang = $request->session()->get('locale');
        $jeu = \App\Jeu::findorfail( $request['jeu_id'] );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        $data = Excel::toArray(new CartesImport(), request()->file('import_file'));

        $output = [];


        $erreur = false;

        if( count( $data ) > 0) {
            $i = 0;
            foreach ($data[0] as $d) {
                if ($i != 0) {
                    if ($d[0] != '') {

                        if( $d[0] != 'instruction' && $d[0] != 'question' && $d[0] != 'finale' ){
                            $erreur = true;

                        }
                        if( $d[1] == '' || $d[1] === null ){
                            $erreur = true;

                        }
                    }
                }
                $i++;
            }

        }
        if( $erreur === true ){
            return redirect()->route('cartes.importfront', $jeu->id )
                ->with('error','Erreur lors de l\'import : la structure du fichier est incorrect');
        }

        if( count( $data ) > 0){

            foreach( $jeu->cartes as $carte){
                $carte->forgetTranslation( 'carte', $lang );
                $carte->delete();
            }

            $i = 0;
            foreach ($data[0] as $d) {
                if( $i != 0){
                    if( $d[0] != ''){

//                        $carte = \App\Carte::where('jeu_id', $jeu->id)->where('numero', $i-1 )->first();
//                        if( $carte === null ){
                            $carte = new \App\Carte();
                            $carte->type = $d[ 0 ];
                            $carte->groupe = $d[ 2 ];
                            $carte->jeu_id = $jeu->id;
                            $carte->numero = $i - 1;
//                        }


                        $carte
                            ->setTranslation('carte', $lang, $d[ 1 ] )
                            ->save();

                        $carte->save();
                    }
                }
                $i++;
            }


        }

        $lang = $request->session()->get('locale');
        $jeu = \App\Jeu::findorfail( $request[ 'jeu_id' ] );
        if( ! \Auth::user()->hasRole('administrateur') && $jeu->user_id != \Auth::user()->id ){ abort('401'); }

        return redirect()->route('cartes.index', $jeu->id )
            ->with('success','Cartes importées avec succès');
    }

}
