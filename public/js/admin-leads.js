// Connects the admin dashboard's "CRM Leads" table (originally mock data
// from app.js) to the real /admin/leads API. Overrides updateLeadStatus
// and hides the old fake "Assign Sales Rep" select since we don't have
// that data yet — the last column now just shows the submission date.

async function fetchAndRenderLeads() {
  const tbody = document.getElementById('crm-leads-body');
  if (!tbody) return; // not on the admin page

  try {
    const res = await fetch('/admin/leads', { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error(`Failed to load leads (${res.status})`);
    const leads = await res.json();

    // Feed the real data into app.js's existing state object so its
    // renderAdminOverview() keeps working unmodified.
    state.leads = leads;

    renderCRMLeadsFromApi(leads);
    renderAdminOverview();
  } catch (err) {
    console.error('Could not load leads:', err);
    if (typeof showToast === 'function') showToast('Could not load leads from the server.', 'error');
  }
}
function escapeHtml(value) {
  return String(value).replace(/[&<>"']/g, (char) => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
  }[char]));
}

function formatFileSize(bytes) {
  if (!bytes) return '0 B';

  const units = ['B', 'KB', 'MB', 'GB'];
  const index = Math.min(
    Math.floor(Math.log(bytes) / Math.log(1024)),
    units.length - 1
  );

  return `${(bytes / Math.pow(1024, index)).toFixed(index === 0 ? 0 : 1)} ${units[index]}`;
}

function renderLeadAttachments(attachments) {
  if (!attachments?.length) {
    return '<span class="text-muted small">No files</span>';
  }

  return attachments.map((attachment) => `
    <a
      href="${attachment.download_url}"
      class="btn btn-sm btn-outline-primary mb-1 d-inline-flex align-items-center gap-1"
      title="Download ${escapeHtml(attachment.name)}"
    >
      <i class="bi bi-download"></i>
      <span>${escapeHtml(attachment.name)}</span>
      <small>(${formatFileSize(attachment.size)})</small>
    </a>
  `).join('<br>');
}
function renderCRMLeadsFromApi(leads) {
  const tbody = document.getElementById('crm-leads-body');
  if (!tbody) return;

  tbody.innerHTML = leads.map(l => `
    <tr>
      <td class="fw-bold text-met-navy">#${l.id}</td>
      <td>
        <div class="fw-bold">${l.name}</div>
        <div class="small text-muted"><i class="bi bi-envelope"></i> ${l.email}</div>
      </td>
      <td>
        <div class="small fw-semibold">${l.projectType}</div>
        <div class="small text-muted">${l.location || '—'} (${l.area})</div>
      </td>
      <td class="fw-bold text-met-navy small">${l.budget}</td>
      <td>
        <select class="form-select form-select-sm fw-semibold" onchange="updateLeadStatus(${l.id}, this.value)">
          <option value="new" ${l.status === 'new' ? 'selected' : ''}>New</option>
          <option value="contacted" ${l.status === 'contacted' ? 'selected' : ''}>Contacted</option>
          <option value="converted" ${l.status === 'converted' ? 'selected' : ''}>Converted</option>
          <option value="rejected" ${l.status === 'rejected' ? 'selected' : ''}>Rejected</option>
        </select>
     </td>
<td>${renderLeadAttachments(l.attachments)}</td>
<td class="small text-muted">${l.date}</td>
    </tr>
  `).join('');
}

// Overrides the mock version in app.js — now actually persists to the DB.
async function updateLeadStatus(id, newStatus) {
  try {
    const res = await fetch(`/admin/leads/${id}`, {
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

    if (typeof showToast === 'function') showToast(data.message);

    const lead = state.leads.find(l => l.id === id);
    if (lead) lead.status = newStatus;
    renderAdminOverview();
  } catch (err) {
    console.error('Could not update lead status:', err);
    if (typeof showToast === 'function') showToast('Could not update lead status.', 'error');
    fetchAndRenderLeads(); // revert the dropdown to the real server state
  }
}

document.addEventListener('DOMContentLoaded', () => {
  fetchAndRenderLeads();
});