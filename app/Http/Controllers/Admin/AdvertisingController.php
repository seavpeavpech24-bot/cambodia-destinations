<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdvertisingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Advertising::query();

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        // Filter by visibility
        if ($request->has('is_visible') && $request->input('is_visible') != '') {
            $query->where('is_visible', $request->input('is_visible'));
        }

        $advertisements = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.marketing.advertising.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.marketing.advertising.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'video' => 'nullable|mimes:mp4,mov,avi',
            'link' => 'nullable|url',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after:start_date',
            'is_visible' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except(['image', 'video']);
            $data['is_visible'] = $request->input('is_visible', 0);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('advertisements/images', 'public');
                $data['image_url'] = $imagePath;
            }

            if ($request->hasFile('video')) {
                $video = $request->file('video');
                
                // Validate video file size
                if ($video->getSize() > 51200000) { // 50MB in bytes
                    return redirect()->back()
                        ->withErrors(['video' => 'Video file size must be less than 50MB'])
                        ->withInput();
                }

                // Store video with original filename
                $videoPath = $video->storeAs(
                    'advertisements/videos',
                    time() . '_' . $video->getClientOriginalName(),
                    'public'
                );
                
                if (!$videoPath) {
                    throw new \Exception('Failed to store video file');
                }
                
                $data['video_url'] = $videoPath;
            }

            $advertisement = Advertising::create($data);

            return redirect()->route('admin.advertising.index')
                ->with('success', 'Advertisement created successfully.');
                
        } catch (\Exception $e) {
            \Log::error('Advertisement creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create advertisement. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertising $advertising)
    {
        return view('admin.marketing.advertising.show', compact('advertising'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertising $advertising)
    {
        return view('admin.marketing.advertising.edit', compact('advertising'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertising $advertising)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'video' => 'nullable|mimes:mp4,mov,avi',
            'link' => 'nullable|url',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after:start_date',
            'is_visible' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except(['image', 'video']);
            $data['is_visible'] = $request->input('is_visible', 0);

            // If an image is uploaded, delete any existing video
            if ($request->hasFile('image')) {
                if ($advertising->video_url && Storage::disk('public')->exists($advertising->video_url)) {
                    Storage::disk('public')->delete($advertising->video_url);
                    $data['video_url'] = null; // Clear video_url in database
                }
                if ($advertising->image_url && Storage::disk('public')->exists($advertising->image_url)) {
                    Storage::disk('public')->delete($advertising->image_url);
                }
                $imagePath = $request->file('image')->store('advertisements/images', 'public');
                if (!$imagePath) {
                    throw new \Exception('Failed to store image file');
                }
                $data['image_url'] = $imagePath;
            }

            // If a video is uploaded, delete any existing image
            if ($request->hasFile('video')) {
                $video = $request->file('video');
                
                // Validate video file size
                if ($video->getSize() > 51200000) { // 50MB in bytes
                    return redirect()->back()
                        ->withErrors(['video' => 'Video file size must be less than 50MB'])
                        ->withInput();
                }

                if ($advertising->image_url && Storage::disk('public')->exists($advertising->image_url)) {
                    Storage::disk('public')->delete($advertising->image_url);
                    $data['image_url'] = null; // Clear image_url in database
                }
                if ($advertising->video_url && Storage::disk('public')->exists($advertising->video_url)) {
                    Storage::disk('public')->delete($advertising->video_url);
                }
                
                // Store video with original filename
                $videoPath = $video->storeAs(
                    'advertisements/videos',
                    time() . '_' . $video->getClientOriginalName(),
                    'public'
                );
                
                if (!$videoPath) {
                    throw new \Exception('Failed to store video file');
                }
                
                $data['video_url'] = $videoPath;
            }

            $advertising->update($data);

            return redirect()->route('admin.advertising.index')
                ->with('success', 'Advertisement updated successfully.');
                
        } catch (\Exception $e) {
            \Log::error('Advertisement update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update advertisement. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertising $advertising)
    {
        // Delete associated files
        if ($advertising->image_url) {
            Storage::disk('public')->delete($advertising->image_url);
        }
        if ($advertising->video_url) {
            Storage::disk('public')->delete($advertising->video_url);
        }

        $advertising->delete();

        return redirect()->route('admin.advertising.index')
            ->with('success', 'Advertisement deleted successfully.');
    }
}