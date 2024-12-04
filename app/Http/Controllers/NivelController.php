<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use App\Http\Requests\NivelRequest;

/**
 * Class NivelController
 * @package App\Http\Controllers
 */
class NivelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nivels = Nivel::paginate();

        return view('nivel.index', compact('nivels'))
            ->with('i', (request()->input('page', 1) - 1) * $nivels->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nivel = new Nivel();
        return view('nivel.create', compact('nivel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NivelRequest $request)
    {
        Nivel::create($request->validated());

        return redirect()->route('nivels.index')
            ->with('success', 'Nivel created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $nivel = Nivel::find($id);

        return view('nivel.show', compact('nivel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nivel = Nivel::find($id);

        return view('nivel.edit', compact('nivel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NivelRequest $request, Nivel $nivel)
    {
        $nivel->update($request->validated());

        return redirect()->route('nivels.index')
            ->with('success', 'Nivel updated successfully');
    }

    public function destroy($id)
    {
        Nivel::find($id)->delete();

        return redirect()->route('nivels.index')
            ->with('success', 'Nivel deleted successfully');
    }
}
