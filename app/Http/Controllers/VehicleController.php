<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customer = Customer::find($request->customer_id);
        return view('customers.vehicles.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->customer_id = $request->customer_id;
        $vehicle->model = $request->model;
        $vehicle->color = $request->color;
        $vehicle->type = $request->type;
        $vehicle->plat_number = $request->plat_number;
        $vehicle->save();
        return redirect()->route('customer.show', $request->customer_id)->with('success', 'Success add new vehicle');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::find($id);
        return view('customers.vehicles.show', compact('vehicle'));
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
        $vehicle = Vehicle::find($id);
        $vehicle->model = $request->model;
        $vehicle->color = $request->color;
        $vehicle->type = $request->type;
        $vehicle->plat_number = $request->plat_number;
        $vehicle->save();
        return redirect()->route('vehicle.show', $id)->with('success', 'Success update vehicle data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $vehicle = Vehicle::find($id);
            $customer_id = $vehicle->customer_id;
            $vehicle->delete();

            DB::commit();
            return redirect()->route('customer.show', $customer_id)->with('success', 'Success delete vehicle data');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors("Unable to delete a vehicle because the vehicle data is already connected to other data");
        }
    }

    public function getVehicleByCustomer(Request $request)
    {
        $vehicles = Vehicle::where([
            ['model', 'like', '%' . $request->input('search', '') . '%'],
            ['customer_id', $request->customer_id]
        ])->get();

        $data = [];
        foreach ($vehicles as $v) {
            $data[] = [
                'id' => $v->id,
                'text' => $v->model . " (" . $v->type_text . ")"
            ];
        }
        return response()->json(['results' => $data]);
    }
}
