<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address = wc_get_account_formatted_address( $name );
		$col     = $col * -1;
		$oldcol  = $oldcol * -1;
	?>

	<div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $oldcol < 0 ? 1 : 2; ?> woocommerce-Address">
		<header class="woocommerce-Address-title title">
			<h2><?php echo esc_html( $address_title ); ?></h2>
		</header>
        <div class="woocommerce-Address-block">
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php
                printf(
                /* translators: %s: Address title */
                    $address ? esc_html__( 'Edit %s', 'woocommerce' ) : esc_html__( 'Add %s', 'woocommerce' ),
                    esc_html( $address_title )
                );
                ?>
            </a>
            <address>
                <?php
                echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );

                // Get current user ID
                $user_id = get_current_user_id();

                // Get phone and billing email from WooCommerce
                $phone = get_user_meta( $user_id, 'billing_phone', true );
                $billing_email = get_user_meta( $user_id, 'billing_email', true );

                // Output if available
                if ( $phone ) {
                    echo '<span class="woocommerce-customer-details--phone"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2.16667 1.33325H5.5L7.16667 5.49992L5.08333 6.74992C5.9758 8.55953 7.44039 10.0241 9.25 10.9166L10.5 8.83325L14.6667 10.4999V13.8333C14.6667 14.2753 14.4911 14.6992 14.1785 15.0118C13.866 15.3243 13.442 15.4999 13 15.4999C9.74939 15.3024 6.68346 13.922 4.38069 11.6192C2.07792 9.31646 0.697541 6.25053 0.5 2.99992C0.5 2.55789 0.675595 2.13397 0.988155 1.82141C1.30072 1.50885 1.72464 1.33325 2.16667 1.33325Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>' . esc_html( $phone ) . '</span>';
                }
                if ( $billing_email ) {
                    echo '<span class="woocommerce-customer-details--email"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M2.5 5.83329C2.5 5.39127 2.67559 4.96734 2.98816 4.65478C3.30072 4.34222 3.72464 4.16663 4.16667 4.16663H15.8333C16.2754 4.16663 16.6993 4.34222 17.0118 4.65478C17.3244 4.96734 17.5 5.39127 17.5 5.83329V14.1666C17.5 14.6087 17.3244 15.0326 17.0118 15.3451C16.6993 15.6577 16.2754 15.8333 15.8333 15.8333H4.16667C3.72464 15.8333 3.30072 15.6577 2.98816 15.3451C2.67559 15.0326 2.5 14.6087 2.5 14.1666V5.83329Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M2.5 5.83337L10 10.8334L17.5 5.83337" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>' . esc_html( $billing_email ) . '</span>';
                }
                /**
                 * Used to output content after core address fields.
                 *
                 * @param string $name Address type.
                 * @since 8.7.0
                 */
                do_action( 'woocommerce_my_account_after_my_address', $name );
                ?>
            </address>
        </div>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
	<?php
endif;
