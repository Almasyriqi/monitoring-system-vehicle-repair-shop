<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'part_id',
        'quantity',
        'amount',
        'note',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id');
    }
}
