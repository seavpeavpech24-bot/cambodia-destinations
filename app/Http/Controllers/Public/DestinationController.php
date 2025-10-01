<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationCategory;
use App\Models\HeroPages;
use App\Models\Advertising;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::with(['category', 'gallery']);

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        // Handle category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $destinations = $query->latest()->paginate(6);
        $categories = DestinationCategory::withCount('destinations')
            ->orderBy('title')
            ->get();

        // Get hero section data for destinations page
        $heroPage = HeroPages::where('page', 'destinations')->first();

        // Get active advertisements
        $advertisements = Advertising::where('is_visible', true)
            ->where('start_date', '<=', now())
            ->where('expire_date', '>=', now())
            ->get();

        return view('destinations', compact('destinations', 'categories', 'heroPage', 'advertisements'));
    }

    public function show($id)
    {
        $destination = Destination::with(['category', 'activities', 'travelTips', 'gallery'])
            ->findOrFail($id);

        // Get active advertisements
        $advertisements = Advertising::where('is_visible', true)
            ->where('start_date', '<=', now())
            ->where('expire_date', '>=', now())
            ->get();

        return view('destination-detail', compact('destination', 'advertisements'));
    }
} 