<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Services\RecaptchaVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request, RecaptchaVerifier $recaptcha): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'recaptcha_token' => [$recaptcha->isConfigured() ? 'required' : 'nullable', 'string'],
        ]);

        if (! $recaptcha->verify($request->input('recaptcha_token'), 'contact_submit')) {
            return response()->json([
                'message' => 'فشل التحقق الأمني، من فضلك أعد المحاولة.',
            ], 422);
        }

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        try {
            Mail::to($lead->email)->send(new QuoteConfirmation($lead));

            Mail::to(config('services.bonyaan.quote_notification_email'))
                ->send(new NewQuoteNotification($lead));
        } catch (\Throwable $e) {
            Log::error('Failed to send quote emails: '.$e->getMessage());
        }

        return response()->json([
            'message' => 'Your message has been sent successfully. Our team will contact you shortly.',
            'contact_message_id' => $contactMessage->id,
        ], 201);
    }
}
