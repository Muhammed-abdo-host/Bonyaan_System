<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
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

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', Rule::in(['villa', 'office', 'mall', 'warehouse'])],
            'location' => ['sometimes', 'nullable', 'string', 'max:255'],
            'area' => ['sometimes', 'numeric', 'min:1'],
            'floors' => ['sometimes', 'integer', 'min:1'],
            'status' => ['sometimes', Rule::in(['pending', 'ongoing', 'completed'])],
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
