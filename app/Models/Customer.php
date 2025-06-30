<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Auto-generate sequential customer_code e.g. CUS001
     */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_code',
        'birth_date',
        'gender',
        'emergency_contact',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public static function booted()
    {
        static::creating(function($customer){
            if(empty($customer->customer_code)){
                $lastId = self::max('id');
                $next = ($lastId ?? 0) + 1;
                $customer->customer_code = 'CUS'.str_pad($next,3,'0',STR_PAD_LEFT);
            }
        });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
