<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

global $woocommerce;

$has_shop = false;
$has_user = false;
$has_cart = false;
$has_wishlist = false;
$has_menu = false;

// has shop

if (isset($woocommerce) && function_exists('is_woocommerce')) {
    $has_shop = true;
}

// shop icons hide

$shop_icons_hide = mfn_opts_get('shop-icons-hide');

// shop user

if( $has_shop && empty( $shop_icons_hide['user'] ) ){
	$has_user = true;
}

$user_icon = trim( mfn_opts_get('shop-user') ?? '' );

// shop wishlist

if( $has_shop && empty( $shop_icons_hide['wishlist'] ) && mfn_opts_get('shop-wishlist') && mfn_opts_get('shop-wishlist-page') ){
	$has_wishlist = true;
}

$wishlist_icon = trim( mfn_opts_get('shop-icon-wishlist') ?? '' );

// shop cart

if ($has_shop && empty($shop_icons_hide['cart'])) {
    $has_cart = true;
}

$cart_icon = trim(mfn_opts_get('shop-cart') ?? '');

// search

$header_search = mfn_opts_get('header-search');

// action button

$action_link = mfn_opts_get('header-action-link');

// WPML icon

if (has_nav_menu('lang-menu')) {
    $wpml_icon = true;
} elseif (function_exists('icl_get_languages') && mfn_opts_get('header-wpml') != 'hide') {
    $wpml_icon = true;
} else {
    $wpml_icon = false;
}

// header shop menus

if ('header-shop' == mfn_header_style(true) && 'hide' != mfn_opts_get('menu-style')) {
    $has_menu = true;
}

// class

$class = [];

$shop_cart_total_hide = mfn_opts_get('shop-cart-total-hide');
if (is_array($shop_cart_total_hide)) {
    unset($shop_cart_total_hide['post-meta']);
    foreach ($shop_cart_total_hide as $val => $k) {
        $class[] = 'hide-total-' . $val;
    }
}

$class = implode(' ', $class);

$translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder', 'Enter your search') : __('Enter your search', 'betheme');

// output -----

