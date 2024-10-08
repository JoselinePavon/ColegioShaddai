<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inscripcion
 *
 * @property $id
 * @property $nombres
 * @property $apellidos
 * @property $genero
 * @property $edad
 * @property $fecha_nacimiento
 * @property $grados_id
 * @property $seccions_id
 * @property $created_at
 * @property $updated_at
 * @property GRADO $grado
 * @property SECCION $seccion
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Inscripcion extends Model
{
    static $rules = [
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'genero' => 'required',
        'edad' => 'required|integer',
        'fecha_nacimiento' => 'required|date',
        'grados_id' => 'required|exists:grados,id',
        'seccions_id' => 'required|exists:seccions,id',
    ];


    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombres', 'apellidos', 'genero', 'edad', 'fecha_nacimiento', 'grados_id','seccions_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grado(){

        return $this->hasOne('App\Models\Grado', 'id', 'grados_id');


    }
    public function seccion(){

        return $this->hasOne('App\Models\Seccion', 'id', 'seccions_id');


    }

}
