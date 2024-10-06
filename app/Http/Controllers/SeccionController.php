<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use App\Http\Requests\SeccionRequest;

/**
 * Class SeccionController
 * @package App\Http\Controllers
 */
class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seccions = Seccion::paginate();

        return view('seccion.index', compact('seccions'))
            ->with('i', (request()->input('page', 1) - 1) * $seccions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seccion = new Seccion();
        return view('seccion.create', compact('seccion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeccionRequest $request)
    {
        Seccion::create($request->validated());

        return redirect()->route('seccions.index')
            ->with('success', 'Seccion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $seccion = Seccion::find($id);

        return view('seccion.show', compact('seccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $seccion = Seccion::find($id);

        return view('seccion.edit', compact('seccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeccionRequest $request, Seccion $seccion)
    {
        $seccion->update($request->validated());

        return redirect()->route('seccions.index')
            ->with('success', 'Seccion updated successfully');
    }

    public function destroy($id)
    {
        Seccion::find($id)->delete();

        return redirect()->route('seccions.index')
            ->with('success', 'Seccion deleted successfully');
    }
}
