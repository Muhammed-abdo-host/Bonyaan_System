<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientPortalController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()
            ->projects()
            ->with([
                'siteUpdates' => fn ($query) => $query->latest(),
            ])
            ->latest()
            ->get();

        return view('client', compact('projects'));
    }

    public function storeProjectRequest(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['villa', 'office', 'mall', 'warehouse'])],
            'location' => ['nullable', 'string', 'max:255'],
            'area' => ['required', 'numeric', 'min:1'],
            'floors' => ['nullable', 'integer', 'min:1'],
            'budget' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Client requests always start as "pending" — status, progress_percent
        // and image are managed exclusively by the admin after acceptance.
        $project = Project::create([
            'client_id' => $request->user()->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'location' => $validated['location'] ?? null,
            'area' => $validated['area'],
            'floors' => $validated['floors'] ?? 1,
            'status' => 'pending',
            'progress_percent' => 0,
            'budget' => $validated['budget'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Your project request has been submitted and is awaiting review.',
            'project' => $project,
        ], 201);
    }
}
