<?php

namespace App\Http\Controllers;

use App\Models\Me;
use App\Http\Requests\MeRequest;

/**
 * Class MeController
 * @package App\Http\Controllers
 */
class MeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mes = Me::paginate();

        return view('me.index', compact('mes'))
            ->with('i', (request()->input('page', 1) - 1) * $mes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $me = new Me();
        return view('me.create', compact('me'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeRequest $request)
    {
        Me::create($request->validated());

        return redirect()->route('mes.index')
            ->with('success', 'Me created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $me = Me::find($id);

        return view('me.show', compact('me'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $me = Me::find($id);

        return view('me.edit', compact('me'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeRequest $request, Me $me)
    {
        $me->update($request->validated());

        return redirect()->route('mes.index')
            ->with('success', 'Me updated successfully');
    }

    public function destroy($id)
    {
        Me::find($id)->delete();

        return redirect()->route('mes.index')
            ->with('success', 'Me deleted successfully');
    }
}
