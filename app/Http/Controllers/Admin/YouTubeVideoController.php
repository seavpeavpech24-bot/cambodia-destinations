<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YouTubeVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YouTubeVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = YouTubeVideo::query();

        // Search and Filter
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        $youtubeVideos = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.content.youtube-videos.index', compact('youtubeVideos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You might need to pass data here if your create view requires it (e.g., categories, pages)
        return view('admin.content.youtube-videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_id' => 'required|string|max:255|unique:youtube_videos,video_id', // Assuming video_id must be unique
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        YouTubeVideo::create($request->only(['title', 'description', 'video_id']));

        return redirect()->route('admin.youtube-videos.index')->with('success', 'YouTube video added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(YouTubeVideo $youtubeVideo)
    {
        return view('admin.content.youtube-videos.show', compact('youtubeVideo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YouTubeVideo $youtubeVideo)
    {
        // You might need to pass data here if your edit view requires it
        return view('admin.content.youtube-videos.edit', compact('youtubeVideo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YouTubeVideo $youtubeVideo)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_id' => 'required|string|max:255|unique:youtube_videos,video_id,' . $youtubeVideo->id, // video_id must be unique except for the current record
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $youtubeVideo->update($request->only(['title', 'description', 'video_id']));

        return redirect()->route('admin.youtube-videos.index')->with('success', 'YouTube video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YouTubeVideo $youtubeVideo)
    {
        // Perform hard delete
        $youtubeVideo->delete();

        return redirect()->route('admin.youtube-videos.index')->with('success', 'YouTube video deleted successfully.');
    }
}
