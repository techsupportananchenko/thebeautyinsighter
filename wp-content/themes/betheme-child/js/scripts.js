document.addEventListener('click', function(e) {
    // Check if clicked element is a heading inside an accordion
    const heading = e.target.closest('.woocommerce-shop .accordion .wp-block-heading');
    if (!heading) return;

    const accordion = heading.closest('.accordion');
    const list = accordion.querySelector('.wp-block-woocommerce-product-filter-checkbox-list');
    if (!list) return;

    const isOpen = list.style.display === 'block';
    list.style.display = isOpen ? 'none' : 'block';
    heading.classList.toggle('open', !isOpen);
});