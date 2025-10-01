<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DestinationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DestinationCategory::query();

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $categories = $query->orderBy('title')->paginate(10);

        return view('admin.content.destination-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.content.destination-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'icon_class' => 'nullable|string|max:255',
            'title' => 'required|string|max:255|unique:destination_categories',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        DestinationCategory::create($request->all());

        return redirect()->route('admin.destination-categories.index')->with('success', 'Destination category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DestinationCategory $destinationCategory)
    {
        $destinationCategory->load('destinations');
        return view('admin.content.destination-categories.show', compact('destinationCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DestinationCategory $destinationCategory)
    {
        return view('admin.content.destination-categories.edit', compact('destinationCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DestinationCategory $destinationCategory)
    {
         $validator = Validator::make($request->all(), [
            'icon_class' => 'nullable|string|max:255',
            'title' => 'required|string|max:255|unique:destination_categories,title,' . $destinationCategory->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $destinationCategory->update($request->all());

        return redirect()->route('admin.destination-categories.index')->with('success', 'Destination category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestinationCategory $destinationCategory)
    {
        $destinationCategory->delete();

        return redirect()->route('admin.destination-categories.index')->with('success', 'Destination category deleted successfully.');
    }
}
