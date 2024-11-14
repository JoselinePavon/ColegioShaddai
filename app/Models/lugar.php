<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lugar
 *
 * @property $id
 * @property $lugar
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Lugar extends Model
{
    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['lugar'];



}
