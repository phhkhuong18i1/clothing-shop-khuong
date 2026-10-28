import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('change', (event) => {
    if (event.target.matches('[data-image-upload]')) {
        const list = document.querySelector('[data-image-preview]');
        if (!list) return;
        list.replaceChildren();
        [...event.target.files].forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;
            const card = document.createElement('label');
            card.className = 'border border-stone-200 p-2';
            const image = document.createElement('img');
            image.alt = `Xem trước ${file.name}`;
            image.className = 'h-24 w-20 object-cover';
            image.src = URL.createObjectURL(file);
            const primary = document.createElement('input');
            primary.type = 'radio';
            primary.name = 'primary_choice';
            primary.value = `new:${index}`;
            primary.checked = index === 0 && list.dataset.hasExisting !== '1';
            const text = document.createElement('span');
            text.className = 'mt-2 flex items-center gap-2 text-xs';
            text.append(primary, document.createTextNode(' Ảnh đại diện'));
            card.append(image, text);
            list.append(card);
        });
    }
});

document.addEventListener('click', (event) => {
    const thumbnail = event.target.closest('[data-gallery-thumb]');
    if (!thumbnail) return;
    const gallery = thumbnail.closest('[data-gallery]');
    const mainImage = document.querySelector('[data-gallery-main]');
    if (!mainImage || !gallery?.parentElement.contains(mainImage)) return;
    mainImage.src = thumbnail.dataset.src;
    mainImage.alt = thumbnail.dataset.alt;
    gallery.querySelectorAll('[data-gallery-thumb]').forEach((button) => button.setAttribute('aria-pressed', String(button === thumbnail)));
});

document.addEventListener('error', (event) => {
    if (event.target instanceof HTMLImageElement && event.target.matches('[data-fallback-image]')) {
        event.target.hidden = true;
    }
}, true);
