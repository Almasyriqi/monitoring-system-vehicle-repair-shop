<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table='repairs';

    protected $fillable = [
        'id',
        'vehicle_id',
        'mechanic_id',
        'issue',
        'repair_date',
        'start_time',
        'end_time',
        'status'
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function mechanic() {
        return $this->belongsTo(Mechanic::class, 'mechanic_id');
    }

    public function payment() {
        return $this->hasOne(Payment::class, 'repair_id');
    }

    public function getDateRepairAttribute()
    {
        $date_repair = $this->repair_date ? Carbon::parse($this->repair_date)->locale('id')->isoFormat('D MMMM Y') : "-";
        return $date_repair;
    }
}
