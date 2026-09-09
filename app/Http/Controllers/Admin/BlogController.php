<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = BlogPost::with('author')->latest()->get()->map(function (BlogPost $post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'category' => $post->category,
                'excerpt' => $post->excerpt,
                'image' => $post->image_path,
                'author' => $post->author?->name ?? '—',
                'status' => $post->published_at ? 'published' : 'draft',
                'published_at' => $post->published_at?->format('Y-m-d'),
            ];
        });

        return response()->json($posts);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image_path' => ['nullable', 'url', 'max:2048'],
            'published' => ['nullable', 'boolean'],
        ]);

        $post = BlogPost::create([
            'author_id' => $request->user()->id,
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'category' => $validated['category'] ?? null,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'image_path' => $validated['image_path'] ?? null,
            'published_at' => ($validated['published'] ?? false) ? now() : null,
        ]);

        return response()->json([
            'message' => 'Article published to the blog!',
            'post' => $post,
        ], 201);
    }

    public function update(Request $request, BlogPost $post): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'category' => ['sometimes', 'nullable', 'string', 'max:255'],
            'excerpt' => ['sometimes', 'nullable', 'string', 'max:500'],
            'content' => ['sometimes', 'string'],
            'image_path' => ['sometimes', 'nullable', 'url', 'max:2048'],
            'published' => ['sometimes', 'boolean'],
        ]);

        if (array_key_exists('title', $validated) && $validated['title'] !== $post->title) {
            $post->slug = $this->uniqueSlug($validated['title'], $post->id);
        }

        if (array_key_exists('published', $validated)) {
            $post->published_at = $validated['published'] ? ($post->published_at ?? now()) : null;
            unset($validated['published']);
        }

        $post->fill($validated)->save();

        return response()->json([
            'message' => "Article #{$post->id} updated.",
            'post' => $post,
        ]);
    }

    public function destroy(BlogPost $post): JsonResponse
    {
        $post->delete();

        return response()->json(['message' => 'Article deleted.']);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            BlogPost::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . ++$i;
        }

        return $slug;
    }
}