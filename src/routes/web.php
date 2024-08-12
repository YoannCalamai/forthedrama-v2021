<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;


Auth::routes();

Route::group(['middleware' => ['web']], function () {
    Route::get('locale/{locale}',
    function (Request $request, $locale){
        $request->session()->put('locale', $locale );
        return redirect()->back();
    })->name('langue');
});


Route::get('/','AppController@home')->name('home');


Route::post('session','AppController@session')->name('session');
Route::get('session/{jeu_choisi?}','AppController@session')->name('session');

Route::get('session/duree/{code_room}','AppController@sessionGetDuree')->name('session.duree');
Route::post('session/duree/{code_room}','AppController@sessionSetDuree')->name('session.duree');

Route::post('distribue','PartieController@distribue')->name('distribue');
Route::post('distribuesans','PartieController@distribueSansIncrement')->name('distribueSansIncrement');
Route::post('retour','PartieController@retourCarte')->name('retourCarte');
Route::post('xcard','PartieController@xcard')->name('xcard');

Route::get('play/{code_room}/{carte_active?}','AppController@play')->name('session.play');

/** Contenus */
Route::get('mentionslegales', 'AppController@mentionslegales')->name('mentionslegales');
Route::get('aide', 'AppController@aide')->name('aide');
Route::get('listejeux', 'AppController@listejeux')->name('listejeux');

Route::get('imprimer/{id}', 'AppController@imprimer')->name('imprimer');
Route::get('telecharger/{id}', 'AppController@telecharger')->name('telecharger');

Route::get('/dev','AppController@homedev')->name('homedev');

Route::get('/changelog', function(){
    $contenu = \App\Contenus::where('name','=', 'changelog')->first();
    return view('contenu.changelog', compact('contenu'));
})->name('changelog');

Route::get('/avenir', function(){
    $contenu = \App\Contenus::where('name','=', 'avenir')->first();
    return view('contenu.avenir', compact('contenu'));
})->name('avenir');

Route::get('/questionnaire', function(){
    return view('contenu.questionnaire');
})->name('avenir');



Route::get('/games/{slug}', 'AppController@pageJeu')->name('jeus.show');

/**
 * BACK OFFICE
 */

Route::middleware('auth')->group(function () {
    Route::get('/backend/welcome', 'BackendController@index')->name('backend.home');
    Route::get('/backend/mygames/index', function () {
        // Réservé aux utilisateurs authentifiés
    });
});

///// CONTENUS
Route::get('contenus', 'ContenusController@index')->name('contenus.index');
Route::get('contenus/create', 'ContenusController@create')->name('contenus.create');
Route::get('contenus/edit/{id}', 'ContenusController@edit')->name('contenus.edit');
Route::post('contenus/update/{id}', 'ContenusController@update')->name('contenus.update');
Route::post('contenus/store', 'ContenusController@store')->name('contenus.store');
Route::delete('contenus/destroy/{id}', 'ContenusController@destroy')->name('contenus.destroy');
Route::get('contenus/fichiers/create/{categorie}', 'ContenusController@createFichier')->name('contenus.fichiers.create');
Route::get('contenus/fichiers/edit/{id}', 'ContenusController@editFichier')->name('contenus.fichiers.edit');
Route::delete('contenus/fichiers/destroy/{id}', 'ContenusController@destroyFichier')->name('contenus.fichiers.destroy');
Route::put('contenus/fichiers/update/{fichier}', 'ContenusController@updateFichier')->name('contenus.fichiers.update');
Route::post('contenus/fichiers/store', 'ContenusController@storeFichier')->name('contenus.fichiers.store');

///// ADMIN
Route::get('connectas/{id}', 'UserController@connectAs')->name('users.connectAs');
Route::get('rollbacklogin', 'UserController@rollBackLogin')->name('users.rollbacklogin');
Route::get('admin/journal', 'BackendController@journal')->name('admin.journal');
Route::resource('admin/users', 'UserController');
Route::get('users/export', 'UserController@export')->name('users.export');
Route::get('ols', 'UserController@indexOLS')->name('users.ols');
Route::put('admin/users/infos/{id}', 'UserController@updateinfos')->name('users.update.infos');
Route::get('admin/permissions', function(){
    $activities = Spatie\Permission\Models\Permission::orderby('name', 'asc')->get();
    return view('admin.permissions', ['activitiesPaginator' => $activities]);
})->name('admin.permissions');
Route::resource('admin/roles', 'RoleController');
Route::resource('admin/permissions', 'PermissionController');

///// JEUX
Route::get('backend/games/create', 'JeuController@create')->name('jeux.create');
Route::get('backend/games/index', 'JeuController@index')->name('jeux.index');
Route::get('backend/games/corbeille', 'JeuController@corbeille')->name('jeux.corbeille');
Route::get('backend/games/edit/{id}', 'JeuController@edit')->name('jeux.edit');
Route::post('backend/games/edit/ajax/{id}', 'JeuController@updateAjax')->name('jeux.update.ajax');
Route::post('backend/games/store', 'JeuController@store')->name('jeux.store');
Route::post('backend/games/edit/{id}', 'JeuController@update')->name('jeux.update');
Route::delete('backend/games/destroy/{id}', 'JeuController@destroy')->name('jeux.destroy');
Route::delete('backend/games/harddestroy/{id}', 'JeuController@harddestroy')->name('jeux.harddestroy');
Route::delete('backend/games/vidercorbeille', 'JeuController@vidercorbeille')->name('jeux.vidercorbeille');
Route::put('backend/games/restore/{id}', 'JeuController@restore')->name('jeux.restore');
Route::get('backgend/games/predestroy/{id}', 'JeuController@predestroy')->name('jeux.predestroy');

Route::post('backend/cartes/changeordre', 'CarteController@changenumero')->name('cartes.changenumero');
Route::get('backend/games/cartes/{id_game}', 'CarteController@index')->name('cartes.index');
Route::get('backend/games/cartes/premierecarte/{id_game}', 'CarteController@premierecarte')->name('cartes.premierecarte');
Route::post('backend/games/cartes/filtre/{id_game}', 'CarteController@index')->name('cartes.filtre');
Route::post('backend/games/cartes/create', 'CarteController@create')->name('cartes.create');
Route::post('backend/games/cartes/update', 'CarteController@update')->name('cartes.update');
Route::put('backend/games/cartes/delete', 'CarteController@destroy')->name('cartes.delete');
Route::get('backend/games/cartes/export/{game_id}', 'CarteController@export')->name('cartes.export');
Route::get('backend/games/cartes/importfront/{game_id}', 'CarteController@importfront')->name('cartes.importfront');
Route::post('backend/games/cartes/import', 'CarteController@import')->name('cartes.import');

Route::get('routine/test', function(){

    $image = 'grand_glouton.jpg';
    $chemin_image = storage_path().'/app/public/jeux/';

    dump( file_exists( $chemin_image. $image ));

    if( !is_dir( storage_path().'/app/public/illustrations/101/' ) ) mkdir( storage_path().'/app/public/illustrations/101/' );

    copy( $chemin_image.$image, storage_path().'/app/public/illustrations/101/'. $image );



});
Route::get('routine/majimages', function(){
    $jeux = \App\Jeu::get();
    foreach($jeux as $jeu ){

        $image = $jeu->image;
        $langs = ['de','en','fr','es','jp'];
        foreach ( $langs as $lang ){
            $jeu->forgetTranslation( 'image', $lang );
            $jeu
                ->setTranslation('image', $lang, $image )
                ->save();
        }
    }

});

