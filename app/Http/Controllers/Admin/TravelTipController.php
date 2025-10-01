<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelTip;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TravelTipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TravelTip::query()->with('destination');

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        // Filter by destination
        if ($request->has('destination_id') && $request->input('destination_id') != '') {
            $query->where('destination_id', $request->input('destination_id'));
        }

        $travelTips = $query->orderBy('id', 'desc')->paginate(10);

        $destinations = Destination::orderBy('title')->get(); // For filter dropdown

        return view('admin.content.travel-tips.index', compact('travelTips', 'destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinations = Destination::orderBy('title')->get();
        return view('admin.content.travel-tips.create', compact('destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination_id' => 'nullable|exists:destinations,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_by' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        TravelTip::create($request->all());

        return redirect()->route('admin.travel-tips.index')->with('success', 'Travel tip created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelTip $travelTip)
    {
        $travelTip->load('destination');
        return view('admin.content.travel-tips.show', compact('travelTip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelTip $travelTip)
    {
        $destinations = Destination::orderBy('title')->get();
        return view('admin.content.travel-tips.edit', compact('travelTip', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TravelTip $travelTip)
    {
         $validator = Validator::make($request->all(), [
            'destination_id' => 'nullable|exists:destinations,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_by' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $travelTip->update($request->all());

        return redirect()->route('admin.travel-tips.index')->with('success', 'Travel tip updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelTip $travelTip)
    {
        $travelTip->delete();

        return redirect()->route('admin.travel-tips.index')->with('success', 'Travel tip deleted successfully.');
    }
}
