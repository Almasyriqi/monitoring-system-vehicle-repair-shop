<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    const CAR = 'car';
    const MOTORBIKE = 'motorbike';

    protected $fillable = [
        'customer_id',
        'model',
        'color',
        'type',
        'plat_number'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getTypeTextAttribute()
    {
        $type_text = $this->type == 'car' ? 'Car' : 'Motorbike';
        return $type_text;
    }
}
