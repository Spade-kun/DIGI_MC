<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\UserRegistrationPending;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email sending functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? config('mail.from.address');
        
        $this->info("Testing email configuration...");
        $this->info("Sending test email to: {$email}");
        
        try {
            // Create a test user object
            $testUser = new User([
                'name' => 'Test User',
                'email' => $email,
                'created_at' => now()
            ]);
            
            Mail::to($email)->send(new UserRegistrationPending($testUser));
            
            $this->info("✅ Email sent successfully!");
            $this->info("Check your inbox at: {$email}");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email!");
            $this->error("Error: " . $e->getMessage());
            $this->error("\nPlease check:");
            $this->error("1. MAIL_MAILER is set to 'smtp' in .env");
            $this->error("2. MAIL_USERNAME and MAIL_PASSWORD are correct");
            $this->error("3. Gmail 'App Password' is being used (not regular password)");
            $this->error("4. 'Less secure app access' is enabled or using App Password");
            
            return 1;
        }
    }
}
