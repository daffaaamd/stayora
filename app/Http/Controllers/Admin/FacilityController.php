<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index() {
        $facilities = Facility::orderBy('sort_order')->get();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create() { return view('admin.facilities.create'); }

    public function store(Request $request) {
        $v = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'icon' => 'nullable|string|max:100', 'image' => 'nullable|image|max:2048']);
        $v['slug'] = Str::slug($v['name']);
        if ($request->hasFile('image')) $v['image'] = $request->file('image')->store('facilities', 'public');
        Facility::create($v);
        return redirect()->route('admin.facilities.index')->with('success', 'Facility created.');
    }

    public function edit(Facility $facility) { return view('admin.facilities.edit', compact('facility')); }

    public function update(Request $request, Facility $facility) {
        $v = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'icon' => 'nullable|string|max:100', 'is_active' => 'nullable|boolean', 'image' => 'nullable|image|max:2048']);
        $v['slug'] = Str::slug($v['name']); $v['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) $v['image'] = $request->file('image')->store('facilities', 'public');
        $facility->update($v);
        return redirect()->route('admin.facilities.index')->with('success', 'Facility updated.');
    }

    public function destroy(Facility $facility) {
        $facility->update(['is_active' => false]);
        return redirect()->route('admin.facilities.index')->with('success', 'Facility deactivated.');
    }
}
