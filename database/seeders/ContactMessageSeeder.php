<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Yousef Al-Ghamdi', 'email' => 'yousef.ghamdi@example.com',
                'subject' => 'Timeline for a 3,000 sqm retail fit-out',
                'message' => 'We are opening a new retail location and need a rough timeline estimate before committing to a lease. Could someone reach out this week?',
                'status' => 'new',
            ],
            [
                'name' => 'Dana Khalil', 'email' => 'dana.khalil@example.com',
                'subject' => 'Question about the client portal',
                'message' => 'I submitted a quote request last month — is there a way to check its status without waiting for an email?',
                'status' => 'replied',
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::updateOrCreate(['email' => $message['email'], 'subject' => $message['subject']], $message);
        }
    }
}