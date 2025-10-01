<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroPages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HeroPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HeroPages::query();

        // Search
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('page', 'like', '%' . $search . '%');
        }

        // Filter by page (example - assuming a dropdown or similar filter)
        if ($request->has('page') && $request->input('page') != '') {
            $query->where('page', $request->input('page'));
        }

        $heroPages = $query->orderByDesc('id')->paginate(10);

        return view('admin.content.hero-pages.index', compact('heroPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You might want to pass a list of available pages to the view if needed for a dropdown
        $availablePages = ['home', 'about', 'contact', 'destinations', 'travel-tips', 'tours']; // Example pages
        return view('admin.content.hero-pages.create', compact('availablePages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // image upload (no size limit)
            'page' => 'required|string|max:255|unique:hero_pages,page', // Assuming page must be unique
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/hero_pages', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        HeroPages::create($data);

        return redirect()->route('admin.hero-pages.index')->with('success', 'Hero page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroPages $heroPage)
    {
        return view('admin.content.hero-pages.show', compact('heroPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroPages $heroPage)
    {
        // You might want to pass a list of available pages to the view if needed for a dropdown
        $availablePages = ['home', 'about', 'contact', 'destinations', 'travel-tips', 'tours']; // Example pages
        return view('admin.content.hero-pages.edit', compact('heroPage', 'availablePages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroPages $heroPage)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // image upload is optional on update (no size limit)
            'page' => 'required|string|max:255|unique:hero_pages,page,' . $heroPage->id, // page must be unique except for the current record
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($heroPage->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $heroPage->image_url));
            }
            $imagePath = $request->file('image')->store('uploads/hero_pages', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $heroPage->update($data);

        return redirect()->route('admin.hero-pages.index')->with('success', 'Hero page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroPages $heroPage)
    {
        // Delete image file if it exists
        if ($heroPage->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $heroPage->image_url));
        }

        $heroPage->delete();

        return redirect()->route('admin.hero-pages.index')->with('success', 'Hero page deleted successfully.');
    }
}
