<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Colonia
 *
 * @property $id
 * @property $nombre
 * @property $lugars_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Lugar $lugar
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Colonia extends Model
{
    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'lugars_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lugar()
    {
        return $this->belongsTo(\App\Models\Lugar::class, 'lugars_id', 'id');
    }
    

}
