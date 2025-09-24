<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">

	<?php if ( $show_shipping ) : ?>

	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

	<?php endif; ?>

	<h2 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

	<address>
		<?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<p class="woocommerce-customer-details--phone">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2.16667 1.33325H5.5L7.16667 5.49992L5.08333 6.74992C5.9758 8.55953 7.44039 10.0241 9.25 10.9166L10.5 8.83325L14.6667 10.4999V13.8333C14.6667 14.2753 14.4911 14.6992 14.1785 15.0118C13.866 15.3243 13.442 15.4999 13 15.4999C9.74939 15.3024 6.68346 13.922 4.38069 11.6192C2.07792 9.31646 0.697541 6.25053 0.5 2.99992C0.5 2.55789 0.675595 2.13397 0.988155 1.82141C1.30072 1.50885 1.72464 1.33325 2.16667 1.33325Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <?php echo esc_html( $order->get_billing_phone() ); ?>
            </p>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<p class="woocommerce-customer-details--email">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M2.5 5.83329C2.5 5.39127 2.67559 4.96734 2.98816 4.65478C3.30072 4.34222 3.72464 4.16663 4.16667 4.16663H15.8333C16.2754 4.16663 16.6993 4.34222 17.0118 4.65478C17.3244 4.96734 17.5 5.39127 17.5 5.83329V14.1666C17.5 14.6087 17.3244 15.0326 17.0118 15.3451C16.6993 15.6577 16.2754 15.8333 15.8333 15.8333H4.16667C3.72464 15.8333 3.30072 15.6577 2.98816 15.3451C2.67559 15.0326 2.5 14.6087 2.5 14.1666V5.83329Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2.5 5.83337L10 10.8334L17.5 5.83337" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <?php echo esc_html( $order->get_billing_email() ); ?>
            </p>
		<?php endif; ?>

		<?php
			/**
			 * Action hook fired after an address in the order customer details.
			 *
			 * @since 8.7.0
			 * @param string $address_type Type of address (billing or shipping).
			 * @param WC_Order $order Order object.
			 */
			do_action( 'woocommerce_order_details_after_customer_address', 'billing', $order );
		?>
	</address>

	<?php if ( $show_shipping ) : ?>

		</div><!-- /.col-1 -->

		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
			<h2 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>
			<address>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>

				<?php if ( $order->get_shipping_phone() ) : ?>
					<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_shipping_phone() ); ?></p>
				<?php endif; ?>

				<?php
					/**
					 * Action hook fired after an address in the order customer details.
					 *
					 * @since 8.7.0
					 * @param string $address_type Type of address (billing or shipping).
					 * @param WC_Order $order Order object.
					 */
					do_action( 'woocommerce_order_details_after_customer_address', 'shipping', $order );
				?>
			</address>
		</div><!-- /.col-2 -->

	</section><!-- /.col2-set -->

	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
