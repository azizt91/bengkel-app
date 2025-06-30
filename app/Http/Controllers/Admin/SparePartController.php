<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    public function index()
    {
        $parts = SparePart::orderBy('name')->paginate(20);
        return view('admin.spare_parts.index', compact('parts'));
    }

    public function create()
    {
        return view('admin.spare_parts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        SparePart::create($data);
        return redirect()->route('admin.spare-parts.index')->with('success', 'Spare part created');
    }

    public function edit(SparePart $sparePart)
    {
        return view('admin.spare_parts.edit', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $data = $this->validateData($request, $sparePart->id);
        $sparePart->update($data);
        return redirect()->route('admin.spare-parts.index')->with('success', 'Spare part updated');
    }

    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();
        return back()->with('success', 'Spare part deleted');
    }

    private function validateData(Request $request, $id=null): array
    {
        return $request->validate([
            'part_code' => ['required','string','max:50','unique:spare_parts,part_code,'.($id)],
            'name' => ['required','string','max:100'],
            'price' => ['required','numeric','min:0'],
            'stock_quantity' => ['required','integer','min:0'],
            'brand' => ['nullable','string','max:50'],
            'category' => ['nullable','string','max:50'],
            'is_active' => ['nullable','boolean'],
        ]);
    }
}
