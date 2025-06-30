<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    /**
     * Automatically generate sequential employee_id like EMP001, EMP002 ... when creating a technician
     */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'specialization',
        'experience_years',
        'certification',
        'hire_date',
        'salary',
        'is_available',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function serviceProgress()
    {
        return $this->hasMany(ServiceProgress::class);
    }

    public static function booted()
    {
        static::creating(function($technician){
            if(empty($technician->employee_id)){
                $lastId = self::max('id');
                $nextNumber = ($lastId ?? 0) + 1;
                $technician->employee_id = 'EMP'.str_pad($nextNumber,3,'0',STR_PAD_LEFT);
            }
        });
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
