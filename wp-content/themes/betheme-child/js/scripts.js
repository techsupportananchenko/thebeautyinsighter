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
            const textEl = btn.querySelector('.elementor-button-text');
            const originalText = textEl.textContent;

            // Copy link
            const copyAction = () => {
                textEl.textContent = 'Copied!'; // change text
                setTimeout(() => {
                    textEl.textContent = originalText; // revert text
                }, 5000);
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url)
                    .then(copyAction)
                    .catch(err => console.error('Failed to copy: ', err));
            } else {
                // Fallback for insecure context
                const textarea = document.createElement('textarea');
                textarea.value = url;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    copyAction();
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textarea);
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {

    // Function to attach close behavior to a notice
    function attachNoticeClose(notice) {
        const closeBtn = notice.querySelector('a.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                notice.remove();
            });
        }
    }

    // Attach to existing notices on page load
    document.querySelectorAll('.woocommerce-error, .woocommerce-info, .woocommerce-message').forEach(attachNoticeClose);

    // Observe for new notices added dynamically (AJAX)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1 && (node.classList.contains('woocommerce-error') || node.classList.contains('woocommerce-info') || node.classList.contains('woocommerce-message'))) {
                    attachNoticeClose(node);
                }
            });
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });

});

jQuery(document).ready(function($) {
    const $select = $('#aktivists_industry');
    if ($select.length) {
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
    }


    function moveMenu() {
        const $menu = $('#menu');
        const $sideMenuWrapper = $('#Side_slide .menu_wrapper');
        const $headerMenuWrapper = $('#Header .menu_wrapper');

        if ($(window).width() <= 1240) {
            if (!$sideMenuWrapper.find('#menu').length) {
                $menu.appendTo($sideMenuWrapper);
            }
        } else {
            if (!$headerMenuWrapper.find('#menu').length) {
                $menu.appendTo($headerMenuWrapper);
            }
        }
    }

    moveMenu();

    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(moveMenu, 200);
    });

    $('.responsive-menu-toggle').on('click', function(e) {
        e.preventDefault();
        $('#Side_slide').css('right', '0');
        $('body').addClass('side-open');
    });

    $('#Side_slide .close, .overlay').on('click', function() {
        $('#Side_slide').removeAttr('style');
        $('body').removeClass('side-open');
    });
});