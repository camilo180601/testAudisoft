/**
 * Modal de confirmación reutilizable.
 * Cualquier <form data-confirm="mensaje"> mostrará el modal antes de enviarse.
 */
function initConfirmModal() {
    const modal = document.getElementById('confirm-modal');
    if (!modal) return;

    const panel = modal.querySelector('[data-confirm-panel]');
    const titleEl = modal.querySelector('[data-confirm-title]');
    const messageEl = modal.querySelector('[data-confirm-message]');
    const acceptBtn = modal.querySelector('[data-confirm-accept]');
    let pendingForm = null;

    const open = (form) => {
        pendingForm = form;
        messageEl.textContent = form.dataset.confirm || '¿Confirmar acción?';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(() => panel.classList.remove('scale-95'));
        acceptBtn.focus();
    };

    const close = () => {
        pendingForm = null;
        panel.classList.add('scale-95');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            if (form.dataset.confirmed === 'true') return; // ya confirmado
            e.preventDefault();
            open(form);
        });
    });

    acceptBtn.addEventListener('click', () => {
        if (!pendingForm) return;
        pendingForm.dataset.confirmed = 'true';
        pendingForm.submit();
    });

    modal.querySelectorAll('[data-confirm-cancel]').forEach((el) =>
        el.addEventListener('click', close)
    );

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
    });
}

/**
 * Buscador en vivo sobre la tabla de sitios (filtrado en cliente).
 */
function initSiteSearch() {
    const input = document.getElementById('site-search');
    const table = document.getElementById('sites-table');
    const emptyMsg = document.getElementById('sites-empty-search');
    if (!input || !table) return;

    const rows = Array.from(table.querySelectorAll('tbody tr'));

    input.addEventListener('input', () => {
        const term = input.value.trim().toLowerCase();
        let visible = 0;

        rows.forEach((row) => {
            const match = row.dataset.search.includes(term);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });

        emptyMsg?.classList.toggle('hidden', visible !== 0);
    });
}

/**
 * Oculta los mensajes flash automáticamente después de unos segundos.
 */
function initAutoDismiss() {
    document.querySelectorAll('[data-auto-dismiss]').forEach((el) => {
        setTimeout(() => {
            el.style.transition = 'opacity .4s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }, 4000);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initConfirmModal();
    initSiteSearch();
    initAutoDismiss();
});
