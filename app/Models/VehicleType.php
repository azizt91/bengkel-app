<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function serviceBookings()
    {
        return $this->hasManyThrough(ServiceBooking::class, Vehicle::class);
    }
}
