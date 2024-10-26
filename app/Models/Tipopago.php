<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipopago
 *
 * @property $id
 * @property $tipo_pago
 * @property $monto
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tipopago extends Model
{
    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo_pago', 'monto'];



}
