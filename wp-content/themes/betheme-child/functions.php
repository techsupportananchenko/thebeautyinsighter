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
