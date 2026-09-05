<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::published()->latest('published_at')->get();

        return view('blog', compact('posts'));
    }

    public function show(BlogPost $post): View
    {
        abort_unless(
            $post->published_at && $post->published_at->lte(now()),
            404
        );

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($q) => $q->where('category', $post->category))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog-show', compact('post', 'related'));
    }
}