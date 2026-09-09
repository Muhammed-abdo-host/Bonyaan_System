<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplicant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class HrAdminController extends Controller
{
    /**
     * List all job applicants, newest first.
     */
    public function index(): JsonResponse
    {
        $applicants = JobApplicant::latest()->get()->map(function (JobApplicant $applicant) {
            return [
                'id'       => $applicant->id,
                'name'     => $applicant->name,
                'email'    => $applicant->email,
                'phone'    => $applicant->phone,
                'position' => $applicant->position,
                'status'   => $applicant->status,
                'cv_url'   => $applicant->cv_path
                    ? route('admin.hr.cv.download', $applicant)
                    : null,
                'date'     => $applicant->created_at->format('Y-m-d'),
            ];
        });

        return response()->json($applicants);
    }

    /**
     * Update an applicant's recruitment stage.
     */
    public function update(Request $request, JobApplicant $applicant): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([
                'new',
                'reviewing',
                'interview',
                'hired',
                'rejected',
            ])],
        ]);

        $applicant->update($validated);

        return response()->json([
            'message'   => "Applicant #{$applicant->id} status updated to {$applicant->status}.",
            'applicant' => $applicant,
        ]);
    }

    /**
     * Download the applicant's CV file.
     */
    public function downloadCv(JobApplicant $applicant)
    {
        abort_unless(
            $applicant->cv_path && Storage::disk('local')->exists($applicant->cv_path),
            404,
            'CV file not found.'
        );

        return Storage::disk('local')->download(
            $applicant->cv_path,
            $applicant->name . '_CV.' . pathinfo($applicant->cv_path, PATHINFO_EXTENSION)
        );
    }
}