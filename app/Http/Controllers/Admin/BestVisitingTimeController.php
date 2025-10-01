<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BestVisitingTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BestVisitingTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BestVisitingTime::query();

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('content', 'like', '%' . $search . '%');
        }

        // Filter by group_by
        if ($request->has('group_by') && $request->input('group_by') != '') {
            $query->where('group_by', $request->input('group_by'));
        }

        $bestVisitingTimes = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.information.best-visiting-times.index', compact('bestVisitingTimes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.information.best-visiting-times.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'group_by' => 'required|string|in:dry_season,green_season',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        BestVisitingTime::create($request->all());

        return redirect()->route('admin.best-visiting-times.index')
                        ->with('success', 'Best visiting time created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BestVisitingTime $bestVisitingTime)
    {
        return view('admin.information.best-visiting-times.edit', compact('bestVisitingTime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BestVisitingTime $bestVisitingTime)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'group_by' => 'required|string|in:dry_season,green_season',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $bestVisitingTime->update($request->all());

        return redirect()->route('admin.best-visiting-times.index')
                        ->with('success', 'Best visiting time updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BestVisitingTime $bestVisitingTime)
    {
        $bestVisitingTime->delete();

        return redirect()->route('admin.best-visiting-times.index')
                        ->with('success', 'Best visiting time deleted successfully.');
    }
} 