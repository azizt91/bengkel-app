<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'customer_id',
        'vehicle_id',
        'service_category_id',
        'custom_request',
        'technician_id',
        'booking_date',
        'estimated_duration',
        'preferred_time',
        'status',
        'complaint_description',
        'estimated_cost',
        'actual_cost',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class, 'booking_id');
    }

    public function services()
    {
        return $this->hasMany(ServiceDetail::class, 'booking_id')->where('type', 'labor');
    }

    public function spareParts()
    {
        return $this->hasMany(ServiceDetail::class, 'booking_id')->where('type', 'part');
    }

    public function serviceProgress()
    {
        return $this->hasMany(ServiceProgress::class, 'booking_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'booking_id');
    }
}
