<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\DestinationCategory;
use App\Models\Gallery;
use App\Models\Advertising;
use App\Models\Testimonial;
use App\Models\MapCoordinator;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    protected $weatherService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get current weather
        $weather = $this->weatherService->getCurrentWeather();

        // Get featured destinations
        $destinations = Destination::with(['category', 'gallery'])
            ->orderBy('id', 'asc')
            ->take(4)
            ->get();

        // Get categories for about section
        $categories = DestinationCategory::with(['destinations'])
            ->take(3)
            ->get();

        // Get main page display images from gallery with destination
        $galleryImages = Gallery::where('main_page_display', true)
            ->with('destination')
            ->latest()
            ->take(8)
            ->get();

        // Get random active advertisements
        $advertisements = Advertising::where('is_visible', true)
            ->where('start_date', '<=', now())
            ->where(function($query) {
                $query->where('expire_date', '>=', now())
                    ->orWhereNull('expire_date');
            })
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Get testimonials
        $testimonials = Testimonial::where('is_visible', true)
            ->with('destination')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Get map coordinators grouped by type
        $mapCoordinators = MapCoordinator::with('destination')
            ->get()
            ->groupBy('type');

        // Get popular destinations for articles section
        $popularDestinations = Destination::with(['category', 'gallery'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('home', compact(
            'weather',
            'destinations',
            'categories',
            'galleryImages',
            'advertisements',
            'testimonials',
            'mapCoordinators',
            'popularDestinations'
        ));
    }
}
