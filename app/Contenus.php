<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
class Contenus extends Model
{
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['contenu'];
}
