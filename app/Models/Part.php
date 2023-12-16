<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'stock',
        'price',
    ];

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class, 'part_id');
    }
}
