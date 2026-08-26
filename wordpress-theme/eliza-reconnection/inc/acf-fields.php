<?php
/**
 * Programmatic ACF Field Group Definitions
 */
if (!defined('ABSPATH')) exit;

add_action('acf/init', 'eliza_register_acf_field_groups');

function eliza_register_acf_field_groups() {
    if (!function_exists('acf_add_local_field_group')) return;

    // 1. Homepage Field Group
    acf_add_local_field_group(array(
        'key' => 'group_eliza_homepage_edit',
        'title' => '✦ Homepage Sections & Content',
        'fields' => array(
            array('key' => 'tab_hero', 'label' => 'Hero Section', 'type' => 'tab'),
            array('key' => 'field_hero_badge', 'label' => 'Hero Badge Text', 'name' => 'hero_badge', 'type' => 'text', 'default_value' => 'Sacred Alignment · Lakeside, Cape Town'),
            array('key' => 'field_hero_title', 'label' => 'Hero Main Title', 'name' => 'hero_title', 'type' => 'text', 'default_value' => 'Sacred Alignment'),
            array('key' => 'field_hero_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'text', 'default_value' => 'Where Inner Stillness Meets Sacred Power'),
            array('key' => 'field_hero_lede', 'label' => 'Hero Lead Quote / Lede', 'name' => 'hero_lede', 'type' => 'textarea', 'rows' => 3, 'default_value' => '“We are each Miraculous Works of Art in this amazing tapestry called Life. Allow me to guide you toward experiencing this Life Journey in a meaningful way, to gently hold the space as you step onto your unique path toward the unfolding of your Becoming.”'),
            array('key' => 'field_hero_btn1_text', 'label' => 'Primary Button Text', 'name' => 'hero_btn1_text', 'type' => 'text', 'default_value' => 'Book a session'),
            array('key' => 'field_hero_btn2_text', 'label' => 'Secondary Button Text', 'name' => 'hero_btn2_text', 'type' => 'text', 'default_value' => 'Explore Book & Trailer'),
            array('key' => 'field_hero_image', 'label' => 'Hero Portrait Image', 'name' => 'hero_image', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'field_hero_float_badge', 'label' => 'Portrait Floating Badge Text', 'name' => 'hero_float_badge', 'type' => 'text', 'default_value' => 'Since 2011 · Lakeside, Cape Town'),

            array('key' => 'tab_bio', 'label' => 'Biography & Logistics', 'type' => 'tab'),
            array('key' => 'field_bio_portrait', 'label' => 'Biography Portrait Image', 'name' => 'bio_portrait', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'field_bio_workshop_image', 'label' => 'Workshop Presentation Photo', 'name' => 'bio_workshop_image', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'field_bio_logistics_text', 'label' => 'Session Logistics Hours Notice', 'name' => 'bio_logistics_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Available weekdays after 6pm and weekends from 3pm by appointment in Lakeside, Cape Town or via distant session.'),

            array('key' => 'tab_book', 'label' => 'Published Book & Trailer', 'type' => 'tab'),
            array('key' => 'field_book_title', 'label' => 'Book Title', 'name' => 'book_title', 'type' => 'text', 'default_value' => 'A Most Extraordinary Journey of Self-Discovery'),
            array('key' => 'field_book_subtitle', 'label' => 'Book Subtitle', 'name' => 'book_subtitle', 'type' => 'text', 'default_value' => 'A 9-Year Spiritual Journey with the Enigmatic Comte de St Germain · By Eliza James'),
            array('key' => 'field_book_badge', 'label' => 'Book Genre Badge', 'name' => 'book_badge', 'type' => 'text', 'default_value' => 'Spiritual Biography · Metaphysical Wisdom'),
            array('key' => 'field_book_lead_quote', 'label' => 'Book Lead Quote', 'name' => 'book_lead_quote', 'type' => 'textarea', 'rows' => 2, 'default_value' => '“Being a student and friend of St Germain is what brings me the most joy. My 9-year Spiritual Journey with the enigmatic Comte de St Germain is shared with the world in this work.”'),
            array('key' => 'field_book_synopsis', 'label' => 'Book Synopsis / Description', 'name' => 'book_synopsis', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'In this deeply personal and transformative book, Eliza chronicles her extraordinary nine-year communion with the Ascended Master, the enigmatic Comte de St Germain. Spanning deep metaphysical revelations, the dawning of the Age of Aquarius, and the sacred truth of personal sovereignty, the book serves as a guiding light for anyone seeking to uncover the truth of who they really are.'),
            array('key' => 'field_book_trailer_youtube_id', 'label' => 'Official Book Trailer YouTube Video ID', 'name' => 'book_trailer_youtube_id', 'type' => 'text', 'default_value' => 'VmsQBtoa7h0'),

            array('key' => 'tab_interview', 'label' => 'In Conversation Interview', 'type' => 'tab'),
            array('key' => 'field_interview_title', 'label' => 'Interview Title', 'name' => 'interview_title', 'type' => 'text', 'default_value' => 'In Conversation: Sacred Alignment'),
            array('key' => 'field_interview_subtitle', 'label' => 'Interview Subtitle', 'name' => 'interview_subtitle', 'type' => 'text', 'default_value' => 'An In-Depth Interview with Body and Mind · Frequencies, Remoteness & Inner Unfolding'),
            array('key' => 'field_interview_badge', 'label' => 'Interview Guest Badge', 'name' => 'interview_badge', 'type' => 'text', 'default_value' => 'Body & Mind South Africa · Featured Guest'),
            array('key' => 'field_interview_lead_quote', 'label' => 'Interview Lead Quote', 'name' => 'interview_lead_quote', 'type' => 'textarea', 'rows' => 2, 'default_value' => '“Spirit has no boundaries or borders — we touch on the essence of frequency elevation, remote healing, and holding the space for your becoming.”'),
            array('key' => 'field_interview_narrative', 'label' => 'Interview Narrative Paragraph', 'name' => 'interview_narrative', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'In this heart-centered conversation, Eliza shares the origins of her journey—from deeply contemplating spiritual doctrines at age sixteen to her nine-year tutelage with the Ascended Master St Germain. We touch on the essence of Reconnective Healing (RH), the inner transformation that comes with elevating the frequency at which you vibrate, and what it means to hold space for your unique unfolding.'),
            array('key' => 'field_interview_case_study', 'label' => 'Groote Schuur Hospital Remote Healing Case Study', 'name' => 'interview_case_study', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'One of my most remarkable remote healing sessions had a team of Specialists at the world-renowned Groote Schuur Hospital (Cape Town, South Africa) stumped when their patient, after remotely administered RH sessions, no longer presented symptoms of an illness for which he was scheduled to go into a 6-month period of strict quarantine.'),
            array('key' => 'field_interview_youtube_id', 'label' => 'Interview YouTube Video ID', 'name' => 'interview_youtube_id', 'type' => 'text', 'default_value' => 'jJ9U9D2H43I'),
        ),
        'location' => array(
            array(array('param' => 'page_type', 'operator' => '==', 'value' => 'front_page')),
            array(array('param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php')),
            array(array('param' => 'post_type', 'operator' => '==', 'value' => 'page')),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

    // 2. Global Site Settings & Contact Info (Options Page)
    acf_add_local_field_group(array(
        'key' => 'group_eliza_site_settings',
        'title' => '✦ Global Site Settings & Contact Information',
        'fields' => array(
            array('key' => 'field_opt_phone', 'label' => 'Primary Phone Number', 'name' => 'global_phone', 'type' => 'text', 'default_value' => '082 926 9851'),
            array('key' => 'field_opt_email', 'label' => 'Inquiry Email Address', 'name' => 'global_email', 'type' => 'email', 'default_value' => 'eliza.reconnection@gmail.com'),
            array('key' => 'field_opt_address', 'label' => 'Physical / Office Location', 'name' => 'global_address', 'type' => 'text', 'default_value' => 'Promenade Road, Lakeside, Cape Town, South Africa'),
            array('key' => 'field_opt_footer_bio', 'label' => 'Footer Short Bio', 'name' => 'footer_bio', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Reconnective Healing, Consciousness Coaching, and Meditation & Conscious Breathing — practiced with care from a home office in Lakeside, Cape Town.'),
            array('key' => 'field_opt_facebook', 'label' => 'Facebook Profile URL', 'name' => 'facebook_url', 'type' => 'url', 'default_value' => 'https://www.facebook.com/eliza.james1/'),
            array('key' => 'field_opt_instagram', 'label' => 'Instagram Profile URL', 'name' => 'instagram_url', 'type' => 'url', 'default_value' => 'https://www.instagram.com/eliza.mudita'),
            array('key' => 'field_opt_linkedin', 'label' => 'LinkedIn Profile URL', 'name' => 'linkedin_url', 'type' => 'url', 'default_value' => 'https://www.linkedin.com/in/eliza-james-8789b3109/'),
        ),
        'location' => array(
            array(array('param' => 'options_page', 'operator' => '==', 'value' => 'eliza-site-settings')),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

    // 3. About Us Page Fields
    acf_add_local_field_group(array(
        'key' => 'group_eliza_about_page',
        'title' => '✦ About Us & Sacred Journey Content',
        'fields' => array(
            array('key' => 'field_about_hero_title', 'label' => 'Hero Title', 'name' => 'about_hero_title', 'type' => 'text', 'default_value' => 'About Eliza & Her Sacred Journey'),
            array('key' => 'field_about_hero_lede', 'label' => 'Hero Lead Quote', 'name' => 'about_hero_lede', 'type' => 'textarea', 'rows' => 2, 'default_value' => '“I consider myself an ordinary individual grounded in the realities of daily life — on a quest to uncover the deep truth of who I really am.”'),
            array('key' => 'field_about_portrait', 'label' => 'About Page Portrait Image', 'name' => 'about_portrait', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'field_about_group_image', 'label' => 'Group Session / Vision Photo', 'name' => 'about_group_image', 'type' => 'image', 'return_format' => 'url'),
        ),
        'location' => array(
            array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php')),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

    // 4. Services & Modalities Page Fields
    acf_add_local_field_group(array(
        'key' => 'group_eliza_services_page',
        'title' => '✦ Services & Modalities Content',
        'fields' => array(
            array('key' => 'field_services_hero_title', 'label' => 'Hero Title', 'name' => 'services_hero_title', 'type' => 'text', 'default_value' => 'Services & Coaching'),
            array('key' => 'field_services_hero_lede', 'label' => 'Hero Lead Quote', 'name' => 'services_hero_lede', 'type' => 'textarea', 'rows' => 2, 'default_value' => '“Allow me to guide you toward experiencing this Life Journey in a meaningful way, to gently hold the space as you step onto your unique path toward the unfolding of your Becoming.”'),
        ),
        'location' => array(
            array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-services.php')),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));
}
