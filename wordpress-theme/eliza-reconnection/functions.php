<?php
/**
 * Eliza Reconnection Theme Functions
 * @package Eliza_Reconnection
 */

if (!defined('ABSPATH')) exit;

function eliza_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('editor-styles');
    add_editor_style('css/styles.css');

    register_nav_menus(array(
        'primary-menu' => __('Primary Navigation Menu', 'eliza-reconnection'),
    ));
}
add_action('after_setup_theme', 'eliza_theme_setup');

/**
 * Safe helper to retrieve ACF field with fallback default
 */
function eliza_field($field_name, $default = '', $post_id = false) {
    if (function_exists('get_field')) {
        $val = get_field($field_name, $post_id);
        if ($val !== null && $val !== '' && $val !== false) {
            return $val;
        }
    }
    return $default;
}

function eliza_enqueue_scripts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap', array(), null);
    wp_enqueue_style('eliza-styles', get_template_directory_uri() . '/css/styles.css', array(), '1.1.0');

    wp_enqueue_script('eliza-main-js', get_template_directory_uri() . '/js/main.js', array(), '1.1.0', true);

    wp_localize_script('eliza-main-js', 'eliza_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('eliza_contact_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'eliza_enqueue_scripts');

// =========================================================================
// GLOBAL COMMENT DISABLING (Comments 100% Closed on Posts, Pages, & Admin)
// =========================================================================
add_action('admin_init', function () {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2);
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

// =========================================================================
// CONTACT FORM AJAX HANDLER WITH MULTI-LAYER BOT & SPAM PROTECTION
// =========================================================================
function eliza_handle_contact_ajax() {
    check_ajax_referer('eliza_contact_nonce', 'nonce');

    // 1. HONEYPOT TRAP: Bots fill invisible fields automatically
    $honeypot = trim($_POST['hp_website'] ?? '');
    if (!empty($honeypot)) {
        // Silently terminate bot without sending email
        wp_send_json_success(array('message' => 'Thank you! Your message has been received.'));
    }

    // 2. TIME-GATE PROTECTION: Submissions < 1.5 seconds are automated bots
    $form_start_time = intval($_POST['form_timestamp'] ?? 0);
    $current_time = time();
    if ($form_start_time > 0 && ($current_time - $form_start_time) < 2) {
        wp_send_json_error(array('message' => 'Submission rejected: form completed too quickly. Please try again.'));
    }

    // 3. RATE LIMITING: Max 5 submissions per 15 minutes per IP address
    $ip_address = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    $rate_key = 'eliza_cf_rate_' . md5($ip_address);
    $attempts = (int) get_transient($rate_key);
    if ($attempts > 5) {
        wp_send_json_error(array('message' => 'Too many inquiries sent from this device. Please call directly at 082 926 9851.'));
    }
    set_transient($rate_key, $attempts + 1, 15 * MINUTE_IN_SECONDS);

    // 4. SANITIZATION & VALIDATION
    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (!$name || !$email || !$message || !is_email($email)) {
        wp_send_json_error(array('message' => __('Please provide a valid name, email address, and message.', 'eliza-reconnection')));
    }

    // Prevent Header / Email Injection
    $name = str_replace(array("\r", "\n"), '', $name);
    $email = str_replace(array("\r", "\n"), '', $email);

    $to = eliza_field('global_email', get_option('admin_email'), 'option');
    $subject = sprintf('[Website Inquiry] Message from %s', $name);
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nService Requested: $service\nIP: $ip_address\n\nMessage:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>');

    $sent = wp_mail($to, $subject, $body, $headers);
    if ($sent) {
        wp_send_json_success(array('message' => __('Thank you! Eliza will be in touch with you shortly.', 'eliza-reconnection')));
    } else {
        wp_send_json_error(array('message' => __('Message could not be sent right now. Please call directly at 082 926 9851.', 'eliza-reconnection')));
    }
}
add_action('wp_ajax_eliza_contact_submit', 'eliza_handle_contact_ajax');
add_action('wp_ajax_nopriv_eliza_contact_submit', 'eliza_handle_contact_ajax');

// Load Programmatic ACF Field Groups
require_once get_template_directory() . '/inc/acf-fields.php';

// Load Frontend Live Visual Editor
require_once get_template_directory() . '/inc/live-editor.php';
