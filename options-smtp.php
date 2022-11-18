<?php

if (!defined('ABSPATH')) {
    exit; // exit if accessed directly
}

if (isset($_POST['wp_simple_smtp_save_settings'])) {
    update_option(WP_SIMPLE_SMTP_HOST, $_POST[WP_SIMPLE_SMTP_HOST]);
    update_option(WP_SIMPLE_SMTP_PORT, $_POST[WP_SIMPLE_SMTP_PORT]);
    update_option(WP_SIMPLE_SMTP_FROM_NAME, $_POST[WP_SIMPLE_SMTP_FROM_NAME]);
    update_option(WP_SIMPLE_SMTP_FROM_ADDRESS, $_POST[WP_SIMPLE_SMTP_FROM_ADDRESS]);
    update_option(WP_SIMPLE_SMTP_USERNAME, $_POST[WP_SIMPLE_SMTP_USERNAME]);
    update_option(WP_SIMPLE_SMTP_PASSWORD, $_POST[WP_SIMPLE_SMTP_PASSWORD]);

    if (isset($_POST[WP_SIMPLE_SMTP_ENCRYPTION])) {
        // check if is valid selection
        if (in_array($_POST[WP_SIMPLE_SMTP_ENCRYPTION], ['ssl', 'tls', 'none'])) {
            update_option(WP_SIMPLE_SMTP_ENCRYPTION, $_POST[WP_SIMPLE_SMTP_ENCRYPTION]);
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>' . __("Invalid encryption selection", "wp-simple-smtp") . '</p></div>';
        }
    }

    update_option('wp_simple_smtp_enabled', $_POST['wp_simple_smtp_enabled']);

    echo '<div class="notice notice-success is-dismissible"><p>' . __("SMTP settings saved", "wp-simple-smtp") . '</p></div>';
}

?>

<form method="post" action="options-general.php?page=wp-simple-smtp">
    <table class="form-table">
        <tr>
            <th scope="row">
                <?php _e("Enable SMTP", "wp-simple-smtp"); ?>
            </th>
            <td><input type="checkbox" name="<?php echo WP_SIMPLE_SMTP_ENABLED; ?>"
                    value="1" ' . checked(1, get_option(WP_SIMPLE_SMTP_ENABLED), false) . ' /></td>
        </tr>

        <tr>
            <th scope="row">
                <?php _e("From Name", "wp-simple-smtp"); ?>
            </th>
            <td><input type="text" name="<?php echo WP_SIMPLE_SMTP_FROM_NAME; ?>"
                    value="<?php echo esc_attr(get_option(WP_SIMPLE_SMTP_FROM_NAME)); ?>" /></td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e("From Address", "wp-simple-smtp"); ?>
            </th>
            <td><input type="email" name="<?php echo WP_SIMPLE_SMTP_FROM_ADDRESS; ?>"
                    value="<?php echo esc_attr(get_option(WP_SIMPLE_SMTP_FROM_ADDRESS)); ?>" /></td>
        </tr>

        <tr>
            <th scope="row">
                <?php _e("Host", "wp-simple-smtp"); ?>
            </th>
            <td><input type="text" name="<?php echo WP_SIMPLE_SMTP_HOST; ?>"
                    value="<?php echo esc_attr(get_option(WP_SIMPLE_SMTP_HOST)); ?>" /></td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e("Port", "wp-simple-smtp"); ?>
            </th>
            <td><input type="number" min="1" max="65535" name="<?php echo WP_SIMPLE_SMTP_PORT; ?>"
                    value="<?php echo esc_attr(get_option(WP_SIMPLE_SMTP_PORT)); ?>" /></td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e("Username", "wp-simple-smtp"); ?>
            </th>
            <td><input type="text" name="<?php echo WP_SIMPLE_SMTP_USERNAME; ?>"
                    value="<?php echo esc_attr(get_option(WP_SIMPLE_SMTP_USERNAME)); ?>" /></td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e("Password", "wp-simple-smtp"); ?>
            </th>
            <td><input type="password" name="<?php echo WP_SIMPLE_SMTP_PASSWORD; ?>"
                    value="<?php echo esc_attr(get_option(WP_SIMPLE_SMTP_PASSWORD)); ?>" /></td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e("Encryption", "wp-simple-smtp"); ?>
            </th>
            <td>
                <select name="<?php echo WP_SIMPLE_SMTP_ENCRYPTION; ?>">
                    <?php
                    echo '<option value="none" ' . selected('none', get_option(WP_SIMPLE_SMTP_ENCRYPTION), false) . '>' . __("No Encryption", "wp-simple-smtp") . '</option>';
                    echo '<option value="tls" ' . selected('tls', get_option(WP_SIMPLE_SMTP_ENCRYPTION), false) . '>TLS</option>';
                    echo '<option value="ssl" ' . selected('ssl', get_option(WP_SIMPLE_SMTP_ENCRYPTION), false) . '>SSL</option>';
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <?php submit_button(__("Save Settings", "wp-simple-smtp"), "primary", "wp_simple_smtp_save_settings") ?>
</form>