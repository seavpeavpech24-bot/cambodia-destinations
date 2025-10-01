<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CultureEtiquette;
use Illuminate\Http\Request;

class CultureEtiquetteController extends Controller
{
    public function index(Request $request)
    {
        $query = CultureEtiquette::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $cultureEtiquettes = $query->latest()->paginate(10);

        return view('admin.information.culture-etiquette.index', compact('cultureEtiquettes'));
    }

    public function create()
    {
        return view('admin.information.culture-etiquette.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon_class' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        CultureEtiquette::create($validated);

        return redirect()
            ->route('admin.culture-etiquette.index')
            ->with('success', 'Culture and etiquette item created successfully.');
    }

    public function show(CultureEtiquette $cultureEtiquette)
    {
        return view('admin.information.culture-etiquette.show', compact('cultureEtiquette'));
    }

    public function edit(CultureEtiquette $cultureEtiquette)
    {
        return view('admin.information.culture-etiquette.edit', compact('cultureEtiquette'));
    }

    public function update(Request $request, CultureEtiquette $cultureEtiquette)
    {
        $validated = $request->validate([
            'icon_class' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $cultureEtiquette->update($validated);

        return redirect()
            ->route('admin.culture-etiquette.index')
            ->with('success', 'Culture and etiquette item updated successfully.');
    }

    public function destroy(CultureEtiquette $cultureEtiquette)
    {
        $cultureEtiquette->delete();

        return redirect()
            ->route('admin.culture-etiquette.index')
            ->with('success', 'Culture and etiquette item deleted successfully.');
    }
} 