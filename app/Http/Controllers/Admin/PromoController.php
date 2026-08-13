<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index() {
        $promos = Promo::latest()->paginate(15);
        return view('admin.promos.index', compact('promos'));
    }
    public function create() { return view('admin.promos.create'); }
    public function store(Request $request) {
        $v = $request->validate([
            'code' => 'required|string|max:30|unique:promos',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_booking' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);
        $v['code'] = strtoupper($v['code']);
        Promo::create($v);
        return redirect()->route('admin.promos.index')->with('success', 'Promo created.');
    }
    public function edit(Promo $promo) { return view('admin.promos.edit', compact('promo')); }
    public function update(Request $request, Promo $promo) {
        $v = $request->validate([
            'code' => "required|string|max:30|unique:promos,code,{$promo->id}",
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_booking' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);
        $v['code'] = strtoupper($v['code']);
        $v['is_active'] = $request->boolean('is_active');
        $promo->update($v);
        return redirect()->route('admin.promos.index')->with('success', 'Promo updated.');
    }
    public function destroy(Promo $promo) {
        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Promo deleted.');
    }
}
