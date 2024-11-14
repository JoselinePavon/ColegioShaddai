<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Http\Requests\LugarRequest;

/**
 * Class LugarController
 * @package App\Http\Controllers
 */
class LugarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lugars = Lugar::paginate();

        return view('lugar.index', compact('lugars'))
            ->with('i', (request()->input('page', 1) - 1) * $lugars->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lugar = new Lugar();
        return view('lugar.create', compact('lugar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LugarRequest $request)
    {
        Lugar::create($request->validated());

        return redirect()->route('lugars.index')
            ->with('success', 'Lugar created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lugar = Lugar::find($id);

        return view('lugar.show', compact('lugar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lugar = Lugar::find($id);

        return view('lugar.edit', compact('lugar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LugarRequest $request, Lugar $lugar)
    {
        $lugar->update($request->validated());

        return redirect()->route('lugars.index')
            ->with('success', 'Lugar updated successfully');
    }

    public function destroy($id)
    {
        Lugar::find($id)->delete();

        return redirect()->route('lugars.index')
            ->with('success', 'Lugar deleted successfully');
    }
}
