<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@bonyaan.test')->first();
        if (! $admin) {
            return;
        }

        $posts = [
            [
                'title' => 'How Concrete Curing Actually Works',
                'category' => 'Engineering',
                'excerpt' => 'Why the first 28 days after pouring concrete decide the strength of everything you build on top of it.',
                'content' => "Concrete doesn't just dry — it cures, through a chemical reaction called hydration between cement and water. Rushing this process is one of the most common (and costly) mistakes on a construction site.\n\nOur teams keep freshly poured concrete moist and within a controlled temperature range for at least seven days, with full strength typically reached around the 28-day mark. Skipping this step can quietly cut a structure's final strength by 30% or more, even if it looks fine on the surface.",
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => '5 Questions to Ask Before Choosing a Finishing Tier',
                'category' => 'Client Guide',
                'excerpt' => 'Standard, Deluxe, or Ultra Luxury — a practical guide to picking the right finish level for your budget.',
                'content' => "Finishing decisions are where most residential budgets quietly balloon. Before you pick a tier in our Cost Estimator, ask yourself:\n\n1. Is this a forever-home or a resale investment?\n2. Do you value low-maintenance materials over statement pieces?\n3. How much of the budget is flexible vs. fixed?\n4. Are you finishing all at once, or phasing rooms over time?\n5. Who else needs to approve the final look?\n\nMost of our clients land on Deluxe — it covers premium finishes without the long lead times that Ultra Luxury imports often require.",
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($posts as $data) {
            BlogPost::updateOrCreate(
                ['title' => $data['title']],
                [
                    'author_id' => $admin->id,
                    'slug' => str($data['title'])->slug(),
                    'category' => $data['category'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'image_path' => null,
                    'published_at' => $data['published_at'],
                ]
            );
        }
    }
}