<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('email', 'like', "%{$search}%");
        }

        $subscribers = $query->latest()->paginate(10);

        return view('admin.marketing.subscribers.index', compact('subscribers'));
    }

    public function show(Subscriber $subscriber)
    {
        return view('admin.marketing.subscribers.show', compact('subscriber'));
    }

    public function import()
    {
        return view('admin.marketing.subscribers.import');
    }

    public function storeImport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $csv = Reader::createFromPath($request->file('csv_file')->getPathname());
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();
            $imported = 0;
            $errors = [];

            foreach ($records as $index => $record) {
                try {
                    $email = $record['email'] ?? null;
                    $status = $record['status'] ?? 'subscribed';

                    // Log the record being processed
                    Log::info('Processing record', ['record' => $record]);

                    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Invalid email at row " . ($index + 2) . ": {$email}";
                        continue;
                    }

                    // Check if status is valid
                    if (!in_array($status, ['subscribed', 'unsubscribed'])) {
                        $errors[] = "Invalid status at row " . ($index + 2) . ": {$status}";
                        continue;
                    }

                    $subscriber = Subscriber::updateOrCreate(
                        ['email' => $email],
                        [
                            'status' => $status,
                            'subscribed_at' => $status === 'subscribed' ? now() : null,
                            'unsubscribed_at' => $status === 'unsubscribed' ? now() : null
                        ]
                    );

                    $imported++;
                    Log::info('Subscriber imported successfully', ['email' => $email, 'status' => $status]);
                } catch (\Exception $e) {
                    $errors[] = "Error processing row " . ($index + 2) . ": " . $e->getMessage();
                    Log::error('Error importing subscriber', [
                        'error' => $e->getMessage(),
                        'record' => $record
                    ]);
                }
            }

            if ($imported > 0) {
                $message = "Successfully imported {$imported} subscribers.";
                if (!empty($errors)) {
                    $message .= " However, there were some errors: " . implode(', ', $errors);
                }
                return redirect()
                    ->route('admin.subscribers.index')
                    ->with('success', $message);
            }

            return back()
                ->withErrors(['csv_file' => 'No valid subscribers were imported. Errors: ' . implode(', ', $errors)])
                ->withInput();
        } catch (\Exception $e) {
            Log::error('CSV import failed', ['error' => $e->getMessage()]);
            return back()
                ->withErrors(['csv_file' => 'Failed to process CSV file: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function export()
    {
        $subscribers = Subscriber::all();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscribers.csv"',
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Status', 'Subscribed At', 'Unsubscribed At']);

            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->status,
                    $subscriber->subscribed_at,
                    $subscriber->unsubscribed_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function unsubscribe(Subscriber $subscriber)
    {
        $subscriber->unsubscribe();
        return redirect()
            ->route('admin.subscribers.index')
            ->with('success', 'Subscriber has been unsubscribed successfully.');
    }

    public function resubscribe(Subscriber $subscriber)
    {
        $subscriber->resubscribe();
        return redirect()
            ->route('admin.subscribers.index')
            ->with('success', 'Subscriber has been resubscribed successfully.');
    }
} 