<div class="woocommerce woocommerce-register-page">
    <h1><?php esc_html_e('Register', 'woocommerce'); ?></h1>
    <p> <?php esc_html_e('Log in to your Beauty Aktivist account to access personalized features, track your activity, and stay up to date with our latest initiatives. Simply enter your registered email and password to sign in. If you’re new, create an account to join our movement and start making an impact.', 'woocommerce'); ?></p>
    <form method="post" class="woocommerce-form woocommerce-form-register register">
        <?php do_action('woocommerce_register_form_start'); ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span
                        class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email"
                   autocomplete="email" placeholder="<?php esc_html_e('Username or email address', 'woocommerce'); ?>"
                   value="<?php echo !empty($_POST['email']) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"/>
        </p>

        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span
                            class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                       id="reg_username" autocomplete="username" placeholder="<?php esc_html_e('Username or email address', 'woocommerce'); ?>"
                       value="<?php echo !empty($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"/>
            </p>
        <?php endif; ?>

        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span
                            class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                       id="reg_password" autocomplete="new-password" placeholder="<?php esc_html_e('Password', 'woocommerce'); ?>"/>
            </p>
        <?php endif; ?>

        <?php do_action('woocommerce_register_form'); ?>
        <p class="woocommerce-form-row form-row">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="woocommerce-Button button" name="register"
                    value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
                <?php esc_html_e('Register', 'woocommerce'); ?>
            </button>
        </p>

        <?php do_action('woocommerce_register_form_end'); ?>
    </form>
</div>