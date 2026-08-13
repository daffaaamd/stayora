import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Toast notification system
Alpine.data('toast', () => ({
    toasts: [],
    add(message, type = 'success', duration = 4000) {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => this.remove(id), duration);
    },
    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    }
}));

// Image fallback handler
document.addEventListener('error', function (e) {
    if (e.target.tagName && e.target.tagName.toLowerCase() === 'img') {
        const fallback = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='600' viewBox='0 0 800 600'%3E%3Cdefs%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%231F2937'/%3E%3Cstop offset='100%25' stop-color='%23111827'/%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='800' height='600' fill='url(%23g)'/%3E%3Ctext x='50%25' y='48%25' dominant-baseline='middle' text-anchor='middle' font-family='serif' font-size='28' fill='%23D4AF37'%3EStayora Resort%3C/text%3E%3Ctext x='50%25' y='55%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='14' fill='%239CA3AF'%3ELuxury Accommodation%3C/text%3E%3C/svg%3E";
        if (e.target.src !== fallback) {
            e.target.src = fallback;
        }
    }
}, true);

Alpine.start();
