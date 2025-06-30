<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProgress extends Model
{
    use HasFactory;

    // timestamps true by default

    protected $fillable = [
        'booking_id',
        'technician_id',
        'status',
        'description',
        'photo_path',
        'created_at',
    ];

    protected $casts = [
        
    ];

    public function booking()
    {
        return $this->belongsTo(ServiceBooking::class, 'booking_id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}
