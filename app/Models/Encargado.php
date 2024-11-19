<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Encargado
 *
 * @property $id
 * @property $nombre_encargado
 * @property $edad
 * @property $estado_civil
 * @property $oficio
 * @property $direccion
 * @property $num_encargado1
 * @property $num_encargado2
 * @property $persona_emergencia
 * @property $registro_alumnos_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Encargado extends Model
{
    protected $table = 'encargados'; // Nombre de la tabla
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     * Atributos que pueden ser asignados masivamente.
     *
     * @var array
     */

    protected $fillable = [
        'nombre_encargado',
        'edad',
        'estado_civil',
        'oficio',
        'dpi',
        'telefono',
        'persona_emergencia',
        'registro_alumnos_id',
        'lugars_id',
        'colonias_id',
    ];

    /**
     * Relación con el modelo Lugar.
     * Un encargado pertenece a un lugar.
     */
    public function lugar()
    {
        return $this->belongsTo(Lugar::class, 'lugars_id');
    }

    /**
     * Relación con el modelo Colonia.
     * Un encargado pertenece a una colonia.
     */
    public function colonia()
    {
        return $this->belongsTo(Colonia::class, 'colonias_id');
    }

    /**
     * Relación con el modelo RegistroAlumno.
     * Un encargado está asociado a un alumno.
     */
    public function registroAlumno()
    {
        return $this->belongsTo(RegistroAlumno::class, 'registro_alumnos_id');
    }
}
