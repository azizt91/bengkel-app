<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $query = Technician::with('user')
            ->withCount(['serviceBookings as active_bookings_count' => function($q){
                $q->whereNot('status', 'completed');
            }])
            ->withAvg('reviews', 'rating')
            ->latest();
        if($search){
            $query->whereHas('user', function($q) use ($search){
                $q->where('name','like',"%{$search}%")
                  ->orWhere('email','like',"%{$search}%");
            });
        }
        $technicians = $query->paginate(20);
        return view('admin.technicians.index', compact('technicians','search'));
    }
}
