<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CultureEtiquette;
use App\Models\BestVisitingTime;
use App\Models\GettingAround;
use App\Models\Advertising;
use App\Models\HeroPages;
use Illuminate\Http\Request;

class TravelTipController extends Controller
{
    public function index()
    {
        // Get hero data for travel tips page
        $hero = HeroPages::where('page', 'travel-tips')->first();

        // Get culture and etiquette tips
        $cultureEtiquette = CultureEtiquette::orderBy('created_at', 'desc')
            ->get();

        // Get best visiting times grouped by their group_by field
        $bestVisitingTimes = BestVisitingTime::orderBy('group_by')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('group_by');

        // Get getting around tips grouped by their group_by field
        $gettingAround = GettingAround::orderBy('group_by')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('group_by');

        // Get active advertisements
        $advertisements = Advertising::where('is_visible', true)
            ->where('start_date', '<=', now())
            ->where('expire_date', '>=', now())
            ->get();

        return view('travel-tips', compact('hero', 'cultureEtiquette', 'bestVisitingTimes', 'gettingAround', 'advertisements'));
    }
} 