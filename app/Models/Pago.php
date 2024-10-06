<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 *
 * @property $id
 * @property $num_serie
 * @property $tipo_pago
 * @property $costo_pago
 * @property $nombre_alumno
 * @property $grado
 * @property $fecha_pago
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pago extends Model
{
    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['num_serie', 'tipo_pago', 'costo_pago', 'nombre_alumno', 'grado', 'fecha_pago'];



}
