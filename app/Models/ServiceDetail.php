<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'spare_part_id',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'type',
    ];

    public function booking()
    {
        return $this->belongsTo(ServiceBooking::class, 'booking_id');
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'spare_part_id');
    }
}
