<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactMessageAdminController extends Controller
{
    /**
     * List all contact messages for the admin panel, newest first.
     */
    public function index(): JsonResponse
    {
        $messages = ContactMessage::latest()->get()->map(function (ContactMessage $message) {
            return [
                'id' => $message->id,
                'name' => $message->name,
                'email' => $message->email,
                'subject' => $message->subject,
                'message' => $message->message,
                'status' => $message->status,
                'date' => $message->created_at->format('Y-m-d H:i'),
            ];
        });

        return response()->json($messages);
    }

    /**
     * Update a contact message's status (new / read / replied / archived).
     */
    public function update(Request $request, ContactMessage $message): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['new', 'read', 'replied', 'archived'])],
        ]);

        $message->update($validated);

        return response()->json([
            'message' => "Message #{$message->id} status updated to {$message->status}.",
            'contact_message' => $message,
        ]);
    }
}