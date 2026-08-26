<?php
/**
 * Frontend Live Visual Editor Backend Engine
 * Allows authorized administrators to edit, swap images, and persist content directly.
 * @package Eliza_Reconnection
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Live Editor assets and WordPress Media Uploader for logged-in administrators.
 */
function eliza_live_editor_enqueue() {
    if (!current_user_can('edit_pages')) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('eliza-live-editor-css', get_template_directory_uri() . '/css/live-editor.css', array(), '1.2.0');
    wp_enqueue_script('eliza-live-editor-js', get_template_directory_uri() . '/js/live-editor.js', array('jquery'), '1.2.0', true);

    $current_id = get_the_ID();
    if (is_front_page() || is_home()) {
        $front_id = get_option('page_on_front');
        if ($front_id) {
            $current_id = $front_id;
        }
    }

    wp_localize_script('eliza-live-editor-js', 'eliza_live_editor', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('eliza_live_editor_nonce'),
        'post_id'  => $current_id,
    ));
}
add_action('wp_enqueue_scripts', 'eliza_live_editor_enqueue');

/**
 * Render the Floating Live Editor Controls for authorized administrators.
 */
function eliza_render_live_toolbar() {
    if (!current_user_can('edit_pages') || is_admin()) {
        return;
    }
    ?>
    <div id="eliza-live-toolbar" class="eliza-live-toolbar" role="region" aria-label="Live Visual Editor">
      <div class="eliza-toolbar-left">
        <span class="eliza-toolbar-badge">
          <span class="eliza-pulse-dot" aria-hidden="true"></span>
          <span id="eliza-mode-label">Editing Active</span>
        </span>
        <span class="eliza-toolbar-hint">✦ Click any text or card to edit · Click photos to swap</span>
      </div>
      <div class="eliza-toolbar-right">
        <button id="eliza-toggle-edit-mode" class="eliza-btn eliza-btn-mode" type="button">
          <span>Toggle View</span>
        </button>
        <button id="eliza-save-live-btn" class="eliza-btn eliza-btn-save" type="button">
          <span>💾</span>
          <span>Save Changes</span>
        </button>
      </div>
    </div>
    <div id="eliza-live-toast" class="eliza-live-toast" role="status" aria-live="polite"></div>
    <?php
}
add_action('wp_footer', 'eliza_render_live_toolbar');

/**
 * AJAX Handler for saving live frontend edits into the database.
 * Preserves <iframe> tags for YouTube embeds, maps, and rich media.
 */
function eliza_save_live_page_handler() {
    check_ajax_referer('eliza_live_editor_nonce', 'nonce');

    if (!current_user_can('edit_pages')) {
        wp_send_json_error(array('message' => 'Unauthorized permissions.'));
    }

    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $raw_content = isset($_POST['content']) ? wp_unslash($_POST['content']) : '';

    if (!$post_id) {
        wp_send_json_error(array('message' => 'Invalid post ID.'));
    }

    // Temporarily remove KSES filter so YouTube iframes are not stripped
    kses_remove_filters();

    $updated = wp_update_post(array(
        'ID'           => $post_id,
        'post_content' => $raw_content,
    ));

    // Re-init KSES filters
    kses_init_filters();

    if (is_wp_error($updated)) {
        wp_send_json_error(array('message' => $updated->get_error_message()));
    }

    wp_send_json_success(array(
        'message' => 'All changes saved successfully! Fresh content is live.',
        'post_id' => $post_id,
    ));
}
add_action('wp_ajax_eliza_save_live_page', 'eliza_save_live_page_handler');
