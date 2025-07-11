<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'license_plate',
        'brand',
        'model',
        'year',
        'engine_type',
        'transmission_type',
        'color',
        'chassis_number',
        'engine_number',
        'qr_token',
        'last_service_date',
        'vehicle_type_id',
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}
