<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Helper;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CartesExport implements FromView, ShouldAutoSize
{

    public function __construct(int $jeu_id )
    {
        $this->jeu_id = $jeu_id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $cartes = \App\Carte::where('jeu_id', $this->jeu_id)->orderBy('numero', 'asc')->get();
        if( count($cartes) == 0 ){
            $cartes = [];

            $carte = new \App\Carte();
            $carte->type = 'instruction';
            $carte->carte = 'Exemple : ceci est une instruction de votre jeu';
            $carte->groupe = '';

            $cartes[] = $carte;

            $carte = new \App\Carte();
            $carte->type = 'question';
            $carte->carte = 'Exemple : ceci est une question de votre jeu';
            $carte->groupe = '';

            $cartes[] = $carte;

            $carte = new \App\Carte();
            $carte->type = 'finale';
            $carte->carte = 'Exemple : ceci est la carte finalede votre jeu';
            $carte->groupe = '';

            $cartes[] = $carte;

        }

        return view('backend.admin.exports.cartes', compact('cartes' ) );
    }
}
