<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'expertise',
    ];

    public function repairs()
    {
        return $this->hasMany(Repair::class, 'mechanic_id');
    }
}
