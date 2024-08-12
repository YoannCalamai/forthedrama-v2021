<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Illustration extends Model
{
    protected $fillable = [ 'url' ];

    public function carte()
    {
        return $this->belongsTo(Carte::class);
    }
}
