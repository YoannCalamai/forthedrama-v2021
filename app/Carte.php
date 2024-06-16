<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
class Carte extends Model
{
    use HasTranslations;
    use SoftDeletes;

    protected $fillable = [ 'carte','type'];
    public $translatable = ['carte'];

    public function jeu()
    {
        return $this->belongsTo(Jeu::class);
    }


}
