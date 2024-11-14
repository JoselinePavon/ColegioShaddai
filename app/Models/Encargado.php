<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
    protected $table = 'encargados'; // Nombre de la tabla
    protected $perPage = 20;

    /**
     * Atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_encargado',
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
