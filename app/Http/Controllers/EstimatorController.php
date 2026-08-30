<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EstimatorController extends Controller
{
    /** Base cost per square meter by building type (USD) — from app.js baseRates */
    private const BASE_RATE = [
        'villa' => 600,
        'office' => 800,
        'mall' => 950,
        'warehouse' => 420,
    ];

    /** Finishing tier multiplier — from app.js finishingMultipliers */
    private const TIER_MULTIPLIER = [
        'standard' => 1.0,
        'deluxe' => 1.35,
        'ultra' => 1.75,
    ];

    /** Extra feature flat costs — from app.js extrasTotal logic */
    private const EXTRA_COSTS = [
        'pool' => 35000,
        'smart' => 25000,
        'solar' => 20000,
        'landscape' => 15000,
    ];

    public function calculate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'area' => ['required', 'numeric', 'min:100', 'max:10000'],
            'floors' => ['required', 'integer', 'min:1', 'max:30'],
            'type' => ['required', Rule::in(array_keys(self::BASE_RATE))],
            'tier' => ['required', Rule::in(array_keys(self::TIER_MULTIPLIER))],
            'extras' => ['array'],
            'extras.*' => [Rule::in(array_keys(self::EXTRA_COSTS))],
        ]);

        return response()->json($this->computeEstimate($validated));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'numeric', 'min:1'],
            'floors' => ['nullable', 'integer', 'min:1'],
            'tier' => ['nullable', 'string', 'max:255'],
            'extras' => ['array'],
            'budget' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $estimate = null;
        if (
            isset(self::BASE_RATE[$validated['type'] ?? null])
            && isset(self::TIER_MULTIPLIER[$validated['tier'] ?? null])
        ) {
            $estimate = $this->computeEstimate([
                'area' => $validated['area'] ?? 100,
                'floors' => $validated['floors'] ?? 1,
                'type' => $validated['type'],
                'tier' => $validated['tier'],
                'extras' => $validated['extras'] ?? [],
            ]);
        }

        $lead = Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'building_type' => $validated['type'] ?? 'unspecified',
            'area' => $validated['area'] ?? 0,
            'floors' => $validated['floors'] ?? 1,
            'finishing_tier' => $validated['tier'] ?? 'standard',
            'extras' => $validated['extras'] ?? [],
            'estimated_cost' => $estimate['total'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'new',
        ]);

        return response()->json([
            'message' => 'Quote proposal request submitted successfully! Our engineers will contact you.',
            'lead_id' => $lead->id,
        ], 201);
    }

    private function computeEstimate(array $data): array
    {
        $baseRate = self::BASE_RATE[$data['type']];
        $tierMultiplier = self::TIER_MULTIPLIER[$data['tier']];

        $extrasTotal = 0;
        foreach ($data['extras'] ?? [] as $extra) {
            $extrasTotal += self::EXTRA_COSTS[$extra] ?? 0;
        }

        $baseCostPerSqm = $baseRate * $tierMultiplier;
        $floorMultiplier = 1 + (($data['floors'] - 1) * 0.05);
        $areaCost = $data['area'] * $baseCostPerSqm * $floorMultiplier;

        $total = round($areaCost + $extrasTotal);
        $costPerSqm = round($total / $data['area']);
        $estimatedMonths = max(6, round(4 + ($data['floors'] * 1.5) + ($data['area'] > 2000 ? 4 : 0)));

        return [
            'total' => $total,
            'cost_per_sqm' => $costPerSqm,
            'estimated_months' => $estimatedMonths,
            'breakdown' => [
                'structure' => round($total * 0.40),
                'finishes' => round($total * 0.45),
                'mep' => round($total * 0.15),
            ],
        ];
    }
}