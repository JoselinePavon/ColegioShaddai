<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RegistroAlumno
 *
 * @property $id
 * @property $nombres
 * @property $apellidos
 * @property $genero
 * @property $edad
 * @property $codigo_personal
 * @property $encargados_id
 * @property $fecha_nacimiento
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class RegistroAlumno extends Model
{


    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombres', 'apellidos', 'genero', 'edad', 'fecha_nacimiento','codigo_personal','encargados_id'];

    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'encargados_id','id');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'registro_alumnos_id', 'id');
    }
    public function inscripcion()
    {
        return $this->hasOne(\App\Models\Inscripcion::class, 'registro_alumnos_id', 'id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'registro_alumnos_id');
    }

}
