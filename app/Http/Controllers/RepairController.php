<?php

namespace App\Http\Controllers;

use App\Events\RealTimeMessage;
use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\Part;
use App\Models\Repair;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $repairs = Repair::when($request->car_progress, function($query){
            $query->where('status', 1)->whereHas('vehicle', function($query){
                $query->where('type', 'car');
            });
        })->when($request->car_complete, function($query){
            $query->where('status', 2)->whereHas('vehicle', function($query){
                $query->where('type', 'car');
            });
        })->when($request->motor_progress, function($query){
            $query->where('status', 1)->whereHas('vehicle', function($query){
                $query->where('type', 'motorbike');
            });
        })->when($request->motor_complete, function($query){
            $query->where('status', 2)->whereHas('vehicle', function($query){
                $query->where('type', 'motorbike');
            });
        })->get();
        return view('repairs.index', compact('repairs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $mechanics = Mechanic::all();
        return view('repairs.create', compact('customers', 'mechanics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $repair = new Repair();
        $repair->vehicle_id = $request->vehicle_id;
        $repair->mechanic_id = $request->mechanic_id;
        $repair->issue = $request->issue;
        $repair->repair_date = $request->repair_date;
        $repair->save();

        event(new RealTimeMessage('status'));
        return redirect()->route('repair.index')->with('success', 'Success add new repair data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customers = Customer::all();
        $mechanics = Mechanic::all();
        $repair = Repair::find($id);
        $parts = Part::where([['stock', '>', 0], ['type', $repair->vehicle->type]])->get();
        $constraint_min_date = Carbon::parse($repair->repair_date)->format('m/d/Y');
        $payment_date = $repair->payment ? Carbon::parse($repair->payment->payment_date)->format('Y-m-d') : Carbon::parse(now())->format('Y-m-d');
        $process_time = Carbon::parse($repair->start_time)->floatDiffInHours($repair->end_time);
        return view('repairs.show', compact('customers', 'mechanics', 'parts', 'repair', 'constraint_min_date', 'payment_date', 'process_time'));
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
        $repair = Repair::find($id);
        $repair->vehicle_id = $request->vehicle_id;
        $repair->mechanic_id = $request->mechanic_id;
        $repair->issue = $request->issue;
        $repair->repair_date = $request->repair_date;
        $repair->start_time = $request->start_time;
        $repair->end_time = $request->end_time;
        $repair->status = $request->status;
        $repair->save();

        event(new RealTimeMessage('status'));
        return redirect()->route('repair.show', $id)->with('success', 'Success update repair data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $repair = Repair::find($id);
            $repair->delete();

            DB::commit();
            return redirect()->route('repair.index')->with('success', 'Success delete repair data');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withErrors("Unable to delete a repair because the repair data is already connected to other data");
        }
    }
}
