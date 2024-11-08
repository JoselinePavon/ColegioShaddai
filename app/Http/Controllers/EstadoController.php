<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Http\Requests\EstadoRequest;

/**
 * Class EstadoController
 * @package App\Http\Controllers
 */
class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::paginate();

        return view('estado.index', compact('estados'))
            ->with('i', (request()->input('page', 1) - 1) * $estados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estado = new Estado();
        return view('estado.create', compact('estado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstadoRequest $request)
    {
        Estado::create($request->validated());

        return redirect()->route('estados.index')
            ->with('success', 'Estado created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $estado = Estado::find($id);

        return view('estado.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estado = Estado::find($id);

        return view('estado.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstadoRequest $request, Estado $estado)
    {
        $estado->update($request->validated());

        return redirect()->route('estados.index')
            ->with('success', 'Estado updated successfully');
    }

    public function destroy($id)
    {
        Estado::find($id)->delete();

        return redirect()->route('estados.index')
            ->with('success', 'Estado deleted successfully');
    }
}
