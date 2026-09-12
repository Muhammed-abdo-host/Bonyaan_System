<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::where('email', 'admin@bonyaan.test')->value('id');

        $posts = [
            [
                'title' => 'Why Post-Tension Slabs Are Changing High-Rise Construction',
                'category' => 'Engineering',
                'excerpt' => 'Post-tension slab systems are cutting material costs and floor-to-floor heights on our latest residential towers. Here is how the technique works and when it makes sense.',
                'content' => "Post-tension (PT) slab construction has become one of the most requested engineering solutions on our residential and commercial projects over the past three years.\n\nUnlike conventional reinforced concrete slabs, PT slabs use high-strength steel tendons that are tensioned after the concrete cures, actively compressing the slab and allowing for longer spans with less material.\n\nOn a recent 14-story residential tower, switching to a PT slab system reduced structural concrete volume by roughly 18% and shaved 120mm off every floor-to-floor height — across 14 floors, that added an entire extra level within the same building envelope.\n\nThe trade-off is specialized labor: PT slabs require certified tensioning crews and tighter quality control during the pour. For projects over 6 stories with repetitive floor plates, the savings in material and schedule consistently outweigh the added supervision cost.",
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'A Client\'s Guide to Reading Your Site Progress Reports',
                'category' => 'Client Resources',
                'excerpt' => 'Every project on our Client Portal gets phase-by-phase photo updates. This guide explains what each construction phase means and what to look for in the photos.',
                'content' => "One of the most common questions we get from first-time clients is: \"What am I actually looking at in these progress photos?\" This guide breaks down our four tracked phases.\n\n**Excavation** — Site clearing, soil testing, and foundation trenching. Photos here show equipment and open trenches; there is no visible structure yet, which is normal and typically the shortest phase.\n\n**Structure** — Reinforced concrete or steel framing rises floor by floor. This is usually the longest phase and the one where schedule variance is most visible.\n\n**MEP (Mechanical, Electrical, Plumbing)** — Conduits, ducting, and piping are installed inside the completed structure, before walls are closed up. Photos often look messier here — that is expected, not a sign of a problem.\n\n**Finishing** — Flooring, paint, fixtures, and final inspections. This phase determines the handover date.\n\nEach update in your portal is timestamped and tied to a specific phase, so you can track pace against the original timeline estimate from your quote.",
                'image' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(4),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'author_id' => $authorId,
                    'title' => $post['title'],
                    'category' => $post['category'],
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'image_path' => $post['image'],
                    'published_at' => $post['published_at'],
                ]
            );
        }
    }
}
