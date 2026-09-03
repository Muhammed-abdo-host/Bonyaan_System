<?php

namespace App\Http\Controllers;

use App\Models\JobApplicant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'position' => ['required', 'string', 'max:255'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

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