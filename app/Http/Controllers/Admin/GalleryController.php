<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Gallery::query()->with('destination');

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            // Assuming you want to search in destination title or potentially image filename if stored
            $query->whereHas('destination', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
            // If you store a filename in the database, you might add something like:
            // ->orWhere('image_url', 'like', '%' . $search . '%');
        }

        // Filter by destination
        if ($request->has('destination_id') && $request->input('destination_id') != '') {
            $query->where('destination_id', $request->input('destination_id'));
        }

        // Filter by main page display
        if ($request->has('main_page_display') && $request->input('main_page_display') != '') {
            $query->where('main_page_display', $request->input('main_page_display'));
        }

        $galleryItems = $query->orderByDesc('id')->get(); // Or paginate()

        $destinations = Destination::orderBy('title')->get(); // For filter dropdown

        return view('admin.content.gallery.index', compact('galleryItems', 'destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinations = Destination::orderBy('title')->get();
        return view('admin.content.gallery.create', compact('destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination_id' => 'nullable|exists:destinations,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Assuming file upload
            'main_page_display' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/gallery', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('destination');
        return view('admin.content.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $destinations = Destination::orderBy('title')->get();
        return view('admin.content.gallery.edit', compact('gallery', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'destination_id' => 'nullable|exists:destinations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image is nullable on update
            'main_page_display' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($gallery->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $gallery->image_url));
            }
            $imagePath = $request->file('image')->store('uploads/gallery', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image file if it exists
        if ($gallery->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $gallery->image_url));
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
} 