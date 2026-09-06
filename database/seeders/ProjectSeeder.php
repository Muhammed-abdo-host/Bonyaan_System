<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $client = User::where('email', 'client@bonyaan.test')->first();
        if (!$client) {
            return;
        }

        $projects = [
            [
                'client_id' => $client->id,
                'name' => 'Al Reem Tower Complex',
                'type' => 'office',
                'location' => 'Riyadh, KSA',
                'area' => 45000,
                'floors' => 32,
                'status' => 'completed',
                'progress_percent' => 100,
                'budget' => '$28,000,000',
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800',
                'description' => 'A 32-story mixed-use office tower featuring sustainable glass facade systems and smart building automation.',
            ],
            [
                'client_id' => $client->id,
                'name' => 'Marina Bay Villas',
                'type' => 'villa',
                'location' => 'Dubai, UAE',
                'area' => 12000,
                'floors' => 3,
                'status' => 'ongoing',
                'progress_percent' => 85,
                'budget' => '$15,000,000',
                'image' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800',
                'description' => 'Luxury waterfront villa community with private pools, landscaped gardens, and premium Italian marble finishes.',
            ],
            [
                'client_id' => $client->id,
                'name' => 'Grand Horizon Mall',
                'type' => 'mall',
                'location' => 'Jeddah, KSA',
                'area' => 85000,
                'floors' => 4,
                'status' => 'ongoing',
                'progress_percent' => 60,
                'budget' => '$62,000,000',
                'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=800',
                'description' => 'A premier retail and entertainment destination spanning 85,000 sq.m with over 200 retail outlets and cinema complex.',
            ],
            [
                'client_id' => $client->id,
                'name' => 'Falcon Logistics Hub',
                'type' => 'warehouse',
                'location' => 'Dammam, KSA',
                'area' => 60000,
                'floors' => 1,
                'status' => 'completed',
                'progress_percent' => 100,
                'budget' => '$18,000,000',
                'image' => 'https://images.unsplash.com/photo-1553413077-190dd305871c?w=800',
                'description' => 'State-of-the-art logistics and distribution facility with automated warehousing systems and heavy concrete slab foundations.',
            ],
        ];

        foreach ($projects as $data) {
            Project::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}