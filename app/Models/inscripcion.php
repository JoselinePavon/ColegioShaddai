<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inscripcion
 *
 * @property $id
 * @property $registro_alumnos_id
 * @property $grados_id
 * @property $seccions_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Grado $grado
 * @property RegistroAlumno $registroAlumno
 * @property Seccion $seccion
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Inscripcion extends Model
{


    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['registro_alumnos_id', 'grados_id', 'seccions_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grado()
    {
        return $this->belongsTo(\App\Models\Grado::class, 'grados_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function registroAlumno()
    {
        return $this->belongsTo(\App\Models\RegistroAlumno::class, 'registro_alumnos_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seccion()
    {
        return $this->belongsTo(\App\Models\Seccion::class, 'seccions_id', 'id');
    }
    public function encargado()
    {
        return $this->hasOne(Encargado::class, 'registro_alumnos_id');
    }

}
