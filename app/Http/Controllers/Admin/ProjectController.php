<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::with('client')->latest()->get()->map(function (Project $project) {
            return [
                'id' => $project->id,
                'title' => $project->name,
                'category' => $project->type,
                'client' => $project->client?->name ?? '—',
                'location' => $project->location,
                'completion' => $project->progress_percent,
                'budget' => $project->budget,
                'image' => $project->image,
                'description' => $project->description,
                'status' => $project->status,
            ];
        });

        return response()->json($projects);
    }

    public function clients(): JsonResponse
    {
        $clientRoleId = Role::where('name', 'client')->value('id');

        $clients = User::where('role_id', $clientRoleId)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return response()->json($clients);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['villa', 'office', 'mall', 'warehouse'])],
            'location' => ['nullable', 'string', 'max:255'],
            'area' => ['required', 'numeric', 'min:1'],
            'floors' => ['nullable', 'integer', 'min:1'],
            'progress_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'budget' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'url', 'max:2048'],
            'description' => ['nullable', 'string'],
        ]);

        $project = Project::create([
            'client_id' => $validated['client_id'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'location' => $validated['location'] ?? null,
            'area' => $validated['area'],
            'floors' => $validated['floors'] ?? 1,
            'status' => 'ongoing',
            'progress_percent' => $validated['progress_percent'] ?? 0,
            'budget' => $validated['budget'] ?? null,
            'image' => $validated['image'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'New project published to CMS portfolio!',
            'project' => $project,
        ], 201);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', Rule::in(['villa', 'office', 'mall', 'warehouse'])],
            'location' => ['sometimes', 'nullable', 'string', 'max:255'],
            'area' => ['sometimes', 'numeric', 'min:1'],
            'floors' => ['sometimes', 'integer', 'min:1'],
            'status' => ['sometimes', Rule::in(['ongoing', 'completed'])],
            'progress_percent' => ['sometimes', 'integer', 'min:0', 'max:100'],
            'budget' => ['sometimes', 'nullable', 'string', 'max:255'],
            'image' => ['sometimes', 'nullable', 'url', 'max:2048'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);

        $project->update($validated);

        return response()->json([
            'message' => "Project #{$project->id} updated.",
            'project' => $project,
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message' => 'Project deleted from CMS.',
        ]);
    }
}