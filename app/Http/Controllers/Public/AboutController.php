<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advertising;
use App\Models\HeroPages;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Get hero data for about page
        $hero = HeroPages::where('page', 'about')->first();

        // Get active advertisements
        $advertisements = Advertising::where('is_visible', true)
            ->where('start_date', '<=', now())
            ->where('expire_date', '>=', now())
            ->get();

        return view('about', compact('hero', 'advertisements'));
    }
} 