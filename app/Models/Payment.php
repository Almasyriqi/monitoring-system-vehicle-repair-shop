<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_id',
        'total',
        'payment_date',
    ];

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class, 'payment_id');
    }

    public function repairs()
    {
        return $this->belongsTo(Repair::class, 'repair_id');
    }
}
