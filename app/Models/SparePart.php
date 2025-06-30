<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_code',
        'name',
        'brand',
        'description',
        'category',
        'price',
        'stock_quantity',
        'minimum_stock',
        'supplier_info',
        'is_active',
    ];

    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class, 'spare_part_id');
    }
}
