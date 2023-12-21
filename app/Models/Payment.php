<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function repair()
    {
        return $this->belongsTo(Repair::class, 'repair_id');
    }

    public function getDatePaymentAttribute()
    {
        $date_payment = $this->payment_date ? Carbon::parse($this->payment_date)->locale('id')->isoFormat('D MMMM Y') : "-";
        return $date_payment;
    }
}
