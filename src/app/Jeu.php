<?php

namespace App;

use Storage;
use App\Carte;
use App\Illustration;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
class Jeu extends Model
{
    use HasTranslations;
    use SoftDeletes;


    protected $fillable = [ 'jeu', 'presentation', 'image'];
    public $translatable = ['jeu', 'presentation', 'intro','image'];


    /**
     * Génère un nom unique ou "slug" pour le jeu
     * @return void
     */
    public function genereSlug()
    {

            $this->slug = str_slug($this->jeu);

            $latestSlug =
                static::whereRaw("slug = '$this->slug' or slug LIKE '$this->slug-%'")
                    ->latest('id')
                    ->value('slug');
            if ($latestSlug) {
                $pieces = explode('-', $latestSlug);

                $number = intval(end($pieces));

                $this->slug .= '-' . ($number + 1);
            }
        $this->save();

    }


    public function cartes()
    {
        return $this->hasMany(Carte::class);
    }

    public function illustrations()
    {
        return $this->hasMany(Illustration::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function afficheNomUser(){

        $user = \App\User::find( $this->user_id);
        if( $user != null )return $user->name;
    }

    /**
     * Génère un code unique pour une nouvelle partie 
     * @return string
     */
    public function genereCodeRoom(){

        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);

    }

    /**
     * Génère les cartes pour une partie en fonction d'une durée
     * @param int $duree
     * @return array
     */
    public function genereCartes( $duree ){

        $nombre_cartes_total =  Carte::select('id')->where('jeu_id', '=', $this->id )->where('type', '=', 'question')->count();

        if(  $this->duree_rapide != null ) $duree_rapide = $this->duree_rapide;
        else $duree_rapide = 10;

        if(  $this->duree_moyenne != null ) $duree_moyenne= $this->duree_moyenne;
        else $duree_moyenne = 20;

        if(  $this->duree_longue != null ) $duree_longue= $this->duree_longue;
        else $duree_longue = 30;

        switch( $duree ){
            case 1: $max_cartes = $duree_rapide + rand(0,3); break;
            case 2: $max_cartes = $duree_moyenne + rand(0,3); break;
            case 3: $max_cartes = $duree_longue + rand(0,3); break;
            case 4: $max_cartes = $duree_rapide + rand(0,3); break;
        }
		
        $instructions = Carte::select('id')->where('jeu_id', '=', $this->id )->where('type', '=', 'instruction')->orderby('numero', 'asc')->get();
        $finale = Carte::select('id')->where('jeu_id', '=', $this->id )->where('type', '=', 'finale')->orderByRaw("RAND()")->first();

        // si il n'y a pas de groupe dans la définition du jeu
        $test_groupe = Carte::select('id')->where('jeu_id', '=', $this->id )->where('type', '=', 'question')->where('groupe', '!=', null) ->first();
        if( $test_groupe === null ){
            $questions = Carte::select('id')->where('jeu_id', '=', $this->id )->where('type', '=', 'question')->orderByRaw("RAND()")->get();
            $questions_melangees = array();
            if( $duree == 4){
                $questions_melangees = $questions->toArray();
                if( $finale != null ){
                    array_push( $questions_melangees, $finale[0] );
                }

            }else{
                if( count( $questions->toArray( )) > $max_cartes ){
                    list($questions_melangees, $array2) = array_chunk($questions->toArray( ), $max_cartes );
                }
                if( $finale != null ) {
                    array_push($questions_melangees, $finale);
                }
            }
            $questions_melangees = array_merge( $instructions->toArray( ) , $questions_melangees);

            return $questions_melangees;
        }else{
            // si on doit gérer des groupes de cartes
            $groupes_distinct = Carte::select('groupe')->distinct('groupe')->where('jeu_id', '=', $this->id )->where('type', '=', 'question')->get();
            $questions_groupees = [];
            $groupes = [];
            $ids_deja_selectionnes = [];
            foreach( $groupes_distinct as $groupe){
                $groupes[] = $groupe->groupe;
                $questions_groupees [ $groupe->groupe ] = [];
            }

            $i = 0 ;
            while(  $i <= $max_cartes ){

                foreach( $groupes as $id_groupe ){
                    if( $i <= $max_cartes ) {
                        $carte = Carte::select('id')->where('jeu_id', '=', $this->id )
                                        ->where('type', 'question')
                                        ->where('groupe', $id_groupe)
                                        ->whereNotIn('id', $ids_deja_selectionnes )
                                        ->orderByRaw("RAND()")->first();
                        if( $carte != null ){
                            $questions_groupees [ $id_groupe ] [] = $carte;
                            $ids_deja_selectionnes[] = $carte->id;
                        }
                        $i ++;
                    }

                }
            }
            $questions_non_melangees = [];
            foreach( $questions_groupees as $id => $cartes ){
                foreach( $cartes as $indice => $carte ){
                    $questions_non_melangees[] = $carte->toArray();
                }

            }

            array_push( $questions_non_melangees , $finale );
            $questions_non_melangees = array_merge( $instructions->toArray( ) , $questions_non_melangees);

            return $questions_non_melangees;

        }


    }
	
    /**
     * Est ce que le jeu existe pour une langue donnée
     * @param string $lang
     * @return array
     */
	public function hasLanguage( $lang ){
	
		if( $lang === null ) $lang = 'fr';
		
		if( $this->languages === null ){ return false; }
		$langs = unserialize( $this->languages );
		

		
		if( in_array( $lang, $langs)){
			return true;
		}
		return false;
	}
	
	
	public function addLanguage( $lang ){
		
		if( $this->languages === null ){
			$this->languages = serialize( [ $lang ] );
			$this->save();
		}else{
			$langs = unserialize( $this->languages );
			if( !in_array( $lang, $langs)){
				$langs[] = $lang;
				$this->languages = serialize($langs);
				$this->save();
			}
		}
		
	}

    /**
     * Associer un fichier joint (illustration) à un jeu
     * @param mixed $request
     * @param mixed $champ
     * @return void
     */
    public function setFichierJoint(  $request, $champ ){

        if( $request->file( 'illustration' ) != null ){
            $this->deleteFichierJoint( $champ );

            $uploadedFile = $request->file( 'illustration' );
            $filename = time().'-'.$uploadedFile->getClientOriginalName();

            Storage::disk('local')->putFileAs(
                'public/illustrations/'.$this->id,
                $uploadedFile,
                $filename
            );
            $this->{ $champ } = $filename;
            $this->save();
        }
    }

    /**
     * Supprimer un fichier joint (illustration) associé à un jeu
     * @param mixed $champ
     * @return void
     */
    public function deleteFichierJoint( $champ ){
        if( $this->{$champ} != ''){
            Storage::disk('public')->delete($this->{$champ} );
        }
    }

    /**
     * Supprimer toutes les cartes associées à un jeu
     * @param boolean $harddestroy
     * @return void
     */
    public function supprimeTout( $harddestroy = false ){
        foreach( $this->cartes as  $carte ){
            if( $harddestroy === true ){
                $carte->forceDelete();
            }else{
                $carte->delete();
            }
        }

        if( $harddestroy === true ){
            $this->forceDelete();
        }else{
            $this->delete();
        }
    }

    /**
     * Récupérer l'url de l'illustration associée à un jeu
     * @return string
     */
    public function urlIllustration(){

        $image = $this->getTranslations('image');

        if( isset( $image['fr'] ) ){

            return Storage::url('illustrations/'. $this->id .'/'. $image['fr'] );
        }

        return Storage::url('illustrations/'. $this->id .'/'. $this->image );
    }

    /**
     * Compte le nombre de demandes de publication pour l'ensemble des jeux
     * @return string
     */
    public static function countIsDemandePublie(){
        return Jeu::where('is_demande_publie', 1)->count();
    }

}
