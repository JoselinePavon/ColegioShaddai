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
    protected $fillable = ['nombres', 'apellidos', 'genero', 'edad', 'fecha_nacimiento'];

    public function encargado()
    {
        return $this->hasOne(Encargado::class, 'registro_alumnos_id');
    }


}
