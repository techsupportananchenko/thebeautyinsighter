<?php
/**
 * Betheme Child Theme
 *
 * @package Betheme Child Theme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
 * Load Textdomain
 */

load_child_theme_textdomain('mfn-opts', get_stylesheet_directory() . '/languages');

function mfn_load_child_theme_textdomain()
{
    // WPML: use action to allow String Translation to modify text
    load_child_theme_textdomain('betheme', get_stylesheet_directory() . '/languages');
}

add_action('after_setup_theme', 'mfn_load_child_theme_textdomain');

/**
 * Enqueue Styles
 */

function mfnch_enqueue_styles()
{
    // RTL
    if (is_rtl()) {
        wp_enqueue_style('mfn-rtl', get_template_directory_uri() . '/rtl.css');
    }

    // Only enqueue child style if not already added
    if (!wp_style_is('style', 'enqueued')) {
        wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');
    }

    // Custom styles
    wp_enqueue_style(
        'custom-style',
        get_stylesheet_directory_uri() . '/css/dist/styles.css',
        ['elementor-frontend'],
        filemtime(get_stylesheet_directory() . '/css/dist/styles.css')
    );
}

add_action('wp_enqueue_scripts', 'mfnch_enqueue_styles', 20);

/*
 * Custom Code
 */

// remove downloads menu item from user dashboard
add_filter('woocommerce_account_menu_items', function ($menu_links) {
    unset($menu_links['downloads']);
    return $menu_links;
}, 999);

// My account form save

// Save custom Aktivists fields in Edit Account form
add_action('woocommerce_save_account_details', 'save_aktivists_custom_fields', 12, 1);

function save_aktivists_custom_fields($user_id)
{
    if (!$user_id) return;

    // Check nonce for security
    if (!isset($_POST['save-account-details-nonce']) || !wp_verify_nonce($_POST['save-account-details-nonce'], 'save_account_details')) {
        return;
    }

    // List of custom fields you want to save
    $aktivists_fields = [
        'aktivists_name',
        'aktivists_lastname',
        'aktivists_role',
        'aktivists_company',
        'aktivists_address',
        'aktivists_country',
        'aktivists_contact_email',
        'aktivists_contact_tel',
        'aktivists_industry',
        'aktivists_catalog',
        'aktivists_portfolio',
        'aktivists_website',
        'aktivists_social1',
        'aktivists_social2',
        'aktivists_social3',
        'aktivists_social4',
        'aktivists_presentation',
    ];

    // Save each field
    foreach ($aktivists_fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];

            // Sanitize based on type
            if (in_array($field, ['aktivists_contact_email'])) {
                $value = sanitize_email($value);
            } elseif ($field === 'aktivists_website') {
                $value = esc_url_raw($value);
            } elseif ($field === 'aktivists_presentation') {
                $value = sanitize_textarea_field($value);
            } else {
                $value = sanitize_text_field($value);
            }

            update_user_meta($user_id, $field, $value);
        }
    }

    // Handle checkboxes separately because unchecked boxes are not sent in POST
    $checkboxes = [
        'aktivists_interest_newsletter',
        'aktivists_interest_insights',
        'aktivists_interest_database',
    ];

    foreach ($checkboxes as $checkbox) {
        $value = isset($_POST[$checkbox]) ? 1 : 0;
        update_user_meta($user_id, $checkbox, $value);
    }
}

function wc_register_form_only_shortcode()
{
    if (is_admin()) return;

    if (is_user_logged_in()) {
        return '<p>You are already registered and logged in.</p>';
    }

    if ('yes' !== get_option('woocommerce_enable_myaccount_registration')) {
        return '<p>Registration is disabled.</p>';
    }

    ob_start();

    get_template_part('template-parts/form', 'register');

    return ob_get_clean();
}

add_shortcode('wc_register_form', 'wc_register_form_only_shortcode');

add_filter('woocommerce_loop_add_to_cart_link', function ($button, $product) {
    $url = get_permalink($product->get_id()); // product URL
    $label = __('Continue reading', 'woocommerce'); // Button text

    $button = sprintf(
        '<a href="%s" class="button wc-forward">%s</a>',
        esc_url($url),
        esc_html($label)
    );

    return $button;
}, 10, 2);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);

