<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DialogflowController extends Controller
{
    /**
     * Handle Dialogflow webhook requests
     */
    public function handleMessage(Request $request)
    {
        try {
            $userMessage = $request->input('message');
            $sessionId = $request->input('sessionId');
            
            if (!$userMessage) {
                return response()->json([
                    'success' => false,
                    'response' => 'Please provide a message.'
                ], 400);
            }

            // Get Dialogflow credentials from environment
            $projectId = env('DIALOGFLOW_PROJECT_ID');
            $credentials = env('DIALOGFLOW_CREDENTIALS_PATH');
            
            if (!$projectId) {
                // Return a helpful response if Dialogflow is not configured
                return response()->json([
                    'success' => true,
                    'response' => $this->getDefaultResponse($userMessage)
                ]);
            }

            // Here you would integrate with Dialogflow API
            // For now, we'll return default responses
            $response = $this->getDefaultResponse($userMessage);
            
            return response()->json([
                'success' => true,
                'response' => $response
            ]);

        } catch (\Exception $e) {
            Log::error('Dialogflow Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'response' => 'Sorry, I encountered an error. Please try again.'
            ], 500);
        }
    }

    /**
     * Get default response based on user message
     * This is a fallback when Dialogflow is not configured
     */
    private function getDefaultResponse($message)
    {
        $message = strtolower($message);
        
        // Check for greetings
        if (preg_match('/\b(hello|hi|hey|greetings)\b/', $message)) {
            return "Hello! 👋 I'm your virtual assistant. How can I help you today?";
        }
        
        // Check for document-related queries
        if (preg_match('/\b(document|documents|file|files)\b/', $message)) {
            return "You can find all your documents in the Documents section of your dashboard. You can view, download, and manage your documents there. Would you like to know anything specific about documents?";
        }
        
        // Check for gazette-related queries
        if (preg_match('/\b(gazette|gazettes|publication|publications)\b/', $message)) {
            return "The Gazette section contains official publications including Republic Acts, Proclamations, Memorandum Orders, and Contracts. You can browse and download any gazette document you need. Need help finding a specific gazette?";
        }
        
        // Check for help requests
        if (preg_match('/\b(help|assist|support|guide)\b/', $message)) {
            return "I can help you with:\n• 📄 Finding and managing documents\n• 📰 Browsing gazette publications\n• 🔍 Navigating the system\n• ❓ Answering general questions\n\nWhat would you like to know more about?";
        }
        
        // Check for navigation help
        if (preg_match('/\b(navigate|where|find|locate)\b/', $message)) {
            return "You can navigate through:\n• Dashboard - Your main overview\n• Documents - Access your personal documents\n• Gazette - Browse official publications\n\nIs there a specific section you'd like to visit?";
        }
        
        // Check for download queries
        if (preg_match('/\b(download|downloading|get|obtain)\b/', $message)) {
            return "To download a document or gazette:\n1. Go to the respective section (Documents or Gazette)\n2. Find the item you want\n3. Click the download button (📥)\n\nThe file will be downloaded to your device!";
        }
        
        // Check for account/profile queries
        if (preg_match('/\b(account|profile|user|settings)\b/', $message)) {
            return "Your account is currently active and you have access to all features. If you need to update your information or have account-related concerns, please contact the administrator.";
        }
        
        // Check for thank you
        if (preg_match('/\b(thank|thanks|appreciate)\b/', $message)) {
            return "You're welcome! 😊 Feel free to ask if you need anything else. I'm here to help!";
        }
        
        // Check for goodbye
        if (preg_match('/\b(bye|goodbye|see you|exit)\b/', $message)) {
            return "Goodbye! 👋 Have a great day! Feel free to reach out anytime you need assistance.";
        }
        
        // Default response
        return "I'm here to help! I can assist you with:\n• Finding documents and gazettes\n• Navigating the system\n• Answering your questions\n\nCould you please provide more details about what you need?";
    }

    /**
     * Integrate with actual Dialogflow API
     * Uncomment and configure this method when you have Dialogflow credentials
     */
    private function callDialogflowAPI($message, $sessionId)
    {
        try {
            $projectId = env('DIALOGFLOW_PROJECT_ID');
            $credentials = json_decode(file_get_contents(env('DIALOGFLOW_CREDENTIALS_PATH')), true);
            
            // Dialogflow ES REST API endpoint
            $url = "https://dialogflow.googleapis.com/v2/projects/{$projectId}/agent/sessions/{$sessionId}:detectIntent";
            
            // Get access token
            $accessToken = $this->getAccessToken($credentials);
            
            // Prepare request payload
            $payload = [
                'queryInput' => [
                    'text' => [
                        'text' => $message,
                        'languageCode' => 'en-US'
                    ]
                ]
            ];
            
            // Make API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($url, $payload);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['queryResult']['fulfillmentText'] ?? 'I did not understand that.';
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Dialogflow API Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get Google OAuth access token
     */
    private function getAccessToken($credentials)
    {
        // Implement OAuth2 token generation here
        // This is a simplified version - you may want to use a package like google/auth
        return null;
    }
}
