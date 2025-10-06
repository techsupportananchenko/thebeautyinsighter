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

document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('.bi-copy-url');
    copyButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = window.location.href;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(() => {
                }).catch(err => console.error('Failed to copy: ', err));
            } else {
                // Fallback for insecure context
                const textarea = document.createElement('textarea');
                textarea.value = url;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textarea);
            }
        });
    });
});

jQuery(document).ready(function($) {
    const $select = $('#aktivists_industry');
    $select.select2({
        tags: true,
        placeholder: $select.data('placeholder'),
        allowClear: false,
        width: '100%',
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            return { id: term, text: term, newTag: true };
        },
        insertTag: function(data, tag) {
            data.push(tag);
        }
    });
});