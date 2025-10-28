# Dialogflow Chatbot Integration Guide

## Overview
This application includes a fully functional chatbot widget that appears on all user pages. The chatbot uses Dialogflow for natural language processing and can be customized to answer specific questions about your application.

## Features
- ✅ Fixed position in lower right corner
- ✅ Smooth animations and hover effects
- ✅ Unread message notifications
- ✅ Typing indicators
- ✅ Responsive design (mobile-friendly)
- ✅ User-friendly interface
- ✅ Default fallback responses (works without Dialogflow initially)

## Current Status
The chatbot is **fully functional** with default responses. It will work immediately without any additional configuration. To enable advanced AI-powered responses with Dialogflow, follow the setup instructions below.

## Quick Start (No Configuration Needed)
The chatbot is already integrated and will appear on all user pages with intelligent default responses. Users can:
- Ask about documents and gazettes
- Get help navigating the system
- Ask general questions
- Get immediate responses without waiting

## Setup Dialogflow (Optional - For Advanced AI Features)

### Step 1: Create a Dialogflow Account
1. Go to [Dialogflow Console](https://dialogflow.cloud.google.com/)
2. Sign in with your Google account
3. Accept the terms of service

### Step 2: Create a New Agent
1. Click "Create Agent"
2. Enter agent details:
   - **Agent name**: DG_MC Support Bot
   - **Default language**: English
   - **Default time zone**: Your timezone
3. Click "CREATE"

### Step 3: Create Intents

#### Intent 1: Greeting
- **Training phrases**:
  - Hi
  - Hello
  - Hey there
  - Good morning
  - Greetings
- **Response**:
  - "Hello! 👋 I'm your virtual assistant. How can I help you today?"

#### Intent 2: Document Help
- **Training phrases**:
  - How do I access documents?
  - Where are my documents?
  - I need help with documents
  - Show me documents
  - Find my files
- **Response**:
  - "You can find all your documents in the Documents section of your dashboard. You can view, download, and manage your documents there. Would you like to know anything specific about documents?"

#### Intent 3: Gazette Help
- **Training phrases**:
  - What is a gazette?
  - Show me gazettes
  - Where are the publications?
  - I need gazette documents
  - Republic acts
- **Response**:
  - "The Gazette section contains official publications including Republic Acts, Proclamations, Memorandum Orders, and Contracts. You can browse and download any gazette document you need. Need help finding a specific gazette?"

#### Intent 4: Navigation Help
- **Training phrases**:
  - How do I navigate?
  - Where can I go?
  - Show me around
  - What sections are available?
  - Help me find something
- **Response**:
  - "You can navigate through: Dashboard, Documents, and Gazette sections. Is there a specific section you'd like to visit?"

#### Intent 5: Download Help
- **Training phrases**:
  - How do I download?
  - Download a file
  - Get a document
  - Save to my computer
- **Response**:
  - "To download: 1. Go to Documents or Gazette section. 2. Find the item you want. 3. Click the download button. The file will be saved to your device!"

### Step 4: Get Dialogflow Credentials

#### For Dialogflow ES (Essentials):
1. Go to your agent settings (gear icon)
2. Note your **Project ID**
3. Click on the service account email
4. This will take you to Google Cloud Console
5. Go to "Keys" tab
6. Click "Add Key" → "Create new key"
7. Select JSON format
8. Download the JSON file
9. Save it securely (e.g., `storage/app/dialogflow/credentials.json`)

### Step 5: Configure Environment Variables
Add these to your `.env` file:

```env
# Dialogflow Configuration
DIALOGFLOW_PROJECT_ID=your-project-id-here
DIALOGFLOW_CREDENTIALS_PATH=storage/app/dialogflow/credentials.json
```

### Step 6: Install Required Package (If using Dialogflow API directly)
```bash
composer require google/cloud-dialogflow
```

### Step 7: Update DialogflowController
The controller at `app/Http/Controllers/Api/DialogflowController.php` is ready to use. When you configure the environment variables, it will automatically switch from default responses to Dialogflow API calls.

## Configuration Options

### Customizing the Chatbot Appearance
Edit `resources/views/components/chatbot.blade.php`:

```css
/* Change chatbot colors */
background: linear-gradient(310deg, #7928CA 0%, #FF0080 100%);

/* Change position */
.chatbot-widget {
    bottom: 20px;  /* Adjust vertical position */
    right: 20px;   /* Adjust horizontal position */
}

/* Change size */
.chatbot-window {
    width: 380px;   /* Adjust width */
    height: 550px;  /* Adjust height */
}
```

### Customizing Default Responses
Edit the `getDefaultResponse()` method in `app/Http/Controllers/Api/DialogflowController.php` to add more keyword matches or change responses.

## Testing the Chatbot

### Without Dialogflow (Current Setup):
1. Log in as a regular user (not admin)
2. Navigate to any page (Dashboard, Documents, or Gazette)
3. Look for the chatbot icon in the lower right corner
4. Click the icon to open the chat window
5. Try these test messages:
   - "Hello"
   - "Help me with documents"
   - "Where are the gazettes?"
   - "How do I download?"

### With Dialogflow (After Setup):
1. Configure Dialogflow credentials as described above
2. The chatbot will automatically use Dialogflow API
3. Responses will be powered by AI
4. You can train it with more intents and phrases

## Troubleshooting

### Chatbot doesn't appear:
- Make sure you're logged in as a regular user (not admin)
- Clear browser cache and refresh
- Check browser console for JavaScript errors

### Chatbot appears but doesn't respond:
- Check if the `/api/dialogflow` route is accessible
- Verify CSRF token is present in the page
- Check Laravel logs: `storage/logs/laravel.log`

### Dialogflow integration not working:
- Verify Project ID is correct
- Check credentials file path and permissions
- Ensure credentials file is valid JSON
- Check API is enabled in Google Cloud Console

## Security Considerations

1. **Credentials**: Never commit Dialogflow credentials to version control
2. **CSRF Protection**: All requests include CSRF token
3. **Authentication**: Chatbot only appears for authenticated users
4. **Rate Limiting**: Consider adding rate limiting to the API endpoint

## Advanced Features (Future Enhancements)

### Possible Improvements:
- Add conversation history storage
- Implement user feedback system
- Add rich media responses (images, buttons)
- Create analytics dashboard
- Add multi-language support
- Integrate with more services (email, notifications)

## API Endpoint Details

### POST /api/dialogflow
**Request:**
```json
{
    "message": "How do I download documents?",
    "sessionId": "user-123-1234567890"
}
```

**Response:**
```json
{
    "success": true,
    "response": "To download a document..."
}
```

## Browser Support
- ✅ Chrome (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ✅ Mobile browsers

## Files Structure
```
app/
└── Http/
    └── Controllers/
        └── Api/
            └── DialogflowController.php

resources/
└── views/
    ├── components/
    │   └── chatbot.blade.php
    └── layouts/
        └── dashboard.blade.php

routes/
└── web.php (contains /api/dialogflow route)

storage/
└── app/
    └── dialogflow/
        └── credentials.json (not included, create this)
```

## Support & Maintenance
For issues or questions:
1. Check Laravel logs
2. Check browser console
3. Verify Dialogflow agent is working in Dialogflow Console
4. Test API endpoint directly using Postman

## Notes
- The chatbot is **already working** with smart default responses
- Dialogflow integration is **optional** for advanced AI features
- No external dependencies are required for basic functionality
- The chatbot is **responsive** and works on all devices
- Admin users will not see the chatbot (by design)
