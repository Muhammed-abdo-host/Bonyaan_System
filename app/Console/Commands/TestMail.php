<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature = 'mail:test {email : The address to send the test email to}';
    protected $description = 'Send a simple test email to verify the current mail configuration is working';

    public function handle(): int
    {
        $to = $this->argument('email');

        $this->info("Sending test email via [" . config('mail.default') . "] to {$to}...");

        try {
            Mail::raw(
                'This is a test email from the Bonyaan platform to confirm your mail configuration is working correctly.',
                function ($message) use ($to) {
                    $message->to($to)->subject('Bonyaan Mail Configuration Test');
                }
            );

            $this->info('✅ Sent successfully. Check the inbox (and spam folder) for ' . $to);
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('❌ Failed to send: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}