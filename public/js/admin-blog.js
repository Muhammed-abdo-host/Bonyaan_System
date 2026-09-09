// Connects the admin dashboard's "Blog & News Manager" table and
// "Add New Article" panel to the real /admin/blog API.

function csrfHeaderBlog() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

function toggleBlogPostForm(show = true) {
  const panel = document.getElementById('addBlogPostPanel');
  if (!panel) return;
  panel.classList.toggle('d-none', !show);
}

async function fetchAndRenderBlogPosts() {
  const tbody = document.getElementById('blog-posts-body');
  if (!tbody) return;

  try {
    const res = await fetch('/admin/blog', { headers: { Accept: 'application/json' } });
    if (!res.ok) throw new Error(`Failed to load articles (${res.status})`);
    const posts = await res.json();

    tbody.innerHTML = posts.map(p => `
      <tr>
        <td>
          <div class="fw-bold">${p.title}</div>
          <div class="small text-muted">${p.excerpt ? p.excerpt.slice(0, 60) : ''}</div>
        </td>
        <td><span class="badge bg-met-navy text-gold">${p.category || '—'}</span></td>
        <td class="small">${p.author}</td>
        <td>
          <span class="badge ${p.status === 'published' ? 'bg-success' : 'bg-secondary'}">${p.status}</span>
        </td>
        <td class="small text-muted">${p.published_at || '—'}</td>
        <td>
          <button class="btn btn-sm btn-outline-danger" onclick="deleteBlogPost(${p.id})">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `).join('');
  } catch (err) {
    console.error('Could not load blog posts:', err);
    showToast?.('Could not load blog articles.', 'error');
  }
}

async function addBlogPost(e) {
  e.preventDefault();

  const payload = {
    title: document.getElementById('blog-title')?.value || '',
    category: document.getElementById('blog-category')?.value || '',
    image_path: document.getElementById('blog-image')?.value || '',
    excerpt: document.getElementById('blog-excerpt')?.value || '',
    content: document.getElementById('blog-content')?.value || '',
    published: document.getElementById('blog-published')?.checked ?? true,
  };

  try {
    const res = await fetch('/admin/blog', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-CSRF-TOKEN': csrfHeaderBlog(),
      },
      body: JSON.stringify(payload),
    });

    const data = await res.json();
    if (!res.ok) throw new Error(Object.values(data.errors || {}).flat().join(' ') || data.message);

    showToast?.(data.message);
    e.target.reset();
    toggleBlogPostForm(false);
    fetchAndRenderBlogPosts();
  } catch (err) {
    console.error('Could not save article:', err);
    showToast?.(err.message || 'Could not save the article.', 'error');
  }
}

async function deleteBlogPost(id) {
  try {
    const res = await fetch(`/admin/blog/${id}`, {
      method: 'DELETE',
      headers: { Accept: 'application/json', 'X-CSRF-TOKEN': csrfHeaderBlog() },
    });

    if (!res.ok) throw new Error('Failed to delete article');
    const data = await res.json();

    showToast?.(data.message, 'info');
    fetchAndRenderBlogPosts();
  } catch (err) {
    console.error('Could not delete article:', err);
    showToast?.('Could not delete the article.', 'error');
  }
}