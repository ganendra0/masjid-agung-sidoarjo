import Alpine from 'alpinejs';

/** Hero slider: autoplay, jeda saat hover, hormati prefers-reduced-motion. */
Alpine.data('heroSlider', (total) => ({
    current: 0,
    total,
    paused: false,
    timer: null,
    init() {
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (this.total > 1 && !reduce) {
            this.timer = setInterval(() => { if (!this.paused) this.next(); }, 6500);
        }
    },
    next() { this.current = (this.current + 1) % this.total; },
    prev() { this.current = (this.current - 1 + this.total) % this.total; },
    go(i) { this.current = i; },
}));

/** Grid galeri dengan filter kategori (sisi klien) + lightbox. */
Alpine.data('galleryGrid', (items) => ({
    items,
    cat: 'all',
    open: false,
    index: 0,
    get visible() {
        return this.cat === 'all' ? this.items : this.items.filter((i) => i.cat === this.cat);
    },
    get current() {
        return this.visible[this.index] || {};
    },
    show(i) {
        this.index = i;
        this.open = true;
        document.body.classList.add('overflow-hidden');
    },
    close() {
        this.open = false;
        document.body.classList.remove('overflow-hidden');
    },
    next() { this.index = (this.index + 1) % this.visible.length; },
    prev() { this.index = (this.index - 1 + this.visible.length) % this.visible.length; },
}));

window.Alpine = Alpine;
Alpine.start();
