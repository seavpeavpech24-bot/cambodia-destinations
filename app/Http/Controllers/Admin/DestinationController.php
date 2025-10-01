<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationCategory;
use App\Models\Activity;
use App\Models\TravelTip;
use App\Models\Gallery;
use App\Traits\Cacheable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DestinationController extends Controller
{
    use Cacheable;

    protected $model = Destination::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Destination::query()->with('category');

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
        }

        // Filter by category
        if ($request->has('category_id') && $request->input('category_id') != '') {
            $query->where('category_id', $request->input('category_id'));
        }

        $destinations = $query->orderBy('id', 'desc')->paginate(10);
        $categories = DestinationCategory::orderBy('title')->get();

        return view('admin.content.destinations.index', compact('destinations', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DestinationCategory::orderBy('title')->get();
        return view('admin.content.destinations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:destination_categories,id',
            'cover_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_link' => 'nullable|url|max:255',
            'best_time_to_visit' => 'nullable|string|max:255',
            'entry_fee' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Handle cover image upload
            $coverImagePath = $request->file('cover_url')->store('destinations/covers', 'public');
            $coverUrl = Storage::url($coverImagePath);

            // Create destination
            $destination = Destination::create([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'category_id' => $request->category_id,
                'cover_url' => $coverUrl,
                'map_link' => $request->map_link,
                'best_time_to_visit' => $request->best_time_to_visit,
                'entry_fee' => $request->entry_fee,
            ]);

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $imagePath = $image->store('destinations/gallery', 'public');
                    $imageUrl = Storage::url($imagePath);
                    Gallery::create([
                        'destination_id' => $destination->id,
                        'image_url' => $imageUrl,
                    ]);
                }
            }

            DB::commit();
            $this->clearAllModelCaches();

            return redirect()
                ->route('admin.destinations.index')
                ->with('success', 'Destination created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Destination creation failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to create destination: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        $destination->load(['category', 'gallery']);
        return view('admin.content.destinations.show', compact('destination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        $categories = DestinationCategory::orderBy('title')->get();
        $destination->load('gallery');
        return view('admin.content.destinations.edit', compact('destination', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:destination_categories,id',
            'cover_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_link' => 'nullable|url|max:255',
            'best_time_to_visit' => 'nullable|string|max:255',
            'entry_fee' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Handle cover image upload if new image is provided
            if ($request->hasFile('cover_url')) {
                // Delete old cover image
                if ($destination->cover_url) {
                    $oldPath = str_replace('/storage/', 'public/', $destination->cover_url);
                    Storage::delete($oldPath);
                }
                $coverImagePath = $request->file('cover_url')->store('destinations/covers', 'public');
                $coverUrl = Storage::url($coverImagePath);
            } else {
                $coverUrl = $destination->cover_url;
            }

            // Update destination
            $destination->update([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'category_id' => $request->category_id,
                'cover_url' => $coverUrl,
                'map_link' => $request->map_link,
                'best_time_to_visit' => $request->best_time_to_visit,
                'entry_fee' => $request->entry_fee,
            ]);

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $imagePath = $image->store('destinations/gallery', 'public');
                    $imageUrl = Storage::url($imagePath);
                    Gallery::create([
                        'destination_id' => $destination->id,
                        'image_url' => $imageUrl,
                    ]);
                }
            }

            DB::commit();
            $this->clearAllModelCaches();

            return redirect()
                ->route('admin.destinations.index')
                ->with('success', 'Destination updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Destination update failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to update destination: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        try {
            DB::beginTransaction();

            // Delete cover image
            if ($destination->cover_image) {
                Storage::disk('public')->delete($destination->cover_image);
            }

            // Delete gallery images
            foreach ($destination->gallery as $gallery) {
                Storage::disk('public')->delete($gallery->image_url);
                $gallery->delete();
            }

            // Delete destination
        $destination->delete();

            DB::commit();
            $this->clearAllModelCaches();

            return redirect()
                ->route('admin.destinations.index')
                ->with('success', 'Destination deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Destination deletion failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to delete destination. Please try again.');
        }
    }
}
