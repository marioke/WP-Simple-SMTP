<?php

if (!defined('ABSPATH')) {
    exit; // exit if accessed directly
}

const WP_SIMPLE_TEST_SUBMIT = "wp_simple_mail_test_submit";
const WP_SIMPLE_TEST_EMAIL = "wp_simple_mail_test_email";

if (isset($_POST[WP_SIMPLE_TEST_SUBMIT])) {
    $to = $_POST[WP_SIMPLE_TEST_EMAIL];
    wp_simple_smtp_test($to);
}

/**
 * Process test mail send
 * @param string $to email address
 * @return void
 */
function wp_simple_smtp_test(string $to): void
{
    // check if email is valid
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        // show error message and exit function
        echo '<div class="notice notice-error is-dismissible"><p>' .
            __("Invalid email address", "wp-simple-smtp") .
            '</p></div>';
        return;
    }

    // prepare mail
    $subject = __("Test email from WP Simple SMTP", "wp-simple-smtp");
    $message = __("This is a test email from WP Simple SMTP", "wp-simple-smtp");
    $headers = array('Content-Type: text/html; charset=UTF-8');

    // send mail and check if it was successful
    $result = wp_mail($to, $subject, $message, $headers);

    if ($result) {
        echo '<div class="notice notice-success is-dismissible"><p>' .
            __("Test email sent", "wp-simple-smtp") .
            '</p></div>';
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>' .
            __("Test email failed. Please ensure the given SMTP configuration is set correctly", "wp-simple-smtp") .
            '</p></div>';
    }
}

?>

<h3>
    <?php _e("Test E-Mail", "wp-simple-smtp"); ?>
</h3>
<p>
    <?php _e("Test deine SMTP Konfiguration durch den Versand einer Test E-Mail", "wp-simple-smtp"); ?>
</p>
<form method="post" action="options-general.php?page=wp-simple-smtp">
    <table class="form-table">
        <tr>
            <th scope="row">
                <?php _e("Email", "wp-simple-smtp"); ?>
            </th>
            <td><input type="email" name="<?php echo WP_SIMPLE_TEST_EMAIL; ?>"
                    value="<?php echo esc_attr(get_option('wp_simple_smtp_test_email')); ?>" /></td>
        </tr>
    </table>
    <?php submit_button(__("Send test mail", "wp-simple-smtp"), 'secondary', WP_SIMPLE_TEST_SUBMIT); ?>
</form>