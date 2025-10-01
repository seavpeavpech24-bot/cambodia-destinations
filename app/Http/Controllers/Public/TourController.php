<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advertising;
use App\Models\HeroPages;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        // Get hero data for tours page
        $hero = HeroPages::where('page', 'tours')->first();

        // Get active advertisements
        $advertisements = Advertising::where('is_visible', true)
            ->where('start_date', '<=', now())
            ->where('expire_date', '>=', now())
            ->get();

        return view('tours', compact('hero', 'advertisements'));
    }
} 