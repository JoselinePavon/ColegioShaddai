<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Http\Requests\EncargadoRequest;
use App\Models\RegistroAlumno;

/**
 * Class EncargadoController
 * @package App\Http\Controllers
 */
class EncargadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $encargados = Encargado::paginate();

        return view('encargado.index', compact('encargados'))
            ->with('i', (request()->input('page', 1) - 1) * $encargados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $encargado = new Encargado();
        $registro_alumno = RegistroAlumno::pluck('nombres', 'id');
        return view('encargado.create', compact('encargado','registro_alumno'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EncargadoRequest $request)
    {
        Encargado::create($request->validated());

        return redirect()->route('encargados.index')
            ->with('success', 'Encargado created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $encargado = Encargado::find($id);

        return view('encargado.show', compact('encargado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $encargado = Encargado::find($id);

        return view('encargado.edit', compact('encargado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EncargadoRequest $request, Encargado $encargado)
    {
        $encargado->update($request->validated());

        return redirect()->route('encargados.index')
            ->with('success', 'Encargado updated successfully');
    }

    public function destroy($id)
    {
        Encargado::find($id)->delete();

        return redirect()->route('encargados.index')
            ->with('success', 'Encargado deleted successfully');
    }
}
