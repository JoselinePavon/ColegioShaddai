<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnioEscolar extends Model
{
    protected $table = 'anios_escolares';

    protected $fillable = ['nombre'];
}
