<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('destination.category');

        // Filter by category if selected
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('destination', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->whereHas('destination', function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $galleryImages = $query->latest()->paginate(12);
        $categories = DestinationCategory::orderBy('title')->get();

        return view('public.gallery.index', compact('galleryImages', 'categories'));
    }
} 