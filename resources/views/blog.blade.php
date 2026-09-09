@extends('components.layouts')

@section('content')
  <!-- BLOG VIEW SECTION -->
  <section id="view-blog" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="text-center max-w-700 mx-auto mb-5">
        <span class="badge badge-gold mb-2">Blog & News</span>
        <h1 class="display-5 fw-bold text-met-navy mb-3">Engineering Insights & Construction Tech</h1>
        <p class="lead text-muted">Stay updated with structural innovations, green building trends, and company milestones.</p>
      </div>

      @if ($posts->isEmpty())
        <div class="text-center text-muted py-5">
          <i class="bi bi-journal-text fs-1 d-block mb-3"></i>
          No articles published yet. Check back soon!
        </div>
      @else
        <div class="row g-4">
          @foreach ($posts as $post)
            <div class="col-md-4">
              <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                <div class="glass-card overflow-hidden h-100">
                  <img
                    src="{{ $post->image_path ?: 'https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?auto=format&fit=crop&w=600&q=80' }}"
                    alt="{{ $post->title }}"
                    class="w-100 object-fit-cover"
                    style="height: 200px;"
                  >
                  <div class="p-4">
                    @if ($post->category)
                      <span class="badge bg-met-navy text-gold mb-2">{{ $post->category }}</span>
                    @endif
                    <h5 class="fw-bold text-met-navy mb-2">{{ $post->title }}</h5>
                    <p class="small text-muted mb-3">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}</p>
                    <div class="small text-secondary border-top pt-2">
                      {{ $post->published_at->format('M d, Y') }} • {{ $post->readMinutes() }} min read
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>
@endsection