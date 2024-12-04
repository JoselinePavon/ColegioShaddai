<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Http\Requests\GradoRequest;
use App\Models\Nivel;

/**
 * Class GradoController
 * @package App\Http\Controllers
 */
class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grados = Grado::paginate();
        $nivel = Nivel::pluck('nivel', 'id');

        return view('grado.index', compact('grados','nivel'))
            ->with('i', (request()->input('page', 1) - 1) * $grados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grado = new Grado();
        $nivel = Nivel::pluck('nivel', 'id');
        return view('grado.create', compact('grado','nivel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradoRequest $request)
    {
        Grado::create($request->validated());


        return redirect()->route('grados.index')
            ->with('success', 'Grado created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $grado = Grado::find($id);

        return view('grado.show', compact('grado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $grado = Grado::find($id);
        $nivel = Nivel::pluck('nivel', 'id');


        return view('grado.edit', compact('grado','nivel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradoRequest $request, Grado $grado)
    {
        $grado->update($request->validated());

        return redirect()->route('grados.index')
            ->with('success', 'Grado updated successfully');
    }

    public function destroy($id)
    {
        $grado = Grado::find($id);

        // Verificar si el grado tiene inscripciones relacionadas
        if ($grado->inscripciones()->exists()) { // Asegúrate de tener la relación 'inscripciones' definida en el modelo Grado
            return redirect()->route('grados.index')
                ->with('alerta','no');
        }

        $grado->delete();
        return redirect()->route('grados.index')
            ->with('success', 'Grado deleted successfully');
    }
}
