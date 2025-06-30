<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $technician = auth()->user()->technician;
        abort_unless($technician, 403);

        $reviews = Review::with(['customer.user', 'booking'])
            ->where('technician_id', $technician->id)
            ->latest()
            ->paginate(20);

        return view('technician.reviews.index', compact('reviews'));
    }
}