if ($has_user || $has_wishlist || $has_cart || $header_search || $action_link || $wpml_icon || $has_menu) {
    echo '<div class="top_bar_right ' . esc_attr($class) . '">';
    echo '<div class="top_bar_right_wrapper">';

    $search_icon = '<svg width="26" viewBox="0 0 26 26" aria-label="' . __('search icon', 'betheme') . '"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><circle class="path" cx="11.35" cy="11.35" r="6"/><line class="path" x1="15.59" y1="15.59" x2="20.65" y2="20.65"/></svg>';

    // header style shop

    if ('header-shop' == mfn_header_style(true) && 'input' == $header_search) {

        echo '<div class="top-bar-right-input has-input">';
        echo '<form method="get" class="form-searchform" id="searchform" action="' . esc_url(home_url('/')) . '" role="search" aria-label="' . __('header search form', 'betheme') . '">';

        echo $search_icon;
        echo '<input type="text" class="field" name="s" autocomplete="off" placeholder="' . esc_html($translate['search-placeholder']) . '" aria-label="' . esc_html($translate['search-placeholder']) . '" />';

        do_action('wpml_add_language_form_field');

        echo '<input type="submit" class="submit" value="" style="display:none;" />';

        if (mfn_opts_get('header-search-live')) {
            get_template_part('includes/header', 'live-search');
        }

        echo '</form>';
        echo '</div>';

    }

    // shop user

    if ($has_user) {

        $modal_type = 'is-boxed';
        if ('header-creative' == mfn_header_style(true)) {
            $modal_type = false;
        }

        echo '<a class="top-bar-right-icon myaccount_button top-bar-right-icon-user toggle-login-modal ' . esc_attr($modal_type) . ' ' . (is_user_logged_in() ? 'logged-in' : 'logged-out') . '" href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '">';
        if (is_user_logged_in()) {
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M12.0004 12.8001C14.2648 12.8001 16.1004 10.9645 16.1004 8.7001C16.1004 6.43573 14.2648 4.6001 12.0004 4.6001C9.73602 4.6001 7.90039 6.43573 7.90039 8.7001C7.90039 10.9645 9.73602 12.8001 12.0004 12.8001Z" stroke="white" stroke-width="1.5"/> <path d="M18.5098 17.1V19.41H5.50977V17.1C5.50977 14.73 8.42977 12.8 12.0198 12.8C15.6098 12.8 18.5098 14.73 18.5098 17.1Z" stroke="white" stroke-width="1.5" stroke-linejoin="round"/> </svg>';
        }
        echo '</a>';

    }

    // shop cart

    if ($has_cart) {

        if (mfn_opts_get('shop-sidecart') && !is_cart() && !is_checkout()) {
            $class = 'toggle-mfn-cart';
        } else {
            $class = false;
        }

        echo '<a id="header_cart" class="top-bar-right-icon header-cart top-bar-right-icon-cart ' . esc_attr($class) . '" href="' . esc_url(wc_get_cart_url()) . '">';

        if ($cart_icon) {
            echo '<i class="' . $cart_icon . '" aria-label="' . __('cart icon', 'betheme') . '"></i>';
        } else {
            echo '<svg xmlns="http://www.w3.org/2000/svg" aria-label="' . __('cart icon', 'betheme') . '" width="20" height="18" viewBox="0 0 20 18" fill="none"><path d="M1 7H2M2 7L3 17H17L18 7M2 7H6M19 7H18M18 7H14M14 7H6M14 7V5C14 3.667 13.2 1 10 1C6.8 1 6 3.667 6 5V7M10 11V13M13 11V13M7 11V13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        }

        echo '</a>';

    }

    // search icon

    if ('input' == $header_search) {

        if ('header-shop' != mfn_header_style(true)) {

            echo '<div class="top-bar-right-input has-input">';
            echo '<form method="get" class="top-bar-search-form" id="searchform" action="' . esc_url(home_url('/')) . '" role="search" aria-label="' . __('header search form', 'betheme') . '">';

            echo $search_icon;
            echo '<input type="text" class="field" name="s" autocomplete="off" placeholder="' . esc_html($translate['search-placeholder']) . '" aria-label="' . esc_html($translate['search-placeholder']) . '"/>';

            do_action('wpml_add_language_form_field');

            echo '<input type="submit" class="submit" value="" style="display:none;" />';

            if (mfn_opts_get('header-search-live')) {
                get_template_part('includes/header', 'live-search');
            }

            echo '</form>';
            echo '</div>';

        }

    } elseif ($header_search) {

        echo '<a id="search_button" class="top-bar-right-icon top-bar-right-icon-search search_button" href="#">';
        echo $search_icon;
        echo '</a>';

    }

    // languages menu

    get_template_part('includes/include', 'wpml');

    // action button

    if ($action_link) {
        $action_options = mfn_opts_get('header-action-target');

        if (isset($action_options['target'])) {
            $action_target = 'target="_blank"';
        } else {
            $action_target = false;
        }

        if (isset($action_options['scroll'])) {
            $action_class = ' scroll';
        } else {
            $action_class = false;
        }

        echo '<a href="' . esc_url($action_link) . '" class="button action_button top-bar-right-button ' . esc_attr($action_class) . '" ' . wp_kses_data($action_target) . '>' . wp_kses(mfn_opts_get('header-action-title'), mfn_allowed_html('button')) . '</a>';
    }

    // header style: shop | menu button

    if ($has_menu) {

        // responsive menu button
        $mb_class = '';
        if (mfn_opts_get('header-menu-mobile-sticky')) {
            $mb_class .= ' is-sticky';
        }

        echo '<a class="responsive-menu-toggle ' . esc_attr($mb_class) . '" href="#" aria-label="' . __('mobile menu', 'betheme') . '">';
        if ($menu_text = trim(mfn_opts_get('header-menu-text') ?? '')) {
            echo '<span aria-hidden="true">' . wp_kses($menu_text, mfn_allowed_html()) . '</span>';
        } else {
            echo '<i class="icon-menu-fine" aria-hidden="true"></i>';
        }
        echo '</a>';

    }

    echo '</div>';
    echo '</div>';
}

?>
