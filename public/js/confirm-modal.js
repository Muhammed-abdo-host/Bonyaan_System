// Reusable "are you sure?" confirmation modal, styled with Bonyaan's own
// design (glass-card + navy/gold), used instead of the browser's native
// window.confirm() everywhere in the admin dashboard.
//
// Usage:
//   if (!(await confirmAction('Delete this project permanently?'))) return;
function confirmAction(message) {
  return new Promise((resolve) => {
    const modalEl = document.getElementById('confirmActionModal');

    // Fallback so nothing silently breaks on a page where the shared
    // modal markup isn't present for some reason.
    if (!modalEl || typeof bootstrap === 'undefined') {
      resolve(window.confirm(message));
      return;
    }

    const bodyEl = document.getElementById('confirmActionModalBody');
    const okBtn = document.getElementById('confirmActionModalOk');

    if (bodyEl) bodyEl.textContent = message;

    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    let settled = false;

    const finish = (result) => {
      if (settled) return;
      settled = true;
      okBtn?.removeEventListener('click', onOk);
      modalEl.removeEventListener('hidden.bs.modal', onHidden);
      resolve(result);
    };

    const onOk = () => {
      finish(true);
      modal.hide();
    };

    // Fires whether the user clicked OK, Cancel, the backdrop's X,
    // or pressed Escape — covers every "not confirmed" path in one place.
    const onHidden = () => {
      finish(false);
    };

    okBtn?.addEventListener('click', onOk);
    modalEl.addEventListener('hidden.bs.modal', onHidden);

    modal.show();
  });
}