<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['date', 'carte_active', 'code_room'];
    protected $table = 'sessions_jeu';
    public static $rules = [
        'date'   => 'date',
    ];
    public function jeu()
    {
        return $this->belongsTo(Jeu::class);
    }

    public static function nettoieSessions(){
        $sessions = Session::where('date', '<', \Carbon\Carbon::yesterday() )->get();
        foreach ( $sessions as $session ) { $session->delete(); }
    }
}
