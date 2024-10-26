<?php

namespace App\Http\Controllers;

use App\Models\Tipopago;
use App\Http\Requests\TipopagoRequest;

/**
 * Class TipopagoController
 * @package App\Http\Controllers
 */
class TipopagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipopagos = Tipopago::paginate();

        return view('tipopago.index', compact('tipopagos'))
            ->with('i', (request()->input('page', 1) - 1) * $tipopagos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipopago = new Tipopago();
        return view('tipopago.create', compact('tipopago'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipopagoRequest $request)
    {
        Tipopago::create($request->validated());

        return redirect()->route('tipopagos.index')
            ->with('success', 'Tipopago created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tipopago = Tipopago::find($id);

        return view('tipopago.show', compact('tipopago'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tipopago = Tipopago::find($id);

        return view('tipopago.edit', compact('tipopago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipopagoRequest $request, Tipopago $tipopago)
    {
        $tipopago->update($request->validated());

        return redirect()->route('tipopagos.index')
            ->with('success', 'Tipopago updated successfully');
    }

    public function destroy($id)
    {
        Tipopago::find($id)->delete();

        return redirect()->route('tipopagos.index')
            ->with('success', 'Tipopago deleted successfully');
    }
}
