<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Seccion
 *
 * @property $id
 * @property $seccion
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Seccion extends Model
{
    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['seccion'];



}
