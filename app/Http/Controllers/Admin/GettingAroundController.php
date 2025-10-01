<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GettingAround;
use Illuminate\Http\Request;

class GettingAroundController extends Controller
{
    public function index(Request $request)
    {
        $query = GettingAround::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('content', 'like', "%{$search}%");
        }

        if ($request->has('group_by')) {
            $query->where('group_by', $request->get('group_by'));
        }

        $gettingArounds = $query->latest()->paginate(10);

        return view('admin.information.getting-around.index', compact('gettingArounds'));
    }

    public function create()
    {
        return view('admin.information.getting-around.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'group_by' => 'required|string|in:' . implode(',', array_keys(GettingAround::GROUP_BY_OPTIONS))
        ]);

        GettingAround::create($validated);

        return redirect()
            ->route('admin.getting-around.index')
            ->with('success', 'Getting around information created successfully.');
    }

    public function show(GettingAround $gettingAround)
    {
        return view('admin.information.getting-around.show', compact('gettingAround'));
    }

    public function edit(GettingAround $gettingAround)
    {
        return view('admin.information.getting-around.edit', compact('gettingAround'));
    }

    public function update(Request $request, GettingAround $gettingAround)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'group_by' => 'required|string|in:' . implode(',', array_keys(GettingAround::GROUP_BY_OPTIONS))
        ]);

        $gettingAround->update($validated);

        return redirect()
            ->route('admin.getting-around.index')
            ->with('success', 'Getting around information updated successfully.');
    }

    public function destroy(GettingAround $gettingAround)
    {
        $gettingAround->delete();

        return redirect()
            ->route('admin.getting-around.index')
            ->with('success', 'Getting around information deleted successfully.');
    }
} 