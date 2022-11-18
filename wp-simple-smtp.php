<?php
/**
 * Plugin Name: WP Simple SMTP
 * Description: Adding option for mail delivery via SMTP
 * Author: Mario Kernich
 * Version: 1.0.0
 * Author URI: https://marioke.dev
 * Text Domain: wp-simple-smtp
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Repository: https://github.com/marioke/wp-simple-smtp
 */

if (!defined('ABSPATH')) {
    exit; // exit if accessed directly
}

const WP_SIMPLE_SMTP_HOST = 'wp_simple_smtp_host';
const WP_SIMPLE_SMTP_PORT = 'wp_simple_smtp_port';
const WP_SIMPLE_SMTP_USERNAME = 'wp_simple_smtp_username';
const WP_SIMPLE_SMTP_PASSWORD = 'wp_simple_smtp_password';
const WP_SIMPLE_SMTP_ENCRYPTION = 'wp_simple_smtp_encryption';
const WP_SIMPLE_SMTP_FROM_NAME = 'wp_simple_smtp_from_name';
const WP_SIMPLE_SMTP_FROM_ADDRESS = 'wp_simple_smtp_from_address';
const WP_SIMPLE_SMTP_FROM_EMAIL = 'wp_simple_smtp_from_email';
const WP_SIMPLE_SMTP_ENABLED = 'wp_simple_smtp_enabled';

/**
 * register page for settings
 */
add_action('admin_menu', static function () {
    add_options_page(
        'WP Simple SMTP',
        __("Mail delivery", "wp-simple-smtp"),
        'manage_options',
        'wp-simple-smtp',
        static function () {
            require_once 'options-wrapper.php';
        },
        3
    );
});

/**
 * load text domain
 */
add_action('plugins_loaded', static function () {
    load_plugin_textdomain(
        'wp-simple-smtp',
        false,
        basename(__DIR__) . '/languages'
    );
});

/**
 * register settings for database
 */
add_action('admin_init', static function () {

    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_HOST);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_PORT);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_USERNAME);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_PASSWORD);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_ENCRYPTION);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_FROM_NAME);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_FROM_ADDRESS);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_FROM_EMAIL);
    register_setting('wp-simple-smtp', WP_SIMPLE_SMTP_ENABLED);

});

/**
 * add settings link to plugin page
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), static function ($links) {

    $links[] = '<a href="options-general.php?page=wp-simple-smtp">' . __("Settings", "wp-simple-smtp") . '</a>';
    return $links;

});

/**
 * inject the SMTP settings into the PHPMailer if enabled
 */
if (get_option(WP_SIMPLE_SMTP_ENABLED)) {

    /**
     * override default smtp from name
     */
    add_filter('wp_mail_from', static function () {
        return get_option(WP_SIMPLE_SMTP_FROM_NAME);
    });

    /**
     * override default smtp from address
     */
    add_filter('wp_mail_from_name', static function () {
        return get_option(WP_SIMPLE_SMTP_FROM_ADDRESS);
    });

    /**
     * override default smtp settings
     */
    add_action('phpmailer_init', static function ($phpmailer) {
        $phpmailer->IsSMTP();
        $phpmailer->Host = get_option(WP_SIMPLE_SMTP_HOST);
        $phpmailer->Port = get_option(WP_SIMPLE_SMTP_PORT);
        $phpmailer->From = get_option(WP_SIMPLE_SMTP_FROM_ADDRESS);
        $phpmailer->FromName = get_option(WP_SIMPLE_SMTP_FROM_NAME);
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = get_option(WP_SIMPLE_SMTP_USERNAME);
        $phpmailer->Password = get_option(WP_SIMPLE_SMTP_PASSWORD);
        $phpmailer->SMTPSecure = get_option(WP_SIMPLE_SMTP_ENCRYPTION);
        $phpmailer->Mailer = 'smtp';
        $phpmailer->ClearReplyTos();
        $phpmailer->addReplyTo(get_option(WP_SIMPLE_SMTP_FROM_NAME), get_option(WP_SIMPLE_SMTP_FROM_ADDRESS));
    });

}