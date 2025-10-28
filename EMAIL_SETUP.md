# Email Notification Setup Guide

## ✅ What's Implemented

The system now sends automatic email notifications for:

1. **User Registration** → "Registration Pending" email
2. **Admin Approval** → "Account Approved - You Can Now Login!" email
3. **Admin Rejection** → "Registration Status Update" email

---

## 🚀 Quick Setup (Using Gmail)

### Step 1: Enable 2-Factor Authentication on Gmail

1. Go to your Google Account: https://myaccount.google.com/
2. Click on **Security** (left sidebar)
3. Enable **2-Step Verification**

### Step 2: Generate App Password

1. Still in **Security** settings
2. Search for **App passwords**
3. Select **Mail** as the app
4. Select **Other** as the device (name it: "Laravel App")
5. Click **Generate**
6. Copy the 16-character password (e.g., `abcd efgh ijkl mnop`)

### Step 3: Update .env File

Open your `.env` file and update these settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Your App Name"
```

**Replace:**
- `youremail@gmail.com` → Your actual Gmail address
- `your-16-char-app-password` → The app password from Step 2 (remove spaces)
- `noreply@yourdomain.com` → The "from" email address
- `Your App Name` → Your application name

### Step 4: Clear Config Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 5: Test It!

1. Register a new user
2. Check the user's email inbox
3. Approve/Reject from admin panel
4. Check email again for status notification

---

## 📧 Email Templates

### 1. Registration Pending Email
**Sent:** When user registers
**Subject:** Registration Pending - Awaiting Approval
**Content:**
- Welcome message
- Registration details
- Pending status notification
- Wait for approval instruction

### 2. Account Approved Email
**Sent:** When admin approves user
**Subject:** Account Approved - You Can Now Login!
**Content:**
- Approval confirmation
- Login button
- Account details
- Login link

### 3. Registration Rejected Email
**Sent:** When admin rejects user
**Subject:** Registration Status Update
**Content:**
- Rejection notification
- Contact support button
- Account details

---

## 🎨 Email Features

- ✅ Beautiful HTML templates
- ✅ Responsive design
- ✅ Color-coded (Pending=Yellow, Approved=Green, Rejected=Red)
- ✅ Professional layout
- ✅ Animated icons
- ✅ Clear call-to-action buttons
- ✅ Company branding

---

## 🔧 Alternative Email Services

### Option 1: Mailtrap (For Testing)
Free email testing service - emails won't actually send, just captured for testing.

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

Get credentials from: https://mailtrap.io/

### Option 2: Log (For Development)
Emails are written to log file instead of being sent.

```env
MAIL_MAILER=log
```

Check emails in: `storage/logs/laravel.log`

### Option 3: SendGrid, Mailgun, or other SMTP services
Configure according to your service provider's documentation.

---

## 🐛 Troubleshooting

### Error: "Failed to authenticate on SMTP server"
- ✅ Make sure you're using an **App Password**, not your regular Gmail password
- ✅ Enable 2-Factor Authentication first
- ✅ Remove all spaces from the app password

### Error: "Could not instantiate mail function"
- ✅ Make sure your server has mail sending capabilities
- ✅ Try using Mailtrap for testing instead

### Emails Not Sending
1. Check your `.env` configuration
2. Run: `php artisan config:clear`
3. Check `storage/logs/laravel.log` for errors
4. Verify Gmail App Password is correct

### Emails Going to Spam
- Use a proper "from" address
- Configure SPF and DKIM records (for production)
- Use a verified domain

---

## 📝 Testing Checklist

- [ ] User registers → Receives "Pending" email
- [ ] Admin approves → User receives "Approved" email
- [ ] Admin rejects → User receives "Rejected" email
- [ ] All emails display correctly
- [ ] Links in emails work
- [ ] Emails have proper sender name

---

## 🎯 What Happens When

### User Registers:
1. User fills registration form
2. Account created with "pending" status
3. **Email sent:** "Registration Pending"
4. User sees success modal

### Admin Approves:
1. Admin clicks "Approve" button
2. User status changed to "approved"
3. **Email sent:** "Account Approved"
4. Admin sees success message

### Admin Rejects:
1. Admin clicks "Reject" button
2. User status changed to "rejected"
3. **Email sent:** "Registration Status Update"
4. Admin sees success message

---

## 🔒 Security Notes

- ✅ Never commit `.env` file to Git
- ✅ Use App Passwords, not regular passwords
- ✅ Keep credentials secure
- ✅ Use environment variables
- ✅ Enable 2FA on email accounts

---

## 📂 Files Created

- `app/Mail/UserRegistrationPending.php`
- `app/Mail/UserApproved.php`
- `app/Mail/UserRejected.php`
- `resources/views/emails/registration-pending.blade.php`
- `resources/views/emails/user-approved.blade.php`
- `resources/views/emails/user-rejected.blade.php`

---

## ✨ Ready to Use!

Once you configure your email settings, the system will automatically send emails for all registration events!

For testing without sending real emails, use `MAIL_MAILER=log` in your `.env` file.
