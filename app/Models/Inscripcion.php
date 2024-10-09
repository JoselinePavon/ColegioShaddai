<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inscripcion
 *
 * @property $id
 * @property $registro_alumnos_id
 * @property $grados_id
 * @property $seccions_id
 * @property $created_at
 * @property $updated_at
 * @property RegistroAlumno $registroAlumno
 * @property GRADO $grado
 * @property SECCION $seccion
 * @
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Inscripcion extends Model
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'registro_alumnos_id' => 'required|exists:registro_alumnos,id',
            'grados_id' => 'required|exists:grados,id',
            'seccions_id' => 'required|exists:seccions,id',
        ];
    }
    protected $perPage = 20;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['registro_alumnos_id', 'grados_id','seccions_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */


    public function grado(){

        return $this->hasOne('App\Models\Grado', 'id', 'grados_id');
    }
    public function seccion(){

        return $this->hasOne('App\Models\Seccion', 'id', 'seccions_id');
    }
    public function registroAlumno(){
        return $this->belongsTo('App\Models\RegistroAlumno', 'registro_alumnos_id');
    }

}
