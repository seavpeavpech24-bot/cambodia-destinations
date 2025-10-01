<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Destination;

class AiAssistantController extends Controller
{
    public function index()
    {
        return view('ai-assistant');
    }

    private function isDestinationQuery($message)
    {
        $destinationKeywords = [
            'destination', 'place', 'visit', 'travel', 'tourism', 'attraction',
            'temple', 'beach', 'mountain', 'city', 'province', 'where to go',
            'recommend', 'suggest', 'popular', 'famous', 'best', 'top'
        ];

        $message = strtolower($message);
        foreach ($destinationKeywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return true;
            }
        }
        return false;
    }

    private function detectLanguagePreference($message)
    {
        // Check if user wants to switch language
        if (str_contains(strtolower($message), 'speak khmer') || 
            str_contains(strtolower($message), 'speak in khmer') ||
            str_contains(strtolower($message), 'និយាយជាភាសាខ្មែរ')) {
            session(['ai_language' => 'km']);
            return true;
        } elseif (str_contains(strtolower($message), 'speak english') || 
                 str_contains(strtolower($message), 'speak in english')) {
            session(['ai_language' => 'en']);
            return true;
        }
        return false;
    }

    private function getSystemPrompt()
    {
        $basePrompt = "You are a helpful AI travel assistant for Cambodia tourism. ";
        
        $language = session('ai_language', 'en');
        if ($language === 'km') {
            $basePrompt .= "Please respond in Khmer language. ";
        }

        $basePrompt .= "You can help with:
            - Travel planning and itineraries
            - Destination recommendations
            - Local customs and culture
            - Transportation options
            - Accommodation suggestions
            - Food and dining recommendations
            - Safety tips and travel advice
            - Historical information
            - Local language phrases
            - Best times to visit
            - Budget planning
            - Visa and entry requirements
            - Local events and festivals
            - Shopping recommendations
            - Health and medical information
            - Emergency contacts
            - Local transportation
            - Cultural etiquette
            - Photography spots
            - Hidden gems and off-the-beaten-path locations";

        // Get conversation context from session
        $conversationContext = session('ai_conversation', []);
        
        // Add conversation context if available
        if (!empty($conversationContext)) {
            $basePrompt .= "\n\nPrevious conversation context:\n";
            foreach ($conversationContext as $context) {
                $basePrompt .= "- " . $context . "\n";
            }
        }

        return $basePrompt;
    }

    public function chat(Request $request)
    {
        try {
            $userMessage = $request->input('message');
            $conversationContext = $request->input('context', []); // array of previous exchanges
            $language = $request->input('language', 'en');

            // Detect language preference in the current message
            if (str_contains(strtolower($userMessage), 'speak khmer') || 
                str_contains(strtolower($userMessage), 'speak in khmer') ||
                str_contains(strtolower($userMessage), 'និយាយជាភាសាខ្មែរ')) {
                $language = 'km';
            } elseif (str_contains(strtolower($userMessage), 'speak english') || 
                     str_contains(strtolower($userMessage), 'speak in english')) {
                $language = 'en';
            }

            // Add user message to context
            $conversationContext[] = "User: " . $userMessage;
            // Keep only last 4 messages (2 exchanges)
            if (count($conversationContext) > 4) {
                array_shift($conversationContext);
            }

            $isDestinationQuery = $this->isDestinationQuery($userMessage);
            $destinations = [];
            if ($isDestinationQuery) {
                $destinations = $this->getRelevantDestinations($userMessage);
            }

            // Build system prompt
            $basePrompt = "You are a helpful AI travel assistant for Cambodia tourism. ";
            if ($language === 'km') {
                $basePrompt .= "Please respond in Khmer language. ";
            }
            $basePrompt .= "You can help with:\n- Travel planning and itineraries\n- Destination recommendations\n- Local customs and culture\n- Transportation options\n- Accommodation suggestions\n- Food and dining recommendations\n- Safety tips and travel advice\n- Historical information\n- Local language phrases\n- Best times to visit\n- Budget planning\n- Visa and entry requirements\n- Local events and festivals\n- Shopping recommendations\n- Health and medical information\n- Emergency contacts\n- Local transportation\n- Cultural etiquette\n- Photography spots\n- Hidden gems and off-the-beaten-path locations";
            if (!empty($conversationContext)) {
                $basePrompt .= "\n\nPrevious conversation context:\n";
                foreach ($conversationContext as $context) {
                    $basePrompt .= "- " . $context . "\n";
                }
            }
            if ($isDestinationQuery && !empty($destinations)) {
                $basePrompt .= "\n\nHere are some relevant destinations from our database:\n";
                foreach ($destinations as $destination) {
                    $basePrompt .= "- " . $destination['title'] . ": " . $destination['description'] . "\n";
                }
            }

            $response = Http::post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . config('services.gemini.api_key'), [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $basePrompt . "\n\nUser: " . $userMessage
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $aiResponse = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I could not process your request.';
                // Add AI response to context for frontend
                $conversationContext[] = "Assistant: " . $aiResponse;
                if (count($conversationContext) > 4) {
                    array_shift($conversationContext);
                }
                return response()->json([
                    'message' => $aiResponse,
                    'destinations' => $destinations,
                    'context' => $conversationContext,
                    'language' => $language
                ]);
            }
            return response()->json([
                'message' => 'Sorry, I encountered an error while processing your request.',
                'destinations' => [],
                'context' => $conversationContext,
                'language' => $language
            ], 500);
        } catch (\Exception $e) {
            \Log::error('AI Assistant Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Sorry, I encountered an error while processing your request.',
                'destinations' => [],
                'context' => [],
                'language' => 'en'
            ], 500);
        }
    }

    private function getRelevantDestinations($message)
    {
        $query = Destination::query();

        // Search in title and description
        $keywords = explode(' ', strtolower($message));
        foreach ($keywords as $keyword) {
            if (strlen($keyword) > 3) { // Only search for words longer than 3 characters
                $query->orWhere(function($q) use ($keyword) {
                    $q->whereRaw('LOWER(title) LIKE ?', ['%' . $keyword . '%'])
                      ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $keyword . '%']);
                });
            }
        }

        // Get up to 3 most relevant destinations
        return $query->take(3)->get();
    }
} 