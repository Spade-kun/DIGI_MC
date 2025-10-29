# Google Drive Setup for Document Upload

This guide will help you set up Google Drive API to enable automatic document uploads.

## Prerequisites

1. A Google account with access to Google Cloud Console
2. The target Google Drive folder where documents will be uploaded

## Step-by-Step Setup

### 1. Create a Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Note down your Project ID

### 2. Enable Google Drive API

1. In the Google Cloud Console, go to **APIs & Services** > **Library**
2. Search for "Google Drive API"
3. Click on it and press **Enable**

### 3. Create Service Account Credentials

1. Go to **APIs & Services** > **Credentials**
2. Click **Create Credentials** > **Service Account**
3. Fill in the service account details:
   - Name: `Document Upload Service`
   - Description: `Service account for uploading documents to Google Drive`
4. Click **Create and Continue**
5. Skip the optional steps and click **Done**

### 4. Generate JSON Key

1. In the **Credentials** page, find your newly created service account
2. Click on the service account email
3. Go to the **Keys** tab
4. Click **Add Key** > **Create new key**
5. Select **JSON** format
6. Click **Create** - a JSON file will be downloaded

### 5. Install the JSON Key

1. Rename the downloaded file to `credentials.json`
2. Create the directory: `storage/app/google/` in your Laravel project
3. Move `credentials.json` to `storage/app/google/credentials.json`

### 6. Share Google Drive Folder with Service Account

1. Open the JSON file and find the `client_email` field (looks like: `xxx@xxx.iam.gserviceaccount.com`)
2. Go to your Google Drive folder: https://drive.google.com/drive/folders/1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH
3. Right-click the folder and select **Share**
4. Add the service account email (from step 1)
5. Give it **Editor** permissions
6. Uncheck "Notify people" (since it's a service account)
7. Click **Share**

### 7. Update Environment Variables

Add this to your `.env` file:

```env
GOOGLE_CREDENTIALS_PATH=storage/app/google/credentials.json
```

### 8. Install Required PHP Libraries

Run this command in your terminal:

```bash
composer require google/apiclient
```

## Testing

1. Go to the admin dashboard
2. Navigate to **Documents** page
3. Click **Add Document**
4. Fill in the form and upload a PDF file
5. After submission, check:
   - The document appears in the table
   - The document has a cloud icon (indicating Google Drive upload)
   - The document appears in your Google Drive folder

## Troubleshooting

### "Google credentials not found" error
- Make sure `credentials.json` exists in `storage/app/google/`
- Check file permissions

### "Permission denied" when uploading to Drive
- Make sure you shared the folder with the service account email
- Give the service account "Editor" access

### File uploads but doesn't appear in Drive
- Check if the service account has access to the folder
- Verify the folder ID in the controller is correct: `1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH`

### File size too large
- Maximum file size is 10MB
- Adjust in controller if needed

## Security Notes

- Never commit `credentials.json` to version control
- Add `storage/app/google/` to `.gitignore`
- Keep your service account credentials secure
- Regularly rotate credentials if compromised

## Optional: Without Google Drive

If you don't want to use Google Drive, the documents will still be saved locally in `storage/app/public/admin_documents/`. The application will continue to work, just without the automatic cloud backup.
