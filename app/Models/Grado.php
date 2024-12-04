<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Grado
 *
 * @property $id
 * @property $nombre_grado
 * @property $nivels_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Grado extends Model
{


    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre_grado','nivels_id'];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'grados_id', 'id');
    }

    public function nivel()
    {
        return $this->belongsTo(\App\Models\Nivel::class, 'nivels_id', 'id');
    }
}
