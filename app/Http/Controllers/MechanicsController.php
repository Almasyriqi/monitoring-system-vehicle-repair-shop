<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MechanicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mechanics = Mechanic::all();
        return view('mechanics.index', compact('mechanics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mechanics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mechanic = new Mechanic();
        $mechanic->name = $request->name;
        $mechanic->email = $request->email;
        $mechanic->expertise = $request->expertise;
        $mechanic->save();
        return redirect()->route('mechanic.index')->with('success', 'Success add new mechanic'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mechanic = Mechanic::find($id);
        return view('mechanics.show', compact('mechanic'));
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
    public function update(Request $request, string $id)
    {
        $mechanic = Mechanic::find($id);
        $mechanic->name = $request->name;
        $mechanic->email = $request->email;
        $mechanic->expertise = $request->expertise;
        $mechanic->save();
        return redirect()->route('mechanic.show', $id)->with('success', 'Success update mechanic data'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $mechanic = Mechanic::find($id);
            $mechanic->delete();

            DB::commit();
            return redirect()->route('mechanic.index')->with('success', 'Success delete mechanic'); 
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors("Unable to delete a mechanic because the mechanic data is already connected to other data");
        }
    }
}
