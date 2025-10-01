<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            // Log the raw request data
            Log::info('Raw request data:', [
                'all' => $request->all(),
                'email' => $request->email,
                'headers' => $request->headers->all()
            ]);

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:subscribers,email'
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed:', [
                    'errors' => $validator->errors()->toArray()
                ]);
                
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This email is already subscribed or invalid.'
                    ], 422);
                }
                
                return back()->withErrors($validator)->withInput();
            }

            // Start a database transaction
            DB::beginTransaction();
            try {
                $subscriber = Subscriber::create([
                    'email' => $request->email,
                    'status' => 'subscribed',
                    'subscribed_at' => now()
                ]);

                DB::commit();
                
                Log::info('Subscription successful:', [
                    'subscriber' => $subscriber->toArray()
                ]);

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Thank you for subscribing to our newsletter!'
                    ]);
                }

                return back()->with('success', 'Thank you for subscribing to our newsletter!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Database error:', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'sql' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
                ]);
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Subscription failed:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing your subscription. Please try again later.',
                    'debug' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return back()->with('error', 'An error occurred while processing your subscription. Please try again later.');
        }
    }
} 