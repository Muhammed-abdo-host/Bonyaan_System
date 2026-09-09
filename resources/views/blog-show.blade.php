@extends('components.layouts')

@section('content')
  <section id="view-blog-show" class="view-section active animated-fade py-5">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <a href="{{ route('blog') }}" class="small text-decoration-none text-met-navy fw-semibold">
            <i class="bi bi-arrow-left"></i> Back to Blog
          </a>

          @if ($post->category)
            <span class="badge bg-met-navy text-gold mt-3 mb-2">{{ $post->category }}</span>
          @endif

          <h1 class="fw-bold text-met-navy mb-3">{{ $post->title }}</h1>

          <div class="small text-secondary border-bottom pb-3 mb-4">
            By {{ $post->author?->name ?? 'Bonyaan Team' }} • {{ $post->published_at->format('M d, Y') }} • {{ $post->readMinutes() }} min read
          </div>

          @if ($post->image_path)
            <img src="{{ $post->image_path }}" alt="{{ $post->title }}" class="w-100 rounded-3 mb-4" style="max-height: 420px; object-fit: cover;">
          @endif

          <div class="fs-6 lh-lg" style="white-space: pre-line;">{{ $post->content }}</div>
        </div>
      </div>

      @if ($related->isNotEmpty())
        <div class="row justify-content-center mt-5 pt-4 border-top">
          <div class="col-lg-8">
            <h5 class="fw-bold text-met-navy mb-4">Related Articles</h5>
            <div class="row g-4">
              @foreach ($related as $item)
                <div class="col-md-4">
                  <a href="{{ route('blog.show', $item->slug) }}" class="text-decoration-none">
                    <div class="glass-card overflow-hidden h-100">
                      <img
                        src="{{ $item->image_path ?: 'https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?auto=format&fit=crop&w=600&q=80' }}"
                        class="w-100 object-fit-cover" style="height: 150px;"
                      >
                      <div class="p-3">
                        <h6 class="fw-bold text-met-navy mb-0">{{ $item->title }}</h6>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
    </div>
  </section>
@endsection