<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'estimated_duration',
        'base_price',
        'is_active',
    ];

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }
}
