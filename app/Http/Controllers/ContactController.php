<?php

namespace App\Http\Controllers;

use App\Mail\ContactConfirmation;
use App\Mail\NewContactNotification;
use App\Models\ContactMessage;
use App\Services\RecaptchaVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
  public function store(Request $request, RecaptchaVerifier $recaptcha)
{
    $validated = $request->validate([
        // ... باقي قواعد الفاليديشن الموجودة عندك
        'recaptcha_token' => ['required', 'string'],
    ]);

    if (! $recaptcha->verify($request->input('recaptcha_token'), 'contact_submit')) {
        return response()->json([
            'message' => 'فشل التحقق الأمني، من فضلك أعد المحاولة.',
        ], 422);
    }

    // ... باقي منطق الحفظ/الإرسال زي ما هو
}
}