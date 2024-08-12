<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jeu;
use App\Session;
use Pusher;

class PartieController extends Controller
{

    public function distribue( Request $request )
    {
        $session = \App\Session::where( 'code_room', '=', $request['code_room'])->first();
        $cartes = unserialize( $session->cartes );
        $carte_active = $request['carte_active']  + 1;

        $session->carte_active = $carte_active;
        $session->save();

        if( $carte_active == -1 ) return;

        $carte = \App\Carte::find( $cartes[ $carte_active ]['id'] );

        if( $carte->type == 'finale') $carte_finale = 1;
        else $carte_finale = 0;

        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '1e1141b22179b33d00be',
            'f6e8a8ab652170c6a9c1',
            '781727',
            $options
        );
        $data['carte_active'] = $carte_active;
        $data['carte_finale'] = $carte_finale;
        $data['carte'] = $carte->carte;
        $data['carte_type'] = $carte->type;

        $pusher->trigger('channel-' . $session->code_room, 'distribue_carte', $data);
        return response()->json([
            'carte' => $carte->carte,
            'carte_active' => $carte_active,
            'carte_finale' => $carte_finale,
            'carte_type' => $carte->type
        ]);

    }
    public function retourCarte( Request $request )
    {
        $session = \App\Session::where( 'code_room', '=', $request['code_room'])->first();
        $cartes = unserialize( $session->cartes );
        $carte_active = $request['carte_active']  - 1;

        $session->carte_active = $carte_active;
        $session->save();

        $carte_finale = 0;

        $carte = \App\Carte::find( $cartes[ $carte_active ]['id']);

        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '1e1141b22179b33d00be',
            'f6e8a8ab652170c6a9c1',
            '781727',
            $options
        );

        $data['carte_active'] = $carte_active;
        $data['carte_finale'] = $carte_finale;
        $data['carte'] = $carte->carte;
        $data['carte_type'] = $carte->type;

        $pusher->trigger('channel-' . $session->code_room, 'distribue_carte', $data);

        return response()->json([
            'carte' => $carte->carte,
            'carte_active' => $carte_active,
            'carte_finale' => $carte_finale,
            'carte_type' => $carte->type
        ]);
    }

    public function distribueSansIncrement( Request $request )
    {
        $session = \App\Session::where( 'code_room', '=', $request['code_room'])->first();
        $cartes = unserialize( $session->cartes );
        $carte_active = $request['carte_active'];

        if( $carte_active == -1 ) return;

        $carte = \App\Carte::find( $cartes[ $carte_active ]['id']);

        if( $carte->type == 'finale') $carte_finale = 1;
        else $carte_finale = 0;

        return response()->json([
            'carte' => $carte->carte,
            'carte_active' => $carte_active,
            'carte_finale' => $carte_finale,
            'carte_type' => $carte->type

        ]);

    }

    public function xcard( Request $request){
        $session = \App\Session::where( 'code_room', '=', $request['code_room'])->first();
        $cartes = unserialize( $session->cartes );
        $carte_active = $request['carte_active']  - 1;

        $session->carte_active = $carte_active;
        $session->save();

        $carte_finale = 0;

        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '1e1141b22179b33d00be',
            'f6e8a8ab652170c6a9c1',
            '781727',
            $options
        );
        $data['shake'] = 'shake shake shake';
        $pusher->trigger('channel-' . $session->code_room, 'xcard', $data);
    }
}
