<?php

namespace App\Http\Controllers;

use App\Models\JobApplicant;
use App\Services\RecaptchaVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function store(Request $request, RecaptchaVerifier $recaptcha): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'position' => ['required', 'string', 'max:255'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'recaptcha_token' => ['required', 'string'],
        ]);

        if (! $recaptcha->verify($request->input('recaptcha_token'), 'career_submit')) {
            return response()->json([
                'message' => 'فشل التحقق الأمني، من فضلك أعد المحاولة.',
            ], 422);
        }

        $cvPath = $request->file('cv')->store('cvs', 'local');

        $applicant = JobApplicant::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'cv_path' => $cvPath,
            'status' => 'new',
        ]);

        return response()->json([
            'message' => 'Your application has been submitted successfully! Our HR team will review it soon.',
            'applicant_id' => $applicant->id,
        ], 201);
    }
}