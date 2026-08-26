<?php
/**
 * Programmatic ACF Field Group Registrations (Positioned at Bottom)
 * @package Eliza_Reconnection
 */

if (!defined('ABSPATH')) exit;

add_action('acf/init', 'eliza_register_all_acf_fields');

function eliza_register_all_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) return;

    // Homepage Meta Box (Positioned at Bottom)
    acf_add_local_field_group(array(
        'key' => 'group_eliza_homepage_meta',
        'title' => '✦ Additional Page Options & Media IDs',
        'fields' => array(
            array('key' => 'f_h_book_trailer_id', 'label' => 'Official Book Trailer YouTube Video ID', 'name' => 'book_trailer_youtube_id', 'type' => 'text', 'default_value' => 'VmsQBtoa7h0', 'instructions' => 'YouTube ID for the book trailer video (e.g. VmsQBtoa7h0)'),
            array('key' => 'f_h_int_video_id', 'label' => 'Interview YouTube Video ID', 'name' => 'interview_youtube_id', 'type' => 'text', 'default_value' => 'jJ9U9D2H43I', 'instructions' => 'YouTube ID for the Body & Mind interview (e.g. jJ9U9D2H43I)'),
        ),
        'location' => array(
            array(array('param' => 'page_type', 'operator' => '==', 'value' => 'front_page')),
            array(array('param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php')),
        ),
        'position' => 'normal', // Placed below the visual editor
        'style' => 'default',
        'menu_order' => 10,
        'active' => true,
    ));

    // Global Site Settings Options Page
    acf_add_local_field_group(array(
        'key' => 'group_eliza_site_settings_full',
        'title' => '✦ Site Settings (Global Phone, Email, Address, Socials)',
        'fields' => array(
            array('key' => 'f_opt_phone', 'label' => 'Primary Phone Number', 'name' => 'global_phone', 'type' => 'text', 'default_value' => '082 926 9851'),
            array('key' => 'f_opt_email', 'label' => 'Inquiry Email Address', 'name' => 'global_email', 'type' => 'email', 'default_value' => 'eliza.reconnection@gmail.com'),
            array('key' => 'f_opt_address', 'label' => 'Physical Location', 'name' => 'global_address', 'type' => 'text', 'default_value' => 'Promenade Road, Lakeside, Cape Town, South Africa'),
            array('key' => 'f_opt_footer_bio', 'label' => 'Footer Short Bio', 'name' => 'footer_bio', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Reconnective Healing, Consciousness Coaching, and Meditation & Conscious Breathing — practiced with care from a home office in Lakeside, Cape Town.'),
            array('key' => 'f_opt_facebook', 'label' => 'Facebook URL', 'name' => 'facebook_url', 'type' => 'url', 'default_value' => 'https://www.facebook.com/eliza.james1/'),
            array('key' => 'f_opt_instagram', 'label' => 'Instagram URL', 'name' => 'instagram_url', 'type' => 'url', 'default_value' => 'https://www.instagram.com/eliza.mudita'),
            array('key' => 'f_opt_linkedin', 'label' => 'LinkedIn URL', 'name' => 'linkedin_url', 'type' => 'url', 'default_value' => 'https://www.linkedin.com/in/eliza-james-8789b3109/'),
        ),
        'location' => array(
            array(array('param' => 'options_page', 'operator' => '==', 'value' => 'eliza-site-settings')),
        ),
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));
}
