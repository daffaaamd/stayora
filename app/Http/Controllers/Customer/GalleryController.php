<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::active()->get();
        $categories = $images->pluck('category')->unique()->filter()->values();
        return view('customer.gallery', compact('images', 'categories'));
    }
}