//add_filter('woocommerce_short_description', function ($excerpt) {
//    $limit = 10; // number of words
//    $words = explode(' ', wp_strip_all_tags($excerpt));
//    if (count($words) > $limit) {
//        $excerpt = implode(' ', array_slice($words, 0, $limit)) . '…';
//    }
//    return $excerpt;
//});

add_filter( 'woocommerce_logout_default_redirect_url', 'custom_logout_redirect' );
function custom_logout_redirect( $redirect_url ) {
    return home_url(); // Redirects to your site's homepage
}

function product_filter_radio_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'attribute' => '', // taxonomy slug without pa_ prefix
        'title'     => 'Filter',
    ], $atts, 'product_filter_radio' );

    if ( empty( $atts['attribute'] ) ) {
        return '<p><em>No attribute specified.</em></p>';
    }

    $taxonomy = 'pa_' . sanitize_text_field( $atts['attribute'] );
    $terms = get_terms( [
        'taxonomy'   => $taxonomy,
        'hide_empty' => false, // show empty terms
    ] );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return '<p><em>No terms found for this attribute.</em></p>';
    }

    // Sort terms by product count descending
    usort( $terms, function( $a, $b ) {
        return $b->count <=> $a->count;
    });

    $selected = isset( $_GET[ 'filter_' . $atts['attribute'] ] )
        ? sanitize_text_field( wp_unslash( $_GET[ 'filter_' . $atts['attribute'] ] ) )
        : '';

    ob_start();
    ?>
    <div class="wc-product-filter-radio-shortcode">
        <h3><?php echo esc_html( $atts['title'] ); ?></h3>
        <form method="get" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
            <?php foreach ( $terms as $term ) : ?>
                <label>
                    <input type="radio"
                           name="filter_<?php echo esc_attr( $atts['attribute'] ); ?>"
                           value="<?php echo esc_attr( $term->slug ); ?>"
                        <?php checked( $selected, $term->slug ); ?>
                           onclick="this.form.submit();">
                    <span class="wc-product-filter-radio-text"></span>
                    <?php echo esc_html( $term->name ); ?>
                </label>
            <?php endforeach; ?>
        </form>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'product_filter_radio', 'product_filter_radio_shortcode' );


add_action('woocommerce_register_post', function ($username, $email, $errors) {
    // Check email field
    if (empty($email) || !is_email($email)) {
        $errors->add('registration-error-invalid-email', __('Please enter a valid email address.', 'woocommerce'));
    } elseif (email_exists($email)) {
        $errors->add('registration-error-email-exists', __('An account is already registered with your email address.', 'woocommerce'));
    }

    // Optional: Check username if it's not auto-generated
    if ('no' === get_option('woocommerce_registration_generate_username')) {
        if (empty($_POST['username'])) {
            $errors->add('registration-error-missing-username', __('Please enter a username.', 'woocommerce'));
        } elseif (username_exists($_POST['username'])) {
            $errors->add('registration-error-username-exists', __('This username is already taken.', 'woocommerce'));
        }
    }

    // Optional: Check password if not auto-generated
    if ('no' === get_option('woocommerce_registration_generate_password')) {
        if (empty($_POST['password'])) {
            $errors->add('registration-error-missing-password', __('Please enter a password.', 'woocommerce'));
        } elseif (strlen($_POST['password']) < 6) {
            $errors->add('registration-error-weak-password', __('Password must be at least 6 characters.', 'woocommerce'));
        }
    }

}, 10, 3);

add_action('woocommerce_registration_redirect', function ($redirect) {
    return wc_get_page_permalink('myaccount');
});

// Disable cart, checkout, and "Add to Cart" buttons
add_action('init', function () {
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
});

// Redirect cart and checkout pages
add_action('template_redirect', function () {
    if (is_page(['cart', 'checkout'])) {
        wp_redirect(home_url());
        exit;
    }
});