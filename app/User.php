<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jeux(){
        return $this->hasMany(\App\Jeu::class, 'id', 'user_id');
    }

    public static function afficheNom(){
        return \Auth::user()->name;
    }

    public function aUnJeu(){
        $has = \App\Jeu::where('user_id', $this->id)->first();
        return $has != null;
    }
    public function aUnJeuSupprime(){
        $has = \App\Jeu::withTrashed()->where('user_id', $this->id)->wherenotnull('deleted_at')->first();
        return $has != null;
    }

    public function compteJeuSupprime(){
        $has = \App\Jeu::withTrashed()->where('user_id', $this->id)->wherenotnull('deleted_at')->get();
        if( $has === null ) return 0;
        else return count( $has );
    }

    public function hasJeu($jeu){
        $has = \App\Jeu::where('user_id', $this->id)->where('id', $jeu->id)->first();
        if( $has === null ) return false;
        return true;
    }
}
