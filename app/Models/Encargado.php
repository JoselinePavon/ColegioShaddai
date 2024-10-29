<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Encargado
 *
 * @property $id
 * @property $nombre_encargado
 * @property $direccion
 * @property $num_encargado1
 * @property $num_encargado2
 * @property $persona_emergencia
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Encargado extends Model
{
    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre_encargado', 'direccion', 'num_encargado1', 'num_encargado2', 'persona_emergencia'];



}
