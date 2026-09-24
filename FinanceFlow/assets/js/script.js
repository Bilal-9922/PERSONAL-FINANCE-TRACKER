document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) toggle.addEventListener('click', () => sidebar.classList.toggle('open'));

    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', event => {
            if (!window.confirm(el.dataset.confirm)) event.preventDefault();
        });
    });

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-5px)';
            setTimeout(() => el.remove(), 300);
        });
    }, 4500);
});