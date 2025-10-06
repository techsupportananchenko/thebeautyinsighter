<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined('ABSPATH') || exit;

/**
 * Hook - woocommerce_before_edit_account_form.
 *
 * @since 2.6.0
 */
do_action('woocommerce_before_edit_account_form');
?>


<form class="woocommerce-EditAccountForm edit-account" action=""
      method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?> >
    <div class="woocommerce-EditAccountForm-block">
        <?php do_action('woocommerce_edit_account_form_start'); ?>
        <div class="section-title"><?php esc_html_e('User Data', 'woocommerce'); ?></div>
        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="account_first_name"><?php esc_html_e('First name', 'woocommerce'); ?>&nbsp;<span
                        class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name"
                   id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>"
                   aria-required="true"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="account_last_name"><?php esc_html_e('Last name', 'woocommerce'); ?>&nbsp;<span class="required"
                                                                                                       aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name"
                   id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>"
                   aria-required="true"/>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span
                        class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name"
                   id="account_display_name" aria-describedby="account_display_name_description"
                   value="<?php echo esc_attr($user->display_name); ?>" aria-required="true"/> <span
                    id="account_display_name_description"><em><?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?></em></span>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="account_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required"
                                                                                                       aria-hidden="true">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email"
                   id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>"
                   aria-required="true"/>
        </p>

        <?php
        /**
         * Hook where additional fields should be rendered.
         *
         * @since 8.7.0
         */
        do_action('woocommerce_edit_account_form_fields');
        ?>

        <fieldset class="password-fields">
            <legend><?php esc_html_e('Password change', 'woocommerce'); ?></legend>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password_current"><?php esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                       name="password_current" id="password_current" autocomplete="off"/>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password_1"><?php esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce'); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                       name="password_1" id="password_1" autocomplete="off"/>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password_2"><?php esc_html_e('Confirm new password', 'woocommerce'); ?></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
                       name="password_2" id="password_2" autocomplete="off"/>
            </p>
        </fieldset>
    </div>

    <div class="woocommerce-EditAccountForm-block aktivists-checkbox">
        <fieldset>
            <legend class="section-title"><?php esc_html_e('Aktivists Interest', 'woocommerce'); ?></legend>

            <?php
            $interests = [
                'newsletter' => __('<b>Newsletter</b>: I’m interested into receiving weekly newsletters.', 'woocommerce'),
                'insights' => __('<b>Insights</b>: I’m interested into accessing to reports and Insights', 'woocommerce'),
                'database' => __('<b>Data Base</b>: I’m interested into being part of Beauty Aktivists data base.', 'woocommerce'),
            ];

            $user_id = get_current_user_id();
            foreach ($interests as $key => $label) :
                $checked = get_user_meta($user_id, 'aktivists_interest_' . $key, true) ? 'checked' : '';
                ?>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide custom-checkbox">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                               type="checkbox"
                               name="aktivists_interest_<?php echo esc_attr($key); ?>"
                               id="aktivists_interest_<?php echo esc_attr($key); ?>"
                               value="1" <?php echo $checked; ?> /><span class="checkmark"></span><span class="checkbox-label"><?php echo $label; ?></span>
                    </label>
                </p>
            <?php endforeach; ?>
        </fieldset>
    </div>

    <div class="woocommerce-EditAccountForm-block">
        <div class="title"><?php esc_html_e('Aktivists Information', 'woocommerce'); ?></div>
        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="aktivists_name"><?php esc_html_e('First Name', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_name" id="aktivists_name"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_name', true)); ?>"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="aktivists_lastname"><?php esc_html_e('Last Name', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_lastname" id="aktivists_lastname"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_lastname', true)); ?>"/>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="aktivists_role"><?php esc_html_e('Role', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_role" id="aktivists_role"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_role', true)); ?>"/>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="aktivists_company"><?php esc_html_e('Company name', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_company" id="aktivists_company"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_company', true)); ?>"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="aktivists_address"><?php esc_html_e('Address', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_address" id="aktivists_address"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_address', true)); ?>"/>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="aktivists_country"><?php esc_html_e('Country', 'woocommerce'); ?></label>
            <select name="aktivists_country" id="aktivists_country"
                    class="woocommerce-Input woocommerce-Input--select input-select">
                <?php
                $countries = WC()->countries->get_countries();
                $selected_country = get_user_meta(get_current_user_id(), 'aktivists_country', true);
                foreach ($countries as $code => $name) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($code),
                        selected($selected_country, $code, false),
                        esc_html($name)
                    );
                }
                ?>
            </select>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="aktivists_contact_email"><?php esc_html_e('Contact Email', 'woocommerce'); ?></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text"
                   name="aktivists_contact_email" id="aktivists_contact_email"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_contact_email', true)); ?>"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="aktivists_contact_tel"><?php esc_html_e('Contact Tel', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_contact_tel" id="aktivists_contact_tel"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_contact_tel', true)); ?>"/>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="aktivists_industry"><?php esc_html_e('Industry', 'woocommerce'); ?></label>
            <select name="aktivists_industry" id="aktivists_industry"
                    class="woocommerce-Input woocommerce-Input--select input-select">
                <?php
                $industries = array(
                    'Product design',
                    'Graphic design',
                    'Retail design',
                    'Digital design',
                    'CGI design',
                    'Video',
                    'Photography',
                    'Retouching/editing',
                    'Marketing',
                    'Consultant',
                    'HR',
                    'Account manager',
                    'Content creator',
                    'Influencer',
                    'Community manager',
                    'Packaging manufacturer',
                    'Glass packaging',
                    'Plastic packaging',
                    'Cardboard packaging',
                    'Metal packaging',
                    'Perfumer',
                    'Formulator',
                    'Chemistry',
                    'Mixer'
                );

                $selected_industry = get_user_meta(get_current_user_id(), 'aktivists_industry', true);

                foreach ($industries as $industry) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($industry),
                        selected($selected_industry, $industry, false),
                        esc_html($industry)
                    );
                }

                // If saved value isn't in the predefined list, show it as a custom tag
                if ($selected_industry && !in_array($selected_industry, $industries, true)) {
                    printf('<option value="%s" selected>%s</option>',
                        esc_attr($selected_industry),
                        esc_html($selected_industry)
                    );
                }
                ?>
            </select>
        </p>

        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="aktivists_catalog"><?php esc_html_e('Catalog', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_catalog" id="aktivists_catalog"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_catalog', true)); ?>"/>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="aktivists_portfolio"><?php esc_html_e('Portfolio', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_portfolio" id="aktivists_portfolio"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_portfolio', true)); ?>"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="aktivists_website"><?php esc_html_e('Website', 'woocommerce'); ?> <span
                        class="required">*</span></label>
            <input type="url" class="woocommerce-Input woocommerce-Input--url input-text"
                   name="aktivists_website" id="aktivists_website"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_website', true)); ?>"
                   required/>
        </p>
        <div class="clear"></div>

        <div class="section-title section-title-social"><?php esc_html_e('Social Networks', 'woocommerce'); ?></div>
        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="aktivists_social1"><?php esc_html_e('Social 1', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_social1" id="aktivists_social1"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_social1', true)); ?>"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="aktivists_social2"><?php esc_html_e('Social 2', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_social2" id="aktivists_social2"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_social2', true)); ?>"/>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="aktivists_social3"><?php esc_html_e('Social 3', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_social3" id="aktivists_social3"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_social3', true)); ?>"/>
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="aktivists_social4"><?php esc_html_e('Social 4', 'woocommerce'); ?></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                   name="aktivists_social4" id="aktivists_social4"
                   value="<?php echo esc_attr(get_user_meta(get_current_user_id(), 'aktivists_social4', true)); ?>"/>
        </p>
        <div class="clear"></div>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="aktivists_presentation"><?php esc_html_e('Short Presentation', 'woocommerce'); ?></label>
            <textarea class="woocommerce-Input woocommerce-Input--textarea input-text"
                      name="aktivists_presentation" id="aktivists_presentation" rows="4"><?php
                echo esc_textarea(get_user_meta(get_current_user_id(), 'aktivists_presentation', true));
                ?></textarea>
        </p>
        <div class="clear"></div>


        <p>
            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
            <button type="submit"
                    class="woocommerce-Button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
                    name="save_account_details"
                    value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>"><?php esc_html_e('Submit', 'woocommerce'); ?></button>
            <input type="hidden" name="action" value="save_account_details"/>
        </p>
    </div>

    <div class="clear"></div>

    <?php
    /**
     * My Account edit account form.
     *
     * @since 2.6.0
     */
    do_action('woocommerce_edit_account_form');
    ?>

    <?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>
