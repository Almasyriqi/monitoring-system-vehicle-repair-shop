<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Part;
use App\Models\Payment;
use App\Models\Repair;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class DashboardController extends Controller
{
    public function index()
    {
        $parts = Part::all();
        $mechanics = Mechanic::all();
        $data_status = collect($this->getDataStatus()->original);
        $average_time = collect($this->getAverageTime()->original);
        return view('home', compact('parts', 'mechanics', 'data_status', 'average_time'));
    }

    public function getDataStatus()
    {
        $car_ongoing = Repair::whereHas('vehicle', function($query){
            $query->where('type', Vehicle::CAR);
        })->where('status', 1)->count();
        $car_complete = Repair::whereHas('vehicle', function($query){
            $query->where('type', Vehicle::CAR);
        })->where('status', 2)->count();
        $motor_ongoing = Repair::whereHas('vehicle', function($query){
            $query->where('type', Vehicle::MOTORBIKE);
        })->where('status', 1)->count();
        $motor_complete = Repair::whereHas('vehicle', function($query){
            $query->where('type', Vehicle::MOTORBIKE);
        })->where('status', 2)->count();
        return response()->json([$car_ongoing, $car_complete, $motor_ongoing, $motor_complete]);
    }

    public function getCompleteRepairs()
    {
        $latest_date = Repair::orderBy('repair_date', 'desc')->distinct('repair_date')->take(7)->pluck('repair_date')->toArray();
        $car = [];
        $motor = [];
        foreach($latest_date as $date){
            $car_count = Repair::where([['repair_date', $date], ['status', 2]])->whereHas('vehicle', function($query){
                $query->where('type', Vehicle::CAR);
            })->count() ?? 0;
            $motor_count = Repair::where([['repair_date', $date], ['status', 2]])->whereHas('vehicle', function($query){
                $query->where('type', Vehicle::MOTORBIKE);
            })->count() ?? 0;
            array_push($car, $car_count);
            array_push($motor, $motor_count);
        }
        $latest_date = array_reverse($latest_date);
        $car = array_reverse($car);
        $motor = array_reverse($motor);
        return response()->json(['date' => $latest_date, 'car' => $car, 'motor' => $motor]);
    }

    public function getAverageTime()
    {
        // get average time car repair
        $repair_car = Repair::where([['start_time', '!=', null], ['end_time', '!=', null]])->whereHas('vehicle', function($query){
            $query->where('type', Vehicle::CAR);
        })->get();
        $total_car_time = 0;
        foreach($repair_car as $item){
            $total_car_time += $item->process_time;
        }
        if($total_car_time > 0){
            $car_time = $total_car_time / count($repair_car);
        } else {
            $car_time = 0;
        }
        $car_time = round($car_time, 1);

        // get average time motor repair
        $repair_motor = Repair::where([['start_time', '!=', null], ['end_time', '!=', null]])->whereHas('vehicle', function($query){
            $query->where('type', Vehicle::MOTORBIKE);
        })->get();
        $total_motor_time = 0;
        foreach($repair_motor as $item){
            $total_motor_time += $item->process_time;
        }
        if($total_motor_time > 0){
            $motor_time = $total_motor_time / count($repair_motor);
        } else {
            $motor_time = 0;
        }
        $motor_time = round($motor_time, 1);
        return response()->json([$car_time, $motor_time]);
    }

    public function getRevenueData(Request $request)
    {
        // get total revenue data
        $payment_date = Payment::orderBy('payment_date', 'desc')->distinct('payment_date')->take(30)->pluck('payment_date')->toArray();
        $payment_date = array_reverse($payment_date);
        $total_payment_data = [];
        foreach($payment_date as $date){
            $payment = Payment::where('payment_date', $date)->sum('total');
            $total_payment_data[] = [
                'x' => $date,
                'y' => $payment
            ];
        }

        // get revenue by division
        $payment = Payment::whereHas('repair', function($query) use($request){
            $query->whereHas('vehicle', function($query) use($request){
                $query->where('type', $request->type);
            });
        });
        $revenue_date = $payment->orderBy('payment_date', 'desc')->distinct('payment_date')->take(30)->pluck('payment_date')->toArray();
        $revenue_date = array_reverse($revenue_date);
        $total_revenue_data = [];
        foreach($revenue_date as $date){
            $revenue = Payment::where('payment_date', $date)->sum('total');
            $total_revenue_data[] = [
                'x' => $date,
                'y' => $revenue
            ];
        }
        return response()->json(['total_payment_data' => $total_payment_data, 'total_revenue_data' => $total_revenue_data]);
    }

    public function getMechanicEfficient(Request $request)
    {
        $repair = Repair::where([['mechanic_id', $request->mechanic_id], ['status', 2]]);
        $complete_repair = $repair ? $repair->count() : 0;
        $total_time_spent = 0.0;
        foreach($repair->get() as $item){
            $total_time_spent += $item->process_time;
        } 

        $efficiency = ($complete_repair / $total_time_spent) * 100;
        $efficiency = round($efficiency, 1);
        return response()->json([$efficiency]);
    }
}
