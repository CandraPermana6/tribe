<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tribe;

class TribeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tribes = Tribe::all();
        return view('tribe', compact('tribes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'universitas' => 'required',
        ]);

        Tribe::create($request->all());

        return redirect()->route('tribe.index')->with('success', 'Tribe created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tribe $tribe)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'universitas' => 'required',
        ]);

        $tribe->update($request->all());

        return redirect()->route('tribe.index')->with('success', 'Tribe updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tribe $tribe)
    {
        $tribe->delete();

        return redirect()->route('tribe.index')->with('success', 'Tribe deleted successfully.');
    }
}
