<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parts = Part::all();
        return view('parts.index', compact('parts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $part = new Part();
        $part->name = $request->name;
        $part->type = $request->type;
        $part->stock = $request->stock;
        $price = str_replace('Rp ', '', $request->price);
        $price = str_replace('.', '', $price);
        $part->price = $price;
        $part->price = $price;
        $part->save();
        return redirect()->route('part.index')->with('success', 'Success add new spare part');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $part = Part::find($id);
        return view('parts.show', compact('part'));
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
        $part = Part::find($id);
        $part->name = $request->name;
        $part->type = $request->type;
        $part->stock = $request->stock;
        $price = str_replace('Rp ', '', $request->price);
        $price = str_replace('.', '', $price);
        $part->price = $price;
        $part->price = $price;
        $part->save();
        return redirect()->route('part.show', $id)->with('success', 'Success update spare part data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $part = Part::find($id);
            $part->delete();

            DB::commit();
            return redirect()->route('part.index')->with('success', 'Success delete part'); 
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors("Unable to delete a part because the part data is already connected to other data");
        }
    }
}
