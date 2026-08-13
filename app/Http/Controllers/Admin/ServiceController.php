<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::orderBy('sort_order')->paginate(15);
        return view('admin.services.index', compact('services'));
    }
    public function create() { return view('admin.services.create'); }
    public function store(Request $request) {
        $v = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'price' => 'required|numeric|min:0', 'category' => 'nullable|string|max:100', 'image' => 'nullable|image|max:2048']);
        $v['slug'] = Str::slug($v['name']);
        if ($request->hasFile('image')) $v['image'] = $request->file('image')->store('services', 'public');
        Service::create($v);
        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }
    public function edit(Service $service) { return view('admin.services.edit', compact('service')); }
    public function update(Request $request, Service $service) {
        $v = $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string', 'price' => 'required|numeric|min:0', 'category' => 'nullable|string|max:100', 'is_active' => 'nullable|boolean', 'image' => 'nullable|image|max:2048']);
        $v['slug'] = Str::slug($v['name']); $v['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) $v['image'] = $request->file('image')->store('services', 'public');
        $service->update($v);
        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }
    public function destroy(Service $service) {
        $service->update(['is_active' => false]);
        return redirect()->route('admin.services.index')->with('success', 'Service deactivated.');
    }
}
