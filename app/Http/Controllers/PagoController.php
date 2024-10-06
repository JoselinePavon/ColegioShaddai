<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Http\Requests\PagoRequest;

/**
 * Class PagoController
 * @package App\Http\Controllers
 */
class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagos = Pago::paginate();

        return view('pago.index', compact('pagos'))
            ->with('i', (request()->input('page', 1) - 1) * $pagos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pago = new Pago();
        return view('pago.create', compact('pago'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request)
    {
        Pago::create($request->validated());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pago = Pago::find($id);

        return view('pago.show', compact('pago'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pago = Pago::find($id);

        return view('pago.edit', compact('pago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PagoRequest $request, Pago $pago)
    {
        $pago->update($request->validated());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago updated successfully');
    }

    public function destroy($id)
    {
        Pago::find($id)->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Pago deleted successfully');
    }
}
