<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapCoordinator;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MapCoordinatorController extends Controller
{
    public function index(Request $request)
    {
        $query = MapCoordinator::with('destination');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('type')) {
            $query->where('type', $request->get('type'));
        }

        if ($request->has('destination_id')) {
            $query->where('destination_id', $request->get('destination_id'));
        }

        $mapCoordinators = $query->latest()->paginate(10);
        $destinations = Destination::all();

        return view('admin.information.map-coordinators.index', compact('mapCoordinators', 'destinations'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.information.map-coordinators.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination_id' => 'nullable|exists:destinations,id',
            'description' => 'required|string',
            'type' => 'required|string|in:' . implode(',', array_keys(MapCoordinator::TYPE_OPTIONS)),
            'icon_class' => 'required|string|max:255',
            'latitude_and_longitude' => 'required|string|max:255',
            'map_link' => 'required|url',
            'cover_url' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        // Handle file upload
        if ($request->hasFile('cover_url')) {
            $path = $request->file('cover_url')->store('map-coordinators', 'public');
            $validated['cover_url'] = Storage::url($path);
        }

        MapCoordinator::create($validated);

        return redirect()
            ->route('admin.map-coordinators.index')
            ->with('success', 'Map coordinator created successfully.');
    }

    public function show(MapCoordinator $mapCoordinator)
    {
        return view('admin.information.map-coordinators.show', compact('mapCoordinator'));
    }

    public function edit(MapCoordinator $mapCoordinator)
    {
        $destinations = Destination::all();
        return view('admin.information.map-coordinators.edit', compact('mapCoordinator', 'destinations'));
    }

    public function update(Request $request, MapCoordinator $mapCoordinator)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination_id' => 'nullable|exists:destinations,id',
            'description' => 'required|string',
            'type' => 'required|string|in:' . implode(',', array_keys(MapCoordinator::TYPE_OPTIONS)),
            'icon_class' => 'required|string|max:255',
            'latitude_and_longitude' => 'required|string|max:255',
            'map_link' => 'required|url',
            'cover_url' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        // Handle file upload
        if ($request->hasFile('cover_url')) {
            // Delete old file if exists
            if ($mapCoordinator->cover_url) {
                $oldPath = str_replace('/storage/', 'public/', $mapCoordinator->cover_url);
                Storage::delete($oldPath);
            }
            // Store new file
            $path = $request->file('cover_url')->store('map-coordinators', 'public');
            $validated['cover_url'] = Storage::url($path);
        }

        $mapCoordinator->update($validated);

        return redirect()
            ->route('admin.map-coordinators.index')
            ->with('success', 'Map coordinator updated successfully.');
    }

    public function destroy(MapCoordinator $mapCoordinator)
    {
        // Delete cover image if exists
        if ($mapCoordinator->cover_url) {
            $path = str_replace('/storage/', 'public/', $mapCoordinator->cover_url);
            Storage::delete($path);
        }

        $mapCoordinator->delete();

        return redirect()
            ->route('admin.map-coordinators.index')
            ->with('success', 'Map coordinator deleted successfully.');
    }
} 