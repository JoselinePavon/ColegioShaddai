<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Me
 *
 * @property $id
 * @property $mes
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Me extends Model
{
    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['mes'];



}
