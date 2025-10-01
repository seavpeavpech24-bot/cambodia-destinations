<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Testimonial::with(['destination', 'updatedBy']);

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('traveller_name', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%')
                  ->orWhere('from_country', 'like', '%' . $search . '%');
            });
        }

        // Filter by destination
        if ($request->has('destination_id') && $request->input('destination_id') != '') {
            $query->where('destination_id', $request->input('destination_id'));
        }

        // Filter by visibility
        if ($request->has('is_visible') && $request->input('is_visible') != '') {
            $query->where('is_visible', $request->input('is_visible'));
        }

        // Filter by rating
        if ($request->has('rating') && $request->input('rating') != '') {
            $query->where('rating', $request->input('rating'));
        }

        $testimonials = $query->orderBy('id', 'desc')->paginate(10);
        $destinations = Destination::orderBy('title')->get();

        return view('admin.marketing.testimonials.index', compact('testimonials', 'destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinations = Destination::orderBy('title')->get();
        return view('admin.marketing.testimonials.create', compact('destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'traveller_name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'destination_id' => 'required|exists:destinations,id',
            'is_visible' => 'boolean',
            'from_country' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['image']);
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $data['image_url'] = $imagePath;
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        $testimonial->load(['destination', 'updatedBy']);
        return view('admin.marketing.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        $destinations = Destination::orderBy('title')->get();
        return view('admin.marketing.testimonials.edit', compact('testimonial', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(), [
            'traveller_name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'destination_id' => 'required|exists:destinations,id',
            'is_visible' => 'boolean',
            'from_country' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['image']);
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image_url) {
                Storage::disk('public')->delete($testimonial->image_url);
            }
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $data['image_url'] = $imagePath;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete associated image if exists
        if ($testimonial->image_url) {
            Storage::disk('public')->delete($testimonial->image_url);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
} 