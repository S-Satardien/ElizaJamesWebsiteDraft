<?php
/**
 * Eliza Reconnection Theme Functions
 * @package Eliza_Reconnection
 */

if (!defined("ABSPATH")) exit;

function eliza_theme_setup() {
    add_theme_support("automatic-feed-links");
    add_theme_support("title-tag");
    add_theme_support("post-thumbnails");
    add_theme_support("align-wide");
    add_theme_support("responsive-embeds");
    add_theme_support("editor-styles");
    add_editor_style("css/styles.css");

    add_theme_support("html5", array("search-form", "comment-form", "comment-list", "gallery", "caption", "style", "script"));
    register_nav_menus(array(
        "primary-menu" => __("Primary Navigation", "eliza-reconnection"),
        "footer-menu"  => __("Footer Navigation", "eliza-reconnection"),
    ));
}
add_action("after_setup_theme", "eliza_theme_setup");

function eliza_theme_scripts() {
    wp_enqueue_style("eliza-google-fonts", "https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap", array(), null);
    wp_enqueue_style("eliza-main-style", get_template_directory_uri() . "/css/styles.css", array(), "1.0.0");
    wp_enqueue_style("eliza-theme-root", get_stylesheet_uri(), array("eliza-main-style"), "1.0.0");
    wp_enqueue_script("eliza-main-js", get_template_directory_uri() . "/js/main.js", array(), "1.0.0", true);
    wp_localize_script("eliza-main-js", "eliza_ajax_obj", array(
        "ajax_url" => admin_url("admin-ajax.php"),
        "nonce"    => wp_create_nonce("eliza_contact_nonce"),
    ));
}
add_action("wp_enqueue_scripts", "eliza_theme_scripts");

// Enqueue fonts in block editor
function eliza_block_editor_assets() {
    wp_enqueue_style("eliza-editor-fonts", "https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap", array(), null);
}
add_action("enqueue_block_editor_assets", "eliza_block_editor_assets");

function eliza_field($name, $default = "", $post_id = false) {
    if (function_exists("get_field")) {
        $val = get_field($name, $post_id);
        if ($val !== null && $val !== "" && $val !== false) return $val;
    }
    return $default;
}

// Contact form AJAX handler
function eliza_handle_contact_ajax() {
    check_ajax_referer("eliza_contact_nonce", "nonce");
    $name    = sanitize_text_field($_POST["name"] ?? "");
    $email   = sanitize_email($_POST["email"] ?? "");
    $phone   = sanitize_text_field($_POST["phone"] ?? "");
    $service = sanitize_text_field($_POST["service"] ?? "");
    $message = sanitize_textarea_field($_POST["message"] ?? "");
    if (!$name || !$email || !$message) {
        wp_send_json_error(array("message" => __("Please complete all required fields.", "eliza-reconnection")));
    }
    $to = eliza_field("global_email", get_option("admin_email"), "option");
    $subject = sprintf("[Website Inquiry] Message from %s", $name);
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nService: $service\n\nMessage:\n$message";
    $headers = array("Content-Type: text/plain; charset=UTF-8", "Reply-To: $name <$email>");
    $sent = wp_mail($to, $subject, $body, $headers);
    if ($sent) {
        wp_send_json_success(array("message" => __("Thank you! Eliza will be in touch with you shortly.", "eliza-reconnection")));
    } else {
        wp_send_json_error(array("message" => __("Message could not be sent right now. Please call directly.", "eliza-reconnection")));
    }
}
add_action("wp_ajax_eliza_contact_submit", "eliza_handle_contact_ajax");
add_action("wp_ajax_nopriv_eliza_contact_submit", "eliza_handle_contact_ajax");
