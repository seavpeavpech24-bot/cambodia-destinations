<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inquiries = ContactInquiry::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.communication.contact-inquiries.index', compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This resource route is defined but likely not needed for contact inquiries as they are user-submitted.
        // We will leave it empty for now.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // This resource route is defined but likely not needed for contact inquiries as they are user-submitted.
        // Inquiries are created via a separate public form, not the admin panel.
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactInquiry $contactInquiry)
    {
        return view('admin.communication.contact-inquiries.show', compact('contactInquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactInquiry $contactInquiry)
    {
        // This resource route is defined but we will handle updates via specific actions like respond and close.
        // We will leave this empty for now.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactInquiry $contactInquiry)
    {
        // This method can be used for general updates to the inquiry if needed, apart from respond and close.
        // For now, let's assume status updates or similar simple changes.
         $request->validate([
            'status' => 'required|string|in:Open,Closed,Replied',
        ]);

        $contactInquiry->update($request->only('status'));

        return redirect()->route('admin.contact-inquiries.index')->with('success', 'Contact inquiry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactInquiry $contactInquiry)
    {
        $contactInquiry->delete();
        return redirect()->route('admin.contact-inquiries.index')->with('success', 'Contact inquiry deleted successfully.');
    }

    /**
     * Handle responding to a contact inquiry.
     */
    public function respond(Request $request, ContactInquiry $contactInquiry)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'reply_message' => 'required|string',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('contact-replies', 'public');
        }

        // Create the reply
        $contactInquiry->replies()->create([
            'subject' => $request->input('subject'),
            'content' => $request->input('reply_message'),
            'file_path' => $filePath,
            'replied_by' => auth()->user()->name,
        ]);

        // Update the inquiry status
        $contactInquiry->update([
            'status' => 'responded',
            'responded_at' => now(),
        ]);

        return redirect()
            ->route('admin.contact-inquiries.show', $contactInquiry)
            ->with('success', 'Reply sent successfully.');
    }

    /**
     * Handle closing a contact inquiry.
     */
    public function close(ContactInquiry $contactInquiry)
    {
        $contactInquiry->update(['status' => 'Closed']);

        return redirect()->route('admin.contact-inquiries.index')->with('success', 'Contact inquiry closed successfully.');
    }

    /**
     * Handle exporting contact inquiries.
     */
    public function export()
    {
        // This is a placeholder. You would typically implement logic here to fetch data
        // and return a downloadable file (e.g., CSV).
        // For example, using a library like maatwebsite/excel.

        // For now, we'll just return a simple response.
        return response('Export functionality not yet implemented.', 200);
    }
}
