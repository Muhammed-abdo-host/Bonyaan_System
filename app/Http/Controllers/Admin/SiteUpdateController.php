<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\SiteUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class SiteUpdateController extends Controller
{
    private const PHASE_PROGRESS = [
    'excavation' => 25,
    'structure' => 50,
    'mep' => 75,
    'finishing' => 100,
];
    public function index(): JsonResponse
    {
        $updates = SiteUpdate::with('project:id,name')
            ->latest()
            ->get()
            ->map(fn (SiteUpdate $update) => $this->formatUpdate($update));

        return response()->json($updates);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'phase' => ['required', Rule::in([
                'excavation',
                'structure',
                'mep',
                'finishing',
            ])],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store(
                "site-updates/{$validated['project_id']}",
                'public'
            );
        }

        $update = SiteUpdate::create([
            'project_id' => $validated['project_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'phase' => $validated['phase'],
            'image_path' => $imagePath,
        ]);

        $update->load('project:id,name');
        $this->syncProjectProgress($update->project);

        return response()->json([
            'message' => 'Site update published successfully.',
            'update' => $this->formatUpdate($update),
        ], 201);
    }

public function destroy(SiteUpdate $siteUpdate): JsonResponse
{
    if ($siteUpdate->image_path) {
        Storage::disk('public')->delete($siteUpdate->image_path);
    }

    $project = $siteUpdate->project;
    $siteUpdate->delete();
    $this->syncProjectProgress($project);

    return response()->json([
        'message' => 'Site update deleted successfully.',
    ]);
}

    private function formatUpdate(SiteUpdate $update): array
    {
        return [
            'id' => $update->id,
            'project_id' => $update->project_id,
            'project_name' => $update->project?->name ?? 'Unknown project',
            'title' => $update->title,
            'description' => $update->description,
            'phase' => $update->phase,
            'image_url' => $update->image_path
                ? Storage::disk('public')->url($update->image_path)
                : null,
            'date' => $update->created_at->format('d M Y'),
        ];
    }
    private function syncProjectProgress(Project $project): void
{
    $highestPhaseValue = $project->siteUpdates()
        ->pluck('phase')
        ->map(fn (string $phase) => self::PHASE_PROGRESS[$phase] ?? 0)
        ->max();

    $project->update([
        'progress_percent' => $highestPhaseValue ?? 0,
    ]);
}
}