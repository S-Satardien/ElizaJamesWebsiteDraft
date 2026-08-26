<?php
/**
 * Complete Programmatic ACF Field Group Registrations
 * @package Eliza_Reconnection
 */

if (!defined('ABSPATH')) exit;

add_action('acf/init', 'eliza_register_all_acf_fields');

function eliza_register_all_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) return;

    // ======================================================
    // 1. Homepage Field Group (All 7 Sections)
    // ======================================================
    acf_add_local_field_group(array(
        'key' => 'group_eliza_homepage_full',
        'title' => '✦ Homepage: Complete Content & Copy Editor',
        'fields' => array(
            // --- TAB 1: HERO SECTION ---
            array('key' => 'tab_h_hero', 'label' => '1. Hero Section', 'type' => 'tab'),
            array('key' => 'f_h_hero_badge', 'label' => 'Hero Eyebrow Badge', 'name' => 'hero_badge', 'type' => 'text', 'default_value' => 'Sacred Alignment · Lakeside, Cape Town'),
            array('key' => 'f_h_hero_title', 'label' => 'Hero Main Title', 'name' => 'hero_title', 'type' => 'text', 'default_value' => 'Sacred Alignment'),
            array('key' => 'f_h_hero_subtitle', 'label' => 'Hero Subtitle', 'name' => 'hero_subtitle', 'type' => 'text', 'default_value' => 'Where Inner Stillness Meets Sacred Power'),
            array('key' => 'f_h_hero_lede', 'label' => 'Hero Lead Quote', 'name' => 'hero_lede', 'type' => 'textarea', 'rows' => 3, 'default_value' => '“We are each Miraculous Works of Art in this amazing tapestry called Life. Allow me to guide you toward experiencing this Life Journey in a meaningful way, to gently hold the space as you step onto your unique path toward the unfolding of your Becoming.”'),
            array('key' => 'f_h_hero_btn1_text', 'label' => 'Primary CTA Button Label', 'name' => 'hero_btn1_text', 'type' => 'text', 'default_value' => 'Book a session'),
            array('key' => 'f_h_hero_btn1_url', 'label' => 'Primary CTA Button Link URL', 'name' => 'hero_btn1_url', 'type' => 'text', 'default_value' => '/contact/'),
            array('key' => 'f_h_hero_btn2_text', 'label' => 'Secondary CTA Button Label', 'name' => 'hero_btn2_text', 'type' => 'text', 'default_value' => 'Explore Book & Trailer'),
            array('key' => 'f_h_hero_btn2_url', 'label' => 'Secondary CTA Button Link URL', 'name' => 'hero_btn2_url', 'type' => 'text', 'default_value' => '#book'),
            array('key' => 'f_h_hero_image', 'label' => 'Hero Portrait Photo', 'name' => 'hero_image', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'f_h_hero_float_badge', 'label' => 'Portrait Floating Badge Text', 'name' => 'hero_float_badge', 'type' => 'text', 'default_value' => 'Since 2011 · Lakeside, Cape Town'),

            // --- TAB 2: BIOGRAPHY ---
            array('key' => 'tab_h_bio', 'label' => '2. Biography', 'type' => 'tab'),
            array('key' => 'f_h_bio_eyebrow', 'label' => 'Biography Eyebrow', 'name' => 'bio_eyebrow', 'type' => 'text', 'default_value' => 'About Eliza'),
            array('key' => 'f_h_bio_title', 'label' => 'Biography Heading', 'name' => 'bio_title', 'type' => 'text', 'default_value' => 'Biography'),
            array('key' => 'f_h_bio_portrait', 'label' => 'Biography Column Portrait', 'name' => 'bio_portrait', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'f_h_bio_p1', 'label' => 'Bio Paragraph 1 (Education & Background)', 'name' => 'bio_p1', 'type' => 'textarea', 'rows' => 4, 'default_value' => "I am a graduate of the University of Cape Town Graduate School of Business; an experienced Reconnective Healing Practitioner (having added the skill of presenting Meditation and Conscious Breathing Workshops into the mix). Conversational or presenting the more structured Life Coaching Workshops is second nature and I resonate strongly with the work of Drs Hurtak (Academy for Future Science). However, being a student and friend of St Germain is what brings me the most joy. My 9-year Spiritual Journey with the enigmatic Comte de St Germain was recently shared with the world in my internationally published work (A Most Extraordinary Journey of Self-discovery)."),
            array('key' => 'f_h_bio_p2', 'label' => 'Bio Paragraph 2 (Grounding & Human Reality)', 'name' => 'bio_p2', 'type' => 'textarea', 'rows' => 4, 'default_value' => "I consider myself an ordinary individual, grounded in the realities of daily life. I am a mother, a colleague, a friend and a sibling - someone who laughs with abandon, sheds tears unashamedly, feels the full spectrum of emotions, and loves fiercely. I am not immune to the world's hardships and the harsh realities of corruption, inequality, and inhumanity. And yes, I often voice my frustration with a heartfelt, “What the f#ck!”"),
            array('key' => 'f_h_bio_p3', 'label' => 'Bio Paragraph 3 (The Quest for Truth)', 'name' => 'bio_p3', 'type' => 'textarea', 'rows' => 4, 'default_value' => "I've always had this sense that “there must be more to life” than what the status quo offers - that there is a greater truth beyond what most people settle for. My hunger for understanding has led me to seminars, books, and teachings that dive into the mysteries of the world. These steps are not just intellectual - each step is a quest to know the Self more deeply, to uncover the truth of who I really am. I believe that true freedom comes from self-awareness, and that the journey is most enlightening when guided by wisdom and clarity."),
            array('key' => 'f_h_bio_p4', 'label' => 'Bio Paragraph 4 (Age of Aquarius & Power)', 'name' => 'bio_p4', 'type' => 'textarea', 'rows' => 4, 'default_value' => "In these shifting times, I fully embrace the dawning of the Age of Aquarius - a time when the individual is called to take full responsibility for their own path. With courage, understanding, and consciousness. And so I urge others to step into their power and experience life with intention and self-awareness. For me, the human journey is not one to be left to chance; it is something to be consciously directed and lived to its fullest potential."),
            array('key' => 'f_h_bio_workshop_img', 'label' => 'Workshop Presentation Photo', 'name' => 'bio_workshop_image', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'f_h_bio_photo_badge', 'label' => 'Workshop Photo Badge', 'name' => 'bio_photo_badge', 'type' => 'text', 'default_value' => '✦ Interactive Workshops & Mentorship'),
            array('key' => 'f_h_bio_photo_caption', 'label' => 'Workshop Photo Caption', 'name' => 'bio_photo_caption', 'type' => 'text', 'default_value' => 'Guiding seekers, students, and professionals toward conscious self-mastery.'),
            array('key' => 'f_h_bio_logistics_title', 'label' => 'Logistics Box Title', 'name' => 'bio_logistics_title', 'type' => 'text', 'default_value' => 'Session Logistics & Inquiries'),
            array('key' => 'f_h_bio_logistics_text', 'label' => 'Logistics Box Notice', 'name' => 'bio_logistics_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Available weekdays after 6pm and weekends from 3pm by appointment in Lakeside, Cape Town or via distant session.'),

            // --- TAB 3: SERVICES TRIPTYCH ---
            array('key' => 'tab_h_services', 'label' => '3. Offerings & Modalities', 'type' => 'tab'),
            array('key' => 'f_h_serv_eyebrow', 'label' => 'Services Eyebrow', 'name' => 'serv_eyebrow', 'type' => 'text', 'default_value' => 'Offerings & Modalities'),
            array('key' => 'f_h_serv_title', 'label' => 'Services Section Title', 'name' => 'serv_title', 'type' => 'text', 'default_value' => 'A Symphony of Energy, Mind & Breath'),
            array('key' => 'f_h_serv_intro', 'label' => 'Services Section Subtitle', 'name' => 'serv_intro', 'type' => 'text', 'default_value' => 'Harmonizing physical vitality, cognitive clarity, and spiritual awareness.'),

            // --- TAB 4: PUBLISHED BOOK ---
            array('key' => 'tab_h_book', 'label' => '4. Published Book & Trailer', 'type' => 'tab'),
            array('key' => 'f_h_book_eyebrow', 'label' => 'Book Eyebrow', 'name' => 'book_eyebrow', 'type' => 'text', 'default_value' => '✦ Internationally Published Work'),
            array('key' => 'f_h_book_title', 'label' => 'Book Title', 'name' => 'book_title', 'type' => 'text', 'default_value' => 'A Most Extraordinary Journey of Self-Discovery'),
            array('key' => 'f_h_book_subtitle', 'label' => 'Book Subtitle', 'name' => 'book_subtitle', 'type' => 'text', 'default_value' => 'A 9-Year Spiritual Journey with the Enigmatic Comte de St Germain · By Eliza James'),
            array('key' => 'f_h_book_badge', 'label' => 'Book Genre Badge', 'name' => 'book_badge', 'type' => 'text', 'default_value' => 'Spiritual Biography · Metaphysical Wisdom'),
            array('key' => 'f_h_book_lead_quote', 'label' => 'Book Lead Quote', 'name' => 'book_lead_quote', 'type' => 'textarea', 'rows' => 2, 'default_value' => '“Being a student and friend of St Germain is what brings me the most joy. My 9-year Spiritual Journey with the enigmatic Comte de St Germain is shared with the world in this work.”'),
            array('key' => 'f_h_book_synopsis', 'label' => 'Book Synopsis', 'name' => 'book_synopsis', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'In this deeply personal and transformative book, Eliza chronicles her extraordinary nine-year communion with the Ascended Master, the enigmatic Comte de St Germain. Spanning deep metaphysical revelations, the dawning of the Age of Aquarius, and the sacred truth of personal sovereignty, the book serves as a guiding light for anyone seeking to uncover the truth of who they really are.'),
            array('key' => 'f_h_book_trailer_id', 'label' => 'YouTube Trailer Video ID', 'name' => 'book_trailer_youtube_id', 'type' => 'text', 'default_value' => 'VmsQBtoa7h0'),

            // --- TAB 5: INTERVIEW ---
            array('key' => 'tab_h_interview', 'label' => '5. In Conversation Interview', 'type' => 'tab'),
            array('key' => 'f_h_int_eyebrow', 'label' => 'Interview Eyebrow', 'name' => 'interview_eyebrow', 'type' => 'text', 'default_value' => '✦ Featured In-Depth Dialogue'),
            array('key' => 'f_h_int_title', 'label' => 'Interview Title', 'name' => 'interview_title', 'type' => 'text', 'default_value' => 'In Conversation: Sacred Alignment'),
            array('key' => 'f_h_int_subtitle', 'label' => 'Interview Subtitle', 'name' => 'interview_subtitle', 'type' => 'text', 'default_value' => 'An In-Depth Interview with Body and Mind · Frequencies, Remoteness & Inner Unfolding'),
            array('key' => 'f_h_int_badge', 'label' => 'Interview Guest Badge', 'name' => 'interview_badge', 'type' => 'text', 'default_value' => 'Body & Mind South Africa · Featured Guest'),
            array('key' => 'f_h_int_lead_quote', 'label' => 'Interview Lead Quote', 'name' => 'interview_lead_quote', 'type' => 'textarea', 'rows' => 2, 'default_value' => '“Spirit has no boundaries or borders — we touch on the essence of frequency elevation, remote healing, and holding the space for your becoming.”'),
            array('key' => 'f_h_int_narrative', 'label' => 'Interview Narrative Paragraph', 'name' => 'interview_narrative', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'In this heart-centered conversation, Eliza shares the origins of her journey—from deeply contemplating spiritual doctrines at age sixteen to her nine-year tutelage with the Ascended Master St Germain. We touch on the essence of Reconnective Healing (RH), the inner transformation that comes with elevating the frequency at which you vibrate, and what it means to hold space for your unique unfolding.'),
            array('key' => 'f_h_int_case_study', 'label' => 'Groote Schuur Hospital Remote Case Study Text', 'name' => 'interview_case_study', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'One of my most remarkable remote healing sessions had a team of Specialists at the world-renowned Groote Schuur Hospital (Cape Town, South Africa) stumped when their patient, after remotely administered RH sessions, no longer presented symptoms of an illness for which he was scheduled to go into a 6-month period of strict quarantine.'),
            array('key' => 'f_h_int_video_id', 'label' => 'YouTube Interview Video ID', 'name' => 'interview_youtube_id', 'type' => 'text', 'default_value' => 'jJ9U9D2H43I'),

            // --- TAB 6: CTA BAND ---
            array('key' => 'tab_h_cta', 'label' => '6. Tea Chat CTA Band', 'type' => 'tab'),
            array('key' => 'f_h_cta_title', 'label' => 'CTA Headline', 'name' => 'cta_title', 'type' => 'text', 'default_value' => "Do call me – let's have an informal chat over a cup of tea"),
            array('key' => 'f_h_cta_p1', 'label' => 'CTA Body Paragraph', 'name' => 'cta_p1', 'type' => 'textarea', 'rows' => 2, 'default_value' => "I am sure you have lots of questions and you will be under no obligation to then book a session. Psssssttt – really, I don't charge \"an arm and a leg\" for a 30 minute session."),
            array('key' => 'f_h_cta_quote', 'label' => 'CTA Sacred Quote', 'name' => 'cta_quote', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'You are alive to give voice, action and physicality to GOD. To become the grandest version of the greatest vision you hold about Who You Are.'),
        ),
        'location' => array(
            array(array('param' => 'page_type', 'operator' => '==', 'value' => 'front_page')),
            array(array('param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php')),
        ),
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

    // ======================================================
    // 2. Global Site Settings & Contact Info (Options Page)
    // ======================================================
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

    // ======================================================
    // 3. About Us Page Fields
    // ======================================================
    acf_add_local_field_group(array(
        'key' => 'group_eliza_about_page_full',
        'title' => '✦ About Us & Sacred Journey Copy Editor',
        'fields' => array(
            array('key' => 'f_ab_hero_title', 'label' => 'Hero Title', 'name' => 'about_hero_title', 'type' => 'text', 'default_value' => 'About Eliza & Her Sacred Journey'),
            array('key' => 'f_ab_hero_lede', 'label' => 'Hero Lead Quote', 'name' => 'about_hero_lede', 'type' => 'textarea', 'rows' => 2, 'default_value' => '“I consider myself an ordinary individual grounded in the realities of daily life — on a quest to uncover the deep truth of who I really am.”'),
            array('key' => 'f_ab_portrait', 'label' => 'About Portrait Image', 'name' => 'about_portrait', 'type' => 'image', 'return_format' => 'url'),
            array('key' => 'f_ab_group_image', 'label' => 'Group Vision Photo Card', 'name' => 'about_group_image', 'type' => 'image', 'return_format' => 'url'),
        ),
        'location' => array(
            array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php')),
        ),
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));
}
