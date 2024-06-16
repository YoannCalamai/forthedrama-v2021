<?php
namespace App\Helpers;

use \App\Projet;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\UrlGenerator;
use Form;

class Helper {

    public static function cleanStr( $str ){
        return str_replace('', '', $str );
    }

    public static function getFicheFromChamp( $champs){
        $atomes = explode('_', $champs);
        $fiche_tmp = explode('fiche', $atomes[0]);
        if(isset( $fiche_tmp[1] ) ) return 'fiche '.$fiche_tmp[1];

        return '';
    }

    public static function getTypeFromChamp( $champs){
        $atomes = explode('_', $champs);
        if( isset( $atomes[2] ) ) return $atomes[2];

        return '';
    }

    public function isFicheValidee( $nom_fiche ){

        if( $this->{ $nom_fiche } === 1 ) return true;
        else return false;

    }

    public static function getDroitFromString( $string, $projet ){
        $droits = 'lecture';

        if( $string == 'fiche 3bis'){
            if( $projet->{ 'fiche3bis_validee' } == 1 ) {
                $droits = 'lecture';
            }else{
                if(  \Auth::user()->can('Lecture fiche 3')){
                    $droits = 'lecture';
                }
                if(  \Auth::user()->can('Ecriture fiche 3')){
                    $droits = 'écriture';
                }
            }
            return $droits;
        }
        if( $string == 'fiche 4bis'){
            if( $projet->{ 'fiche4bis_validee' } == 1 ) {
                $droits = 'lecture';
            }else{
                if(  \Auth::user()->can('Lecture fiche 4')){
                    $droits = 'lecture';
                }
                if(  \Auth::user()->can('Ecriture fiche 4')){
                    $droits = 'écriture';
                }
            }
            return $droits;
        }

        if( $projet->{ str_replace(' ', '', $string).'_validee' } == 1 ){
            $droits = 'lecture';
        }else{
            $droits = '';

            if(  \Auth::user()->can('Lecture '.$string) ){
                $droits = 'lecture';
            }
            if(  \Auth::user()->can('Ecriture '.$string) ){
                $droits = 'écriture';
            }
        }


        return $droits;
    }

    public static function getDateHumanFr( $date ){

        \Carbon\Carbon::setLocale('fr');
        if( $date == '' || $date == null ) return;
        else return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }

    public static function getDateTimeHumanFr( $date ){

        \Carbon\Carbon::setLocale('fr');
        if( $date == '' || $date == null ) return;
        else return \Carbon\Carbon::parse($date)->format('d/m/Y à H:i:s');
    }

    public static function getDateHumanUs( $date ){
        if( $date == '' || $date == null ) return;
        else return \Carbon\Carbon::parse($date)->format('Y-m-d at H:i:s');
    }

    public static function getDateTimeFr( $date ){
        if( $date == '' || $date == null ) return;
        else return  \Carbon\Carbon::createFromFormat( 'Y-m-d H:i:s', $date )->format( 'd/m/Y H:i:s');
    }

    public static function getDateFr( $date ){
        if( $date == '' || $date == null ) return;
        else return  \Carbon\Carbon::createFromFormat( 'Y-m-d', $date )->format('d/m/Y');
    }

    public static function getDateTimeUs( $date ){
        if( $date == '' || $date == null ) return;
        else return  \Carbon\Carbon::createFromFormat( 'd/m/Y H:i:s', $date )->format('Y-m-d H:i:s');
    }

    public static function getDateUs( $date ){
        if( $date == '' || $date == null ) return;
        else return  \Carbon\Carbon::createFromFormat( 'd/m/Y', $date )->format('Y-m-d');
    }

    public static function getUserNom( $user_id ){
        if( $user_id == '' || $user_id == null ) return;
        $user = \App\User::find( $user_id );
        if( $user === null ) return;
        else return $user->name;
    }


    public static function  champsContactsToHtml( $champs ){
        return '<tr> <th>Site</th> <th>Champ</th> <th>Nom Prénom</th> <th>Fonction</th> <th>Email</th> <th>Tél</th> <th>Adresse</th> </tr>';
    }

