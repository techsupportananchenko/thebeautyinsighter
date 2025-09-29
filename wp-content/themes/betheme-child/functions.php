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

function mfn_load_child_theme_textdomain(){
	// WPML: use action to allow String Translation to modify text
	load_child_theme_textdomain('betheme', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'mfn_load_child_theme_textdomain');

/**
 * Enqueue Styles
 */

function mfnch_enqueue_styles()
{
	// enqueue the parent stylesheet
	// however we do not need this if it is empty
	// wp_enqueue_style('parent-style', get_template_directory_uri() .'/style.css');

	// enqueue the parent RTL stylesheet

	if ( is_rtl() ) {
		wp_enqueue_style('mfn-rtl', get_template_directory_uri() . '/rtl.css');
	}

	// enqueue the child stylesheet

	wp_dequeue_style('style');
	wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css');

    // Custom styles
    wp_enqueue_style('custom-style', get_stylesheet_directory_uri() .'/css/dist/styles.css', [], filemtime(get_stylesheet_directory() . '/css/dist/styles.css'));
}
add_action('wp_enqueue_scripts', 'mfnch_enqueue_styles', 101);

/*
 * Custom Code
 */

// remove downloads menu item from user dashboard
add_filter( 'woocommerce_account_menu_items', function( $menu_links ) {
    unset( $menu_links['downloads'] );
    return $menu_links;
}, 999 );

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

function wc_register_form_only_shortcode() {
    if ( is_admin() ) return;

    if ( is_user_logged_in() ) {
        return '<p>You are already registered and logged in.</p>';
    }

    if ( 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) {
        return '<p>Registration is disabled.</p>';
    }

    ob_start();

    ?>
    <div class="woocommerce">
        <form method="post" class="woocommerce-form woocommerce-form-register register">
            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ! empty( $_POST['email'] ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
            </p>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ! empty( $_POST['username'] ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                </p>
            <?php endif; ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                </p>
            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <p class="woocommerce-form-row form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'Register', 'woocommerce' ); ?>
                </button>
            </p>

            <?php do_action( 'woocommerce_register_form_end' ); ?>
        </form>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode( 'wc_register_form', 'wc_register_form_only_shortcode' );
