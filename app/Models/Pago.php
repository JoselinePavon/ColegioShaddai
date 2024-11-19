<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pago
 *
 * @property $id
 * @property $num_serie
 * @property $fecha_pago
 * @property $tipopagos_id
 * @property $estados_id
 * @property $mes_id
 * @property $registro_alumnos_id
 * @property $created_at
 * @property $updated_at
 *
 * @property RegistroAlumno $registroAlumno
 * @property Tipopago $tipopago
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
    protected $fillable = ['num_serie', 'fecha_pago', 'tipopagos_id', 'registro_alumnos_id','estados_id','mes_id'];


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
    public function tipopago()
    {
        return $this->belongsTo(\App\Models\Tipopago::class, 'tipopagos_id', 'id');
    }

    public function estado()
    {
        return $this->belongsTo(\App\Models\estado::class, 'estados_id', 'id');
    }

    public function mes()
    {
        return $this->belongsTo(\App\Models\me::class, 'mes_id', 'id');
    }


}
