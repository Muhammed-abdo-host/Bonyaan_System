<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $leads = [
            [
                'name' => 'Khalid Al-Mutairi', 'email' => 'khalid.mutairi@example.com', 'phone' => '+965 6011 2233',
                'location' => 'Kuwait City', 'building_type' => 'villa', 'area' => 620, 'floors' => 2,
                'finishing_tier' => 'ultra', 'extras' => ['pool', 'smart'], 'estimated_cost' => 892400,
                'notes' => 'Wants construction to begin within Q1. Requested marble flooring throughout.',
                'status' => 'contacted',
            ],
            [
                'name' => 'Noura Al-Sabah', 'email' => 'noura.sabah@example.com', 'phone' => '+974 3344 5566',
                'location' => 'Doha', 'building_type' => 'office', 'area' => 1450, 'floors' => 6,
                'finishing_tier' => 'deluxe', 'extras' => ['smart', 'solar'], 'estimated_cost' => 1783000,
                'notes' => 'Corporate HQ for a logistics firm. Needs LEED-aligned specs.',
                'status' => 'converted',
            ],
            [
                'name' => 'Hassan Idris', 'email' => 'hassan.idris@example.com', 'phone' => '+20 122 334 4556',
                'location' => 'New Cairo', 'building_type' => 'warehouse', 'area' => 3200, 'floors' => 1,
                'finishing_tier' => 'standard', 'extras' => [], 'estimated_cost' => 1478000,
                'notes' => 'Cold storage requirements — awaiting site survey before confirming.',
                'status' => 'new',
            ],
        ];

        foreach ($leads as $lead) {
            Lead::updateOrCreate(['email' => $lead['email']], $lead);
        }
    }
}