<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroPages;
use App\Models\Destination;
use App\Models\Testimonial;
use App\Models\Subscriber;
use App\Models\ContactInquiry;
use App\Models\Advertising;
use App\Models\MapCoordinator;
use App\Models\Gallery;
use App\Models\YouTubeVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard cards with caching
        $data = Cache::remember('admin_dashboard_counts', 300, function () {
            return [
                'hero_pages_count' => HeroPages::count(),
                'destinations_count' => Destination::count(),
                'testimonials_count' => Testimonial::where('is_visible', true)->count(),
                'subscribers_count' => Subscriber::where('status', 'subscribed')->count(),
                'contact_inquiries_count' => ContactInquiry::where('status', 'open')->count(),
                'advertising_count' => Advertising::where('is_visible', true)
                    ->where('start_date', '<=', now())
                    ->where('expire_date', '>=', now())
                    ->count(),
                'map_coordinators_count' => MapCoordinator::count(),
                'gallery_count' => Gallery::count(),
                'youtube_videos_count' => YouTubeVideo::count(),
            ];
        });

        // Get recent activities with caching
        $data['recent_activities'] = Cache::remember('admin_recent_activities', 300, function () {
            $recentActivities = collect();

            // Add recent hero pages
            $recentActivities = $recentActivities->concat(
                HeroPages::select('title', 'updated_at')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'action' => 'Updated',
                            'section' => 'Hero Page',
                            'title' => $item->title,
                            'date' => $item->updated_at,
                        ];
                    })
            );

            // Add recent destinations
            $recentActivities = $recentActivities->concat(
                Destination::select('title', 'updated_at')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'action' => 'Updated',
                            'section' => 'Destination',
                            'title' => $item->title,
                            'date' => $item->updated_at,
                        ];
                    })
            );

            // Add recent testimonials
            $recentActivities = $recentActivities->concat(
                Testimonial::select('traveller_name', 'updated_at')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'action' => 'Updated',
                            'section' => 'Testimonial',
                            'title' => $item->traveller_name,
                            'date' => $item->updated_at,
                        ];
                    })
            );

            // Add recent contact inquiries
            $recentActivities = $recentActivities->concat(
                ContactInquiry::select('subject', 'created_at')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'action' => 'New',
                            'section' => 'Contact Inquiry',
                            'title' => $item->subject,
                            'date' => $item->created_at,
                        ];
                    })
            );

            // Sort all activities by date and take the most recent 10
            return $recentActivities->sortByDesc('date')->take(10);
        });

        return view('admin.dashboard', $data);
    }
} 