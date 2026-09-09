<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;
    #[DataProvider('publicPageUrls')]
    public function test_public_pages_are_available(string $url): void
    {
        $this->get($url)->assertOk();
    }

    public static function publicPageUrls(): array
    {
        return array_map(static fn (string $url): array => [$url], [
            '/', '/about', '/contact', '/services', '/projects', '/estimator', '/quote', '/blog', '/login',
        ]);
    }

    public function test_estimator_returns_the_expected_quote(): void
    {
        $this->postJson('/estimator/calculate', [
            'area' => 100,
            'floors' => 1,
            'type' => 'villa',
            'tier' => 'standard',
            'extras' => ['pool'],
        ])->assertOk()->assertExactJson([
            'total' => 95000,
            'cost_per_sqm' => 950,
            'estimated_months' => 6,
            'breakdown' => [
                'structure' => 38000,
                'finishes' => 42750,
                'mep' => 14250,
            ],
        ]);
    }

    public function test_estimator_rejects_invalid_input(): void
    {
        $this->postJson('/estimator/calculate', [
            'area' => 99,
            'floors' => 0,
            'type' => 'invalid',
            'tier' => 'invalid',
            'extras' => ['invalid'],
        ])->assertUnprocessable()->assertJsonValidationErrors([
            'area', 'floors', 'type', 'tier', 'extras.0',
        ]);
    }
}