    public static function champFamille( $valeur ){
        return Form::select('famille',  array( ''=>'', 'COOP' => 'COOP',  'ESH'=>'ESH', 'OPH' => 'OPH', 'SEM' => 'SEM', 'Autre' => 'Autre' ), $valeur , [  'class' => 'form-control col-md-6 ', 'required'  ]);

    }

    public static function champDepartementRegion( $valeur_departement, $valeur_region, $nom_champ_departement = 'adresse_departement', $nom_champ_region = 'adresse_region' ){


        if( $valeur_departement == null && $valeur_region == null ) // pages publiques
        {
            if( date('Y-m-d') <= config('app.date_limite_depot_metropole')){
                ?>
                <div class="col-md-3 form-group">
                    <select name="<?= $nom_champ_departement ?>" id="<?= $nom_champ_departement ?>" class="form-control" required>
                        <option value="">-- département --</option><option value="01 Ain" data-region="Auvergne-Rhône-Alpes">01 Ain</option><option value="02 Aisne" data-region="Hauts-de-France">02 Aisne</option><option value="03 Allier" data-region="Auvergne-Rhône-Alpes">03 Allier</option><option value="04 Alpes-de-Haute-Provence" data-region="Provence-Alpes-Côte d'Azur">04 Alpes-de-Haute-Provence</option><option value="05 Hautes-Alpes" data-region="Provence-Alpes-Côte d'Azur">05 Hautes-Alpes</option><option value="06 Alpes-Maritimes" data-region="Provence-Alpes-Côte d'Azur">06 Alpes-Maritimes</option><option value="07 Ardèche" data-region="Auvergne-Rhône-Alpes">07 Ardèche</option><option value="08 Ardennes" data-region="Grand-Est">08 Ardennes</option><option value="09 Ariège" data-region="Occitanie">09 Ariège</option><option value="10 Aube" data-region="Grand-Est">10 Aube</option><option value="11 Aude" data-region="Occitanie">11 Aude</option><option value="12 Aveyron" data-region="Occitanie">12 Aveyron</option><option value="13 Bouches-du-Rhône" data-region="Provence-Alpes-Côte d'Azur">13 Bouches-du-Rhône</option><option value="14 Calvados" data-region="Normandie">14 Calvados</option><option value="15 Cantal" data-region="Auvergne-Rhône-Alpes">15 Cantal</option><option value="16 Charente" data-region="Nouvelle-Aquitaine">16 Charente</option><option value="17 Charente-Maritime" data-region="Nouvelle-Aquitaine">17 Charente-Maritime</option><option value="18 Cher" data-region="Centre-Val de Loire">18 Cher</option><option value="19 Corrèze" data-region="Nouvelle-Aquitaine">19 Corrèze</option><option value="21 Côte-d'Or" data-region="Bourgogne-Franche-Comté">21 Côte-d'Or</option><option value="22 Côtes-d'Armor" data-region="Bretagne">22 Côtes-d'Armor</option><option value="23 Creuse" data-region="Nouvelle-Aquitaine">23 Creuse</option><option value="24 Dordogne" data-region="Nouvelle-Aquitaine">24 Dordogne</option><option value="25 Doubs" data-region="Bourgogne-Franche-Comté">25 Doubs</option><option value="26 Drôme" data-region="Auvergne-Rhône-Alpes">26 Drôme</option><option value="27 Eure" data-region="Normandie">27 Eure</option><option value="28 Eure-et-Loir" data-region="Centre-Val de Loire">28 Eure-et-Loir</option><option value="29 Finistère" data-region="Bretagne">29 Finistère</option><option value="30 Gard" data-region="Occitanie">30 Gard</option><option value="31 Haute-Garonne" data-region="Occitanie">31 Haute-Garonne</option><option value="32 Gers" data-region="Occitanie">32 Gers</option><option value="33 Gironde" data-region="Nouvelle-Aquitaine">33 Gironde</option><option value="34 Hérault" data-region="Occitanie">34 Hérault</option><option value="35 Ile-et-Vilaine" data-region="Bretagne">35 Ile-et-Vilaine</option><option value="36 Indre" data-region="Centre-Val de Loire">36 Indre</option><option value="37 Indre-et-Loire" data-region="Centre-Val de Loire">37 Indre-et-Loire</option><option value="38 Isère" data-region="Auvergne-Rhône-Alpes">38 Isère</option><option value="39 Jura" data-region="Bourgogne-Franche-Comté">39 Jura</option><option value="40 Landes" data-region="Nouvelle-Aquitaine">40 Landes</option><option value="41 Loir-et-Cher" data-region="Centre-Val de Loire">41 Loir-et-Cher</option><option value="42 Loire" data-region="Auvergne-Rhône-Alpes">42 Loire</option><option value="43 Haute-Loire" data-region="Auvergne-Rhône-Alpes">43 Haute-Loire</option><option value="44 Loire-Atlantique" data-region="Pays-de-la-Loire">44 Loire-Atlantique</option><option value="45 Loiret" data-region="Centre-Val de Loire">45 Loiret</option><option value="46 Lot" data-region="Occitanie">46 Lot</option><option value="47 Lot-et-Garonne" data-region="Nouvelle-Aquitaine">47 Lot-et-Garonne</option><option value="48 Lozère" data-region="Occitanie">48 Lozère</option><option value="49 Maine-et-Loire" data-region="Pays-de-la-Loire">49 Maine-et-Loire</option><option value="50 Manche" data-region="Normandie">50 Manche</option><option value="51 Marne" data-region="Grand-Est">51 Marne</option><option value="52 Haute-Marne" data-region="Grand-Est">52 Haute-Marne</option><option value="53 Mayenne" data-region="Pays-de-la-Loire">53 Mayenne</option><option value="54 Meurthe-et-Moselle" data-region="Grand-Est">54 Meurthe-et-Moselle</option><option value="55 Meuse" data-region="Grand-Est">55 Meuse</option><option value="56 Morbihan" data-region="Bretagne">56 Morbihan</option><option value="57 Moselle" data-region="Grand-Est">57 Moselle</option><option value="58 Nièvre" data-region="Bourgogne-Franche-Comté">58 Nièvre</option><option value="59 Nord" data-region="Hauts-de-France">59 Nord</option><option value="60 Oise" data-region="Hauts-de-France">60 Oise</option><option value="61 Orne" data-region="Normandie">61 Orne</option><option value="62 Pas-de-Calais" data-region="Hauts-de-France">62 Pas-de-Calais</option><option value="63 Puy-de-Dôme" data-region="Auvergne-Rhône-Alpes">63 Puy-de-Dôme</option><option value="64 Pyrénées-Atlantiques" data-region="Nouvelle-Aquitaine">64 Pyrénées-Atlantiques</option><option value="65 Hautes-Pyrénées" data-region="Occitanie">65 Hautes-Pyrénées</option><option value="66 Pyrénées-Orientales" data-region="Occitanie">66 Pyrénées-Orientales</option><option value="67 Bas-Rhin" data-region="Grand-Est">67 Bas-Rhin</option><option value="68 Haut-Rhin" data-region="Grand-Est">68 Haut-Rhin</option><option value="69 Rhône" data-region="Auvergne-Rhône-Alpes">69 Rhône</option><option value="70 Haute-Saône" data-region="Bourgogne-Franche-Comté">70 Haute-Saône</option><option value="71 Saône-et-Loire" data-region="Bourgogne-Franche-Comté">71 Saône-et-Loire</option><option value="72 Sarthe" data-region="Pays-de-la-Loire">72 Sarthe</option><option value="73 Savoie" data-region="Auvergne-Rhône-Alpes">73 Savoie</option><option value="74 Haute-Savoie" data-region="Auvergne-Rhône-Alpes">74 Haute-Savoie</option><option value="75 Paris" data-region="Ile-de-France">75 Paris</option><option value="76 Seine-Maritime" data-region="Normandie">76 Seine-Maritime</option><option value="77 Seine-et-Marne" data-region="Ile-de-France">77 Seine-et-Marne</option><option value="78 Yvelines" data-region="Ile-de-France">78 Yvelines</option><option value="79 Deux-Sèvres" data-region="Nouvelle-Aquitaine">79 Deux-Sèvres</option><option value="80 Somme" data-region="Hauts-de-France">80 Somme</option><option value="81 Tarn" data-region="Occitanie">81 Tarn</option><option value="82 Tarn-et-Garonne" data-region="Occitanie">82 Tarn-et-Garonne</option><option value="83 Var" data-region="Provence-Alpes-Côte d'Azur">83 Var</option><option value="84 Vaucluse" data-region="Provence-Alpes-Côte d'Azur">84 Vaucluse</option><option value="85 Vendée" data-region="Pays-de-la-Loire">85 Vendée</option><option value="86 Vienne" data-region="Nouvelle-Aquitaine">86 Vienne</option><option value="87 Haute-Vienne" data-region="Nouvelle-Aquitaine">87 Haute-Vienne</option><option value="88 Vosges" data-region="Grand-Est">88 Vosges</option><option value="89 Yonne" data-region="Bourgogne-Franche-Comté">89 Yonne</option><option value="90 Territoire de Belfort" data-region="Bourgogne-Franche-Comté">90 Territoire de Belfort</option><option value="91 Essonne" data-region="Ile-de-France">91 Essonne</option><option value="92 Hauts-de-Seine" data-region="Ile-de-France">92 Hauts-de-Seine</option><option value="93 Seine-Saint-Denis" data-region="Ile-de-France">93 Seine-Saint-Denis</option><option value="94 Val-de-Marne" data-region="Ile-de-France">94 Val-de-Marne</option><option value="95 Val-d'Oise" data-region="Ile-de-France">95 Val-d'Oise</option><option value="2A Corse-du-Sud" data-region="Corse">2A Corse-du-Sud</option><option value="2B Haute-Corse" data-region="Corse">2B Haute-Corse</option><option value="97.1 Guadeloupe" data-region="Guadeloupe">97.1 Guadeloupe</option><option value="97.2 Martinique" data-region="Martinique">97.2 Martinique</option><option value="97.3 Guyane" data-region="Guyane">97.3 Guyane</option><option value="97.4 La Réunion" data-region="La Réunion">97.4 La Réunion</option><option value="97.6 Mayotte" data-region="Mayotte">97.6 Mayotte</option><option value="97.7 Saint-Barthélemy" data-region="Guadeloupe">97.7 Saint-Barthélemy</option><option value="97.8 Saint-Martin" data-region="Guadeloupe">97.8 Saint-Martin</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">

                    <select name="<?= $nom_champ_region ?>" id="<?= $nom_champ_region ?>" class="form-control" required>
                        <option value="">-- région --</option><option value="Auvergne-Rhône-Alpes">Auvergne-Rhône-Alpes</option><option value="Bourgogne-Franche-Comté">Bourgogne-Franche-Comté</option><option value="Bretagne">Bretagne</option><option value="Centre-Val de Loire">Centre-Val de Loire</option><option value="Corse">Corse</option><option value="Grand-Est">Grand-Est</option><option value="Guadeloupe">Guadeloupe</option><option value="Guyane">Guyane</option><option value="Hauts-de-France">Hauts-de-France</option><option value="Ile-de-France">Ile-de-France</option><option value="La Réunion">La Réunion</option><option value="Martinique">Martinique</option><option value="Mayotte">Mayotte</option><option value="Normandie">Normandie</option><option value="Nouvelle-Aquitaine">Nouvelle-Aquitaine</option><option value="Occitanie">Occitanie</option><option value="Pays-de-la-Loire">Pays-de-la-Loire</option><option value="Provence-Alpes-Côte d'Azur">Provence-Alpes-Côte d'Azur</option>
                    </select>
                </div>

                <?php
            }else{
                ?>
                <div class="col-md-3 form-group">
                    <select name="<?= $nom_champ_departement ?>" id="<?= $nom_champ_departement ?>" class="form-control" required>
                        <option value="">-- département --</option><option value="97.1 Guadeloupe" data-region="Guadeloupe">97.1 Guadeloupe</option><option value="97.2 Martinique" data-region="Martinique">97.2 Martinique</option><option value="97.3 Guyane" data-region="Guyane">97.3 Guyane</option><option value="97.4 La Réunion" data-region="La Réunion">97.4 La Réunion</option><option value="97.6 Mayotte" data-region="Mayotte">97.6 Mayotte</option><option value="97.7 Saint-Barthélemy" data-region="Guadeloupe">97.7 Saint-Barthélemy</option><option value="97.8 Saint-Martin" data-region="Guadeloupe">97.8 Saint-Martin</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">

                    <select name="<?= $nom_champ_region ?>" id="<?= $nom_champ_region ?>" class="form-control" required>
                        <option value="">-- région --</option><option value="Guadeloupe">Guadeloupe</option><option value="Guyane">Guyane</option><option value="La Réunion">La Réunion</option><option value="Martinique">Martinique</option><option value="Mayotte">Mayotte</option>
                    </select>
                </div>

                <?php
            }
        }
        else{
            ?>
            <div class="col-md-3 form-group">
                <select name="<?= $nom_champ_departement ?>" id="<?= $nom_champ_departement ?>" class="form-control" required>
                    <option value="">-- département --</option><option value="01 Ain" data-region="Auvergne-Rhône-Alpes">01 Ain</option><option value="02 Aisne" data-region="Hauts-de-France">02 Aisne</option><option value="03 Allier" data-region="Auvergne-Rhône-Alpes">03 Allier</option><option value="04 Alpes-de-Haute-Provence" data-region="Provence-Alpes-Côte d'Azur">04 Alpes-de-Haute-Provence</option><option value="05 Hautes-Alpes" data-region="Provence-Alpes-Côte d'Azur">05 Hautes-Alpes</option><option value="06 Alpes-Maritimes" data-region="Provence-Alpes-Côte d'Azur">06 Alpes-Maritimes</option><option value="07 Ardèche" data-region="Auvergne-Rhône-Alpes">07 Ardèche</option><option value="08 Ardennes" data-region="Grand-Est">08 Ardennes</option><option value="09 Ariège" data-region="Occitanie">09 Ariège</option><option value="10 Aube" data-region="Grand-Est">10 Aube</option><option value="11 Aude" data-region="Occitanie">11 Aude</option><option value="12 Aveyron" data-region="Occitanie">12 Aveyron</option><option value="13 Bouches-du-Rhône" data-region="Provence-Alpes-Côte d'Azur">13 Bouches-du-Rhône</option><option value="14 Calvados" data-region="Normandie">14 Calvados</option><option value="15 Cantal" data-region="Auvergne-Rhône-Alpes">15 Cantal</option><option value="16 Charente" data-region="Nouvelle-Aquitaine">16 Charente</option><option value="17 Charente-Maritime" data-region="Nouvelle-Aquitaine">17 Charente-Maritime</option><option value="18 Cher" data-region="Centre-Val de Loire">18 Cher</option><option value="19 Corrèze" data-region="Nouvelle-Aquitaine">19 Corrèze</option><option value="21 Côte-d'Or" data-region="Bourgogne-Franche-Comté">21 Côte-d'Or</option><option value="22 Côtes-d'Armor" data-region="Bretagne">22 Côtes-d'Armor</option><option value="23 Creuse" data-region="Nouvelle-Aquitaine">23 Creuse</option><option value="24 Dordogne" data-region="Nouvelle-Aquitaine">24 Dordogne</option><option value="25 Doubs" data-region="Bourgogne-Franche-Comté">25 Doubs</option><option value="26 Drôme" data-region="Auvergne-Rhône-Alpes">26 Drôme</option><option value="27 Eure" data-region="Normandie">27 Eure</option><option value="28 Eure-et-Loir" data-region="Centre-Val de Loire">28 Eure-et-Loir</option><option value="29 Finistère" data-region="Bretagne">29 Finistère</option><option value="30 Gard" data-region="Occitanie">30 Gard</option><option value="31 Haute-Garonne" data-region="Occitanie">31 Haute-Garonne</option><option value="32 Gers" data-region="Occitanie">32 Gers</option><option value="33 Gironde" data-region="Nouvelle-Aquitaine">33 Gironde</option><option value="34 Hérault" data-region="Occitanie">34 Hérault</option><option value="35 Ile-et-Vilaine" data-region="Bretagne">35 Ile-et-Vilaine</option><option value="36 Indre" data-region="Centre-Val de Loire">36 Indre</option><option value="37 Indre-et-Loire" data-region="Centre-Val de Loire">37 Indre-et-Loire</option><option value="38 Isère" data-region="Auvergne-Rhône-Alpes">38 Isère</option><option value="39 Jura" data-region="Bourgogne-Franche-Comté">39 Jura</option><option value="40 Landes" data-region="Nouvelle-Aquitaine">40 Landes</option><option value="41 Loir-et-Cher" data-region="Centre-Val de Loire">41 Loir-et-Cher</option><option value="42 Loire" data-region="Auvergne-Rhône-Alpes">42 Loire</option><option value="43 Haute-Loire" data-region="Auvergne-Rhône-Alpes">43 Haute-Loire</option><option value="44 Loire-Atlantique" data-region="Pays-de-la-Loire">44 Loire-Atlantique</option><option value="45 Loiret" data-region="Centre-Val de Loire">45 Loiret</option><option value="46 Lot" data-region="Occitanie">46 Lot</option><option value="47 Lot-et-Garonne" data-region="Nouvelle-Aquitaine">47 Lot-et-Garonne</option><option value="48 Lozère" data-region="Occitanie">48 Lozère</option><option value="49 Maine-et-Loire" data-region="Pays-de-la-Loire">49 Maine-et-Loire</option><option value="50 Manche" data-region="Normandie">50 Manche</option><option value="51 Marne" data-region="Grand-Est">51 Marne</option><option value="52 Haute-Marne" data-region="Grand-Est">52 Haute-Marne</option><option value="53 Mayenne" data-region="Pays-de-la-Loire">53 Mayenne</option><option value="54 Meurthe-et-Moselle" data-region="Grand-Est">54 Meurthe-et-Moselle</option><option value="55 Meuse" data-region="Grand-Est">55 Meuse</option><option value="56 Morbihan" data-region="Bretagne">56 Morbihan</option><option value="57 Moselle" data-region="Grand-Est">57 Moselle</option><option value="58 Nièvre" data-region="Bourgogne-Franche-Comté">58 Nièvre</option><option value="59 Nord" data-region="Hauts-de-France">59 Nord</option><option value="60 Oise" data-region="Hauts-de-France">60 Oise</option><option value="61 Orne" data-region="Normandie">61 Orne</option><option value="62 Pas-de-Calais" data-region="Hauts-de-France">62 Pas-de-Calais</option><option value="63 Puy-de-Dôme" data-region="Auvergne-Rhône-Alpes">63 Puy-de-Dôme</option><option value="64 Pyrénées-Atlantiques" data-region="Nouvelle-Aquitaine">64 Pyrénées-Atlantiques</option><option value="65 Hautes-Pyrénées" data-region="Occitanie">65 Hautes-Pyrénées</option><option value="66 Pyrénées-Orientales" data-region="Occitanie">66 Pyrénées-Orientales</option><option value="67 Bas-Rhin" data-region="Grand-Est">67 Bas-Rhin</option><option value="68 Haut-Rhin" data-region="Grand-Est">68 Haut-Rhin</option><option value="69 Rhône" data-region="Auvergne-Rhône-Alpes">69 Rhône</option><option value="70 Haute-Saône" data-region="Bourgogne-Franche-Comté">70 Haute-Saône</option><option value="71 Saône-et-Loire" data-region="Bourgogne-Franche-Comté">71 Saône-et-Loire</option><option value="72 Sarthe" data-region="Pays-de-la-Loire">72 Sarthe</option><option value="73 Savoie" data-region="Auvergne-Rhône-Alpes">73 Savoie</option><option value="74 Haute-Savoie" data-region="Auvergne-Rhône-Alpes">74 Haute-Savoie</option><option value="75 Paris" data-region="Ile-de-France">75 Paris</option><option value="76 Seine-Maritime" data-region="Normandie">76 Seine-Maritime</option><option value="77 Seine-et-Marne" data-region="Ile-de-France">77 Seine-et-Marne</option><option value="78 Yvelines" data-region="Ile-de-France">78 Yvelines</option><option value="79 Deux-Sèvres" data-region="Nouvelle-Aquitaine">79 Deux-Sèvres</option><option value="80 Somme" data-region="Hauts-de-France">80 Somme</option><option value="81 Tarn" data-region="Occitanie">81 Tarn</option><option value="82 Tarn-et-Garonne" data-region="Occitanie">82 Tarn-et-Garonne</option><option value="83 Var" data-region="Provence-Alpes-Côte d'Azur">83 Var</option><option value="84 Vaucluse" data-region="Provence-Alpes-Côte d'Azur">84 Vaucluse</option><option value="85 Vendée" data-region="Pays-de-la-Loire">85 Vendée</option><option value="86 Vienne" data-region="Nouvelle-Aquitaine">86 Vienne</option><option value="87 Haute-Vienne" data-region="Nouvelle-Aquitaine">87 Haute-Vienne</option><option value="88 Vosges" data-region="Grand-Est">88 Vosges</option><option value="89 Yonne" data-region="Bourgogne-Franche-Comté">89 Yonne</option><option value="90 Territoire de Belfort" data-region="Bourgogne-Franche-Comté">90 Territoire de Belfort</option><option value="91 Essonne" data-region="Ile-de-France">91 Essonne</option><option value="92 Hauts-de-Seine" data-region="Ile-de-France">92 Hauts-de-Seine</option><option value="93 Seine-Saint-Denis" data-region="Ile-de-France">93 Seine-Saint-Denis</option><option value="94 Val-de-Marne" data-region="Ile-de-France">94 Val-de-Marne</option><option value="95 Val-d'Oise" data-region="Ile-de-France">95 Val-d'Oise</option><option value="2A Corse-du-Sud" data-region="Corse">2A Corse-du-Sud</option><option value="2B Haute-Corse" data-region="Corse">2B Haute-Corse</option><option value="97.1 Guadeloupe" data-region="Guadeloupe">97.1 Guadeloupe</option><option value="97.2 Martinique" data-region="Martinique">97.2 Martinique</option><option value="97.3 Guyane" data-region="Guyane">97.3 Guyane</option><option value="97.4 La Réunion" data-region="La Réunion">97.4 La Réunion</option><option value="97.6 Mayotte" data-region="Mayotte">97.6 Mayotte</option><option value="97.7 Saint-Barthélemy" data-region="Guadeloupe">97.7 Saint-Barthélemy</option><option value="97.8 Saint-Martin" data-region="Guadeloupe">97.8 Saint-Martin</option>
                </select>
            </div>
            <div class="col-md-3 form-group">

                <select name="<?= $nom_champ_region ?>" id="<?= $nom_champ_region ?>" class="form-control" required>
                    <option value="">-- région --</option><option value="Auvergne-Rhône-Alpes">Auvergne-Rhône-Alpes</option><option value="Bourgogne-Franche-Comté">Bourgogne-Franche-Comté</option><option value="Bretagne">Bretagne</option><option value="Centre-Val de Loire">Centre-Val de Loire</option><option value="Corse">Corse</option><option value="Grand-Est">Grand-Est</option><option value="Guadeloupe">Guadeloupe</option><option value="Guyane">Guyane</option><option value="Hauts-de-France">Hauts-de-France</option><option value="Ile-de-France">Ile-de-France</option><option value="La Réunion">La Réunion</option><option value="Martinique">Martinique</option><option value="Mayotte">Mayotte</option><option value="Normandie">Normandie</option><option value="Nouvelle-Aquitaine">Nouvelle-Aquitaine</option><option value="Occitanie">Occitanie</option><option value="Pays-de-la-Loire">Pays-de-la-Loire</option><option value="Provence-Alpes-Côte d'Azur">Provence-Alpes-Côte d'Azur</option>
                </select>
            </div>

            <?php
        }



        if( $valeur_departement != '' && $valeur_departement != null ){
            ?>
                <script> document.getElementById("<?=$nom_champ_departement?>").value = "<?=$valeur_departement?>"; </script>
            <?php
        }
        if( $valeur_region != '' && $valeur_region != null ){
            ?>
                <script> document.getElementById("<?=$nom_champ_region?>").value = "<?=$valeur_region?>"; </script>
            <?php
        }


    }

    public static function afficheBool( $valeur ){
        if( $valeur === 1 ) return 'Oui';
        return 'Non';
    }

    public static function pourcentage( $integer ){
        return (integer) $integer / 100;
    }

    public static function cleanString($value){
        $result  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$value);

        return $result;
    }
}

