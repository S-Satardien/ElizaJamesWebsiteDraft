<?php
/**
 * Frontend Live Visual Editor for Eliza Reconnection Theme
 * @package Eliza_Reconnection
 */

if (!defined('ABSPATH')) exit;

function eliza_enqueue_live_editor() {
    if (!is_user_logged_in() || !current_user_can('edit_pages')) return;

    // Enqueue WordPress Media Library uploader
    wp_enqueue_media();

    // Enqueue Live Editor Styles & Script
    wp_enqueue_style('eliza-live-editor-css', get_template_directory_uri() . '/css/live-editor.css', array(), '1.0.1');
    wp_enqueue_script('eliza-live-editor-js', get_template_directory_uri() . '/js/live-editor.js', array('jquery'), '1.0.1', true);

    wp_localize_script('eliza-live-editor-js', 'eliza_live_editor', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('eliza_live_editor_nonce'),
        'post_id'  => get_the_ID() ?: get_option('page_on_front'),
    ));
}
add_action('wp_enqueue_scripts', 'eliza_enqueue_live_editor');

// Live Editor Floating Toolbar in Footer for Admins
function eliza_render_live_editor_toolbar() {
    if (!is_user_logged_in() || !current_user_can('edit_pages')) return;
    ?>
    <!-- Eliza Frontend Live Visual Editor Bar -->
    <div id="eliza-live-toolbar" class="eliza-live-toolbar" aria-label="Live Visual Editor Toolbar">
      <div class="eliza-toolbar-left">
        <span class="eliza-toolbar-badge">
          <span class="eliza-pulse-dot"></span>
          <span>Live Visual Editor</span>
        </span>
        <span class="eliza-toolbar-hint">Click any text on the page to edit · Click photos to replace</span>
      </div>
      <div class="eliza-toolbar-right">
        <button type="button" id="eliza-toggle-edit-mode" class="eliza-btn eliza-btn-mode">
          <span class="eliza-icon">✏️</span> <span id="eliza-mode-label">Editing Active</span>
        </button>
        <button type="button" id="eliza-save-live-btn" class="eliza-btn eliza-btn-save">
          <span class="eliza-icon">💾</span> <span>Save Changes</span>
        </button>
      </div>
    </div>
    <div id="eliza-live-toast" class="eliza-live-toast" role="status" aria-live="polite"></div>
    <?php
}
add_action('wp_footer', 'eliza_render_live_editor_toolbar', 9999);

// AJAX Save Handler
function eliza_ajax_save_live_page() {
    check_ajax_referer('eliza_live_editor_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error(array('message' => 'Unauthorized user permissions.'));
    }

    $post_id = intval($_POST['post_id'] ?? 0);
    $content = wp_kses_post($_POST['content'] ?? '');

    if (!$post_id || !$content) {
        wp_send_json_error(array('message' => 'Invalid post ID or empty content.'));
    }

    $updated = wp_update_post(array(
        'ID'           => $post_id,
        'post_content' => $content,
    ));

    if (!is_wp_error($updated)) {
        wp_send_json_success(array('message' => 'Page changes saved successfully!'));
    } else {
        wp_send_json_error(array('message' => $updated->get_error_message()));
    }
}
add_action('wp_ajax_eliza_save_live_page', 'eliza_ajax_save_live_page');
