<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\QuoteAttachment;
use Illuminate\Support\Facades\Storage;

class LeadAdminController extends Controller
{
    /**
     * List all leads for the CRM Leads admin panel, newest first.
     */
 public function index(): JsonResponse
{
    $leads = Lead::with('attachments')
        ->latest()
        ->get()
        ->map(function (Lead $lead) {
            return [
                'id' => $lead->id,
                'name' => $lead->name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'location' => $lead->location,
                'projectType' => ucfirst($lead->building_type),
                'area' => $lead->area ? number_format($lead->area) . ' sq.m' : '—',
                'budget' => $lead->estimated_cost ? '$' . number_format($lead->estimated_cost) : '—',
                'status' => $lead->status,
                'date' => $lead->created_at->format('Y-m-d'),
                'notes' => $lead->notes,

                'attachments' => $lead->attachments->map(fn (QuoteAttachment $attachment) => [
                    'id' => $attachment->id,
                    'name' => $attachment->original_name,
                    'size' => $attachment->size,
                    'mime_type' => $attachment->mime_type,
                    'download_url' => route('admin.attachments.download', $attachment),
                ])->values(),
            ];
        });

    return response()->json($leads);
}

    /**
     * Update a lead's status from the CRM dropdown.
     */
    public function update(Request $request, Lead $lead): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['new', 'contacted', 'converted', 'rejected'])],
        ]);

        $lead->update($validated);

        return response()->json([
            'message' => "Lead #{$lead->id} status updated to {$lead->status}.",
            'lead' => $lead,
        ]);
    }
    public function downloadAttachment(QuoteAttachment $attachment)
{
    abort_unless(
        Storage::disk('local')->exists($attachment->path),
        404,
        'Attachment file not found.'
    );

    return Storage::disk('local')->download(
        $attachment->path,
        $attachment->original_name,
        [
            'Content-Type' => $attachment->mime_type,
        ]
    );
}
}