# Google OAuth Setup Instructions

## Step 1: Create Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API:
   - Go to "APIs & Services" > "Library"
   - Search for "Google+ API"
   - Click "Enable"

4. Create OAuth 2.0 Credentials:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth client ID"
   - Select "Web application"
   - Add authorized redirect URIs:
     - `http://127.0.0.1:8000/auth/google/callback`
     - `http://localhost:8000/auth/google/callback`
   - Click "Create"

5. Copy your Client ID and Client Secret

## Step 2: Update .env File

Open your `.env` file and update these values:

```env
GOOGLE_CLIENT_ID=your-client-id-here
GOOGLE_CLIENT_SECRET=your-client-secret-here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

## Step 3: Clear Configuration Cache

Run this command:

```bash
php artisan config:clear
```

## Step 4: Test the Integration

1. Start your user server: `php -S 127.0.0.1:8000 server-user.php`
2. Visit: `http://127.0.0.1:8000/user/login`
3. Click "Sign in with Google"
4. Authenticate with Google
5. You will be logged in if your account is approved

## How It Works

1. User clicks "Sign in with Google"
2. User is redirected to Google's authentication page
3. User grants permission
4. Google redirects back to your app with user info
5. System checks if the email exists in database
6. System checks if the account status is "approved"
7. If approved, user is logged in
8. If not approved, user sees an error message

## Status Messages

- **Not Registered**: "Your email is not registered. Please register first or contact admin."
- **Pending Approval**: "Your account is pending approval. Please wait for admin approval."
- **Rejected**: "Your registration has been rejected. Please contact admin for more information."
- **Success**: User is logged in and redirected to dashboard

## Important Notes

- Only users with "approved" status can login
- Users must register first before they can login with Google
- The email used for Google login must match the registered email
- Admin must approve the user registration before they can login
