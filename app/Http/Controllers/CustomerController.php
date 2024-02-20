<?php

namespace App\Http\Controllers;

use App\Events\RealTimeMessage;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        event(new RealTimeMessage('Hello World! I am an event 😄'));
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->save();
        return redirect()->route('customer.index')->with('success', 'Success add new customer'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);
        $vehicles = Vehicle::where('customer_id', $customer->id)->get();
        return view('customers.show', compact('customer', 'vehicles'));
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
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->save();
        return redirect()->route('customer.show', $id)->with('success', 'Success update customer data'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::find($id);
            $customer->delete();

            DB::commit();
            return redirect()->route('customer.index')->with('success', 'Success delete customer'); 
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors("Unable to delete a customer because the customer data is already connected to other data");
        }
    }
}
