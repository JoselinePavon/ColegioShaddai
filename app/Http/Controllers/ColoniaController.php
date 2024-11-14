<?php

namespace App\Http\Controllers;

use App\Models\Colonia;
use App\Http\Requests\ColoniaRequest;
use App\Models\Lugar;

/**
 * Class ColoniaController
 * @package App\Http\Controllers
 */
class ColoniaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colonias = Colonia::paginate();

        return view('colonia.index', compact('colonias'))
            ->with('i', (request()->input('page', 1) - 1) * $colonias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colonia = new Colonia();
        $lugares = Lugar::all(); // Obtener todos los lugares

        return view('colonia.create', compact('colonia','lugares'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColoniaRequest $request)
    {
        Colonia::create($request->validated());

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $colonia = Colonia::find($id);

        return view('colonia.show', compact('colonia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $colonia = Colonia::find($id);

        return view('colonia.edit', compact('colonia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColoniaRequest $request, Colonia $colonia)
    {
        $colonia->update($request->validated());

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia updated successfully');
    }

    public function destroy($id)
    {
        Colonia::find($id)->delete();

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia deleted successfully');
    }
}
