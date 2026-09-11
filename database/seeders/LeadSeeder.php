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
                'name' => 'Omar Khalid',
                'email' => 'omar.khalid@example.com',
                'phone' => '+966501112222',
                'location' => 'Riyadh, KSA',
                'building_type' => 'villa',
                'area' => 650,
                'floors' => 2,
                'finishing_tier' => 'deluxe',
                'extras' => ['pool', 'smart_home'],
                'estimated_cost' => 780000,
                'notes' => 'Looking to break ground in Q1. Needs a detailed structural drawing before signing.',
                'status' => 'new',
            ],
            [
                'name' => 'Layla Fathi',
                'email' => 'layla.fathi@example.com',
                'phone' => '+201122334455',
                'location' => 'New Cairo, Egypt',
                'building_type' => 'office',
                'area' => 1200,
                'floors' => 4,
                'finishing_tier' => 'standard',
                'extras' => [],
                'estimated_cost' => 540000,
                'notes' => 'Comparing quotes from two other contractors. Price-sensitive.',
                'status' => 'contacted',
            ],
            [
                'name' => 'Youssef Aziz',
                'email' => 'youssef.aziz@example.com',
                'phone' => '+971501234567',
                'location' => 'Dubai, UAE',
                'building_type' => 'warehouse',
                'area' => 3000,
                'floors' => 1,
                'finishing_tier' => 'standard',
                'extras' => ['solar'],
                'estimated_cost' => 410000,
                'notes' => 'Signed and converted to Falcon Logistics Hub project.',
                'status' => 'converted',
            ],
        ];

        foreach ($leads as $data) {
            Lead::updateOrCreate(
                ['email' => $data['email'], 'building_type' => $data['building_type']],
                $data
            );
        }
    }
}