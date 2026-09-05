// Connects the admin dashboard's "Contact Messages" table to the real
// /admin/messages API. Follows the same pattern as admin-leads.js.

let cachedContactMessages = [];

function escapeHtmlSafe(value) {
  if (typeof escapeHtml === 'function') return escapeHtml(value);
  return String(value).replace(/[&<>"']/g, (char) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
  }[char]));
}

function truncateText(value, maxLength = 80) {
  const text = String(value || '');
  return text.length > maxLength ? `${text.slice(0, maxLength)}…` : text;
}

function statusBadgeClass(status) {
  return {
    new: 'bg-primary',
    read: 'bg-secondary',
    replied: 'bg-success',
    archived: 'bg-dark',
  }[status] || 'bg-secondary';
}

async function fetchAndRenderMessages() {
  const tbody = document.getElementById('messages-body');
  if (!tbody) return; // not on the admin page

  tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> Loading...</td></tr>';

  try {
    const res = await fetch('/admin/messages', { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error(`Failed to load messages (${res.status})`);
    const messages = await res.json();

    cachedContactMessages = messages;
    renderMessagesTable(messages);

    const kpi = document.getElementById('kpi-messages-count');
    if (kpi) kpi.textContent = messages.filter((m) => m.status === 'new').length;
  } catch (err) {
    console.error('Could not load contact messages:', err);
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-danger py-4">Failed to load messages.</td></tr>';
    if (typeof showToast === 'function') showToast('Could not load contact messages from the server.', 'error');
  }
}

function renderMessagesTable(messages) {
  const tbody = document.getElementById('messages-body');
  if (!tbody) return;

  if (!messages.length) {
    tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No messages yet.</td></tr>';
    return;
  }

  tbody.innerHTML = messages.map((m) => `
    <tr>
      <td class="text-muted small">#${m.id}</td>
      <td>
        <div class="fw-bold">${escapeHtmlSafe(m.name)}</div>
        <div class="small text-muted"><i class="bi bi-envelope"></i> ${escapeHtmlSafe(m.email)}</div>
      </td>
      <td class="small fw-semibold">${escapeHtmlSafe(m.subject)}</td>
      <td class="small text-muted">
        ${escapeHtmlSafe(truncateText(m.message))}
        <button
          type="button"
          class="btn btn-link btn-sm p-0 ms-1"
          onclick="viewContactMessage(${m.id})"
        >View</button>
      </td>
      <td>
        <select class="form-select form-select-sm" onchange="updateMessageStatus(${m.id}, this.value)" style="min-width:130px;">
          ${['new', 'read', 'replied', 'archived'].map((s) => `
            <option value="${s}" ${m.status === s ? 'selected' : ''}>${s.charAt(0).toUpperCase() + s.slice(1)}</option>
          `).join('')}
        </select>
      </td>
      <td class="small text-muted">${m.date}</td>
    </tr>
  `).join('');
}

function viewContactMessage(id) {
  const message = cachedContactMessages.find((m) => m.id === id);
  if (!message) return;

  if (document.getElementById('cm-modal-subject')) document.getElementById('cm-modal-subject').innerText = message.subject;
  if (document.getElementById('cm-modal-from')) document.getElementById('cm-modal-from').innerText = `${message.name} <${message.email}>`;
  if (document.getElementById('cm-modal-date')) document.getElementById('cm-modal-date').innerText = message.date;
  if (document.getElementById('cm-modal-body')) document.getElementById('cm-modal-body').innerText = message.message;
  if (document.getElementById('cm-modal-status-badge')) {
    const badge = document.getElementById('cm-modal-status-badge');
    badge.className = `badge ${statusBadgeClass(message.status)}`;
    badge.innerText = message.status;
  }

  const modalEl = document.getElementById('contactMessageModal');
  if (modalEl && typeof bootstrap !== 'undefined') {
    new bootstrap.Modal(modalEl).show();
  }

  // Auto-mark as read the first time it's opened.
  if (message.status === 'new') {
    updateMessageStatus(id, 'read', { silent: true });
  }
}

async function updateMessageStatus(id, newStatus, options = {}) {
  try {
    const res = await fetch(`/admin/messages/${id}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
      },
      body: JSON.stringify({ status: newStatus }),
    });

    if (!res.ok) throw new Error('Failed to update status');
    const data = await res.json();

    if (!options.silent && typeof showToast === 'function') showToast(data.message);

    const cached = cachedContactMessages.find((m) => m.id === id);
    if (cached) cached.status = newStatus;
    renderMessagesTable(cachedContactMessages);

    const kpi = document.getElementById('kpi-messages-count');
    if (kpi) kpi.textContent = cachedContactMessages.filter((m) => m.status === 'new').length;
  } catch (err) {
    console.error('Could not update message status:', err);
    if (typeof showToast === 'function') showToast('Could not update message status.', 'error');
    fetchAndRenderMessages(); // revert to the real server state
  }
}

document.addEventListener('DOMContentLoaded', () => {
  fetchAndRenderMessages();
});