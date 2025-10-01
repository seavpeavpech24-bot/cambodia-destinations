<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // This resource route is not used for WebInfo as there is likely only one record.
        // The settings method will handle displaying the form.
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This resource route is not used for WebInfo as there is likely only one record.
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // This resource route is not used for WebInfo as we update the existing record.
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // This resource route is not used for WebInfo.
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         // This resource route is not used for WebInfo.
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // This resource route is not used for WebInfo.
        abort(404);
    }

    /**
     * Display the web info settings form.
     */
    public function settings()
    {
        $webInfo = WebInfo::first(); // Assuming there is only one record for web info
        if (!$webInfo) {
            $webInfo = new WebInfo(); // Create a new instance if no record exists yet
        }
        return view('admin.communication.web-info.settings', compact('webInfo'));
    }

    /**
     * Update the web info settings in storage.
     */
    public function updateWebInfo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
        ]);

        $webInfo = WebInfo::first() ?? new WebInfo();

        $data = $request->only([
            'title',
            'phone_number',
            'email',
            'location',
            'facebook_link',
            'youtube_link',
            'instagram_link',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($webInfo->logo_url) {
                $oldPath = str_replace('/storage/', 'public/', $webInfo->logo_url);
                Storage::delete($oldPath);
            }
            // Store new logo
            $path = $request->file('logo')->store('upload_files', 'public');
            $data['logo_url'] = Storage::url($path); // e.g., /storage/upload_files/filename.jpg
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if it exists
            if ($webInfo->favicon_url) {
                $oldPath = str_replace('/storage/', 'public/', $webInfo->favicon_url);
                Storage::delete($oldPath);
            }
            // Store new favicon
            $path = $request->file('favicon')->store('upload_files', 'public');
            $data['favicon_url'] = Storage::url($path); // e.g., /storage/upload_files/filename.jpg
        }

        $webInfo->fill($data);
        $webInfo->save();

        return redirect()->route('admin.web-info.settings')->with('success', 'Web Info updated successfully.');
    }
}
