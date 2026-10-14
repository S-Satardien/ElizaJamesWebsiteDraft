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
    wp_enqueue_style('eliza-live-editor-css', get_template_directory_uri() . '/css/live-editor.css', array(), time());
    wp_enqueue_script('eliza-live-editor-js', get_template_directory_uri() . '/js/live-editor.js', array('jquery'), time(), true);

    $current_id = get_queried_object_id() ?: get_the_ID();
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
        <span class="eliza-toolbar-hint">Click text to edit &middot; Click [URL] on buttons to edit links &middot; Click photos to swap</span>
      </div>
      <div class="eliza-toolbar-right">
        <button id="eliza-format-text-btn" class="eliza-btn eliza-btn-format" type="button" title="Format Text: Change Font, Bold, Size">
          <span>🔤 Format Text</span>
        </button>
        <button id="eliza-manage-links-btn" class="eliza-btn eliza-btn-links" type="button" title="View and edit all button URLs on this page">
          <span>Edit Page Links</span>
        </button>
        <button id="eliza-toggle-edit-mode" class="eliza-btn eliza-btn-mode" type="button">
          <span>Toggle View</span>
        </button>
        <button id="eliza-save-live-btn" class="eliza-btn eliza-btn-save" type="button">
          <span>Save Changes</span>
        </button>
      </div>
    </div>
    <div id="eliza-live-toast" class="eliza-live-toast" role="status" aria-live="polite"></div>

    <!-- Right-Hand Docked Text Formatting Inspector -->
    <div id="eliza-text-format-dock" class="eliza-format-dock" role="region" aria-label="Text Formatting Inspector" style="display: none;">
      <div class="eliza-dock-header">
        <div class="eliza-dock-title-wrap">
          <span class="eliza-dock-icon">🔤</span>
          <span class="eliza-dock-title">Text Styling</span>
          <span id="eliza-dock-tag" class="eliza-dock-tag" title="Selected Element Tag">BODY</span>
        </div>
        <div class="eliza-dock-header-actions">
          <button type="button" class="eliza-dock-action-btn" id="eliza-dock-minimize-btn" title="Minimize to edge tab">&minus;</button>
          <button type="button" class="eliza-dock-action-btn" id="eliza-dock-close-btn" title="Close inspector">&times;</button>
        </div>
      </div>

      <div class="eliza-dock-body">
        <!-- Font Family Selector -->
        <div class="eliza-dock-section">
          <label class="eliza-dock-label" for="eliza-fmt-font">Font Family</label>
          <div class="eliza-format-select-wrap">
            <select id="eliza-fmt-font" class="eliza-fmt-select eliza-dock-select" title="Font Family">
              <option value="">Font: Default</option>
              <option value="'Cormorant Garamond', Georgia, serif">Cormorant Garamond (Editorial Serif)</option>
              <option value="'Cinzel', Georgia, serif">Cinzel (Sacred Serif)</option>
              <option value="'Playfair Display', Georgia, serif">Playfair Display (Luxury Serif)</option>
              <option value="'Plus Jakarta Sans', system-ui, sans-serif">Plus Jakarta Sans (Modern Sans)</option>
              <option value="Georgia, serif">Georgia (Classic Serif)</option>
              <option value="system-ui, -apple-system, sans-serif">System Sans (Clean)</option>
            </select>
          </div>
        </div>

        <!-- Font Size Controls -->
        <div class="eliza-dock-section">
          <label class="eliza-dock-label" for="eliza-fmt-size">Font Size</label>
          <div class="eliza-dock-size-row">
            <button type="button" class="eliza-fmt-btn eliza-fmt-btn-step" data-cmd="size-down" title="Decrease Size (A-)">A&minus;</button>
            <select id="eliza-fmt-size" class="eliza-fmt-select eliza-dock-size-select" title="Font Size">
              <option value="">Size: Default</option>
              <option value="12px">12px &middot; Fine</option>
              <option value="14px">14px &middot; Small</option>
              <option value="16px">16px &middot; Normal</option>
              <option value="18px">18px &middot; Medium</option>
              <option value="20px">20px &middot; Lead</option>
              <option value="24px">24px &middot; Subhead</option>
              <option value="28px">28px &middot; H3</option>
              <option value="32px">32px &middot; H2</option>
              <option value="40px">40px &middot; H1</option>
              <option value="48px">48px &middot; Large</option>
              <option value="56px">56px &middot; Hero</option>
            </select>
            <button type="button" class="eliza-fmt-btn eliza-fmt-btn-step" data-cmd="size-up" title="Increase Size (A+)">A&#43;</button>
          </div>
        </div>

        <!-- Style & Weight Controls -->
        <div class="eliza-dock-section">
          <label class="eliza-dock-label">Style &amp; Weight</label>
          <div class="eliza-dock-style-row">
            <button type="button" class="eliza-fmt-btn eliza-fmt-style-btn" data-cmd="bold" title="Bold (Ctrl+B)"><strong>B</strong> <span>Bold</span></button>
            <button type="button" class="eliza-fmt-btn eliza-fmt-style-btn" data-cmd="italic" title="Italic (Ctrl+I)"><em>I</em> <span>Italic</span></button>
            <button type="button" class="eliza-fmt-btn eliza-fmt-style-btn" data-cmd="clear" title="Reset to Default">&#8634; <span>Reset</span></button>
          </div>
        </div>

        <!-- Text Color Palette -->
        <div class="eliza-dock-section">
          <label class="eliza-dock-label">Color Palette</label>
          <div class="eliza-dock-color-row">
            <button type="button" class="eliza-color-chip" data-color="#1C1512" style="background: #1C1512;" title="Dark Ink"></button>
            <button type="button" class="eliza-color-chip" data-color="#AA7C11" style="background: #AA7C11;" title="Gold Dark"></button>
            <button type="button" class="eliza-color-chip" data-color="#C99B36" style="background: #C99B36;" title="Gold Accent"></button>
            <button type="button" class="eliza-color-chip" data-color="#4D7257" style="background: #4D7257;" title="Sage Green"></button>
            <button type="button" class="eliza-color-chip" data-color="#FDFBF7" style="background: #FDFBF7;" title="Warm White"></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Collapsed Right Edge Handle -->
    <button type="button" id="eliza-dock-open-tab" class="eliza-dock-open-tab" style="display: none;" title="Open Text Styling Inspector">
      <span class="eliza-dock-tab-icon">🔤</span>
      <span class="eliza-dock-tab-label">Styling</span>
    </button>

    <!-- Floating Link & Button URL Editor Modal -->
    <div id="eliza-link-modal" class="eliza-link-modal-backdrop" aria-hidden="true" role="dialog">
      <div class="eliza-link-modal-card">
        <div class="eliza-link-modal-header">
          <div style="display: flex; align-items: center; gap: 8px;">
            <h4 style="margin: 0; font-family: var(--font-serif, Georgia, serif); font-size: 1.28rem; color: #170F0A;">Edit Button &amp; Link URL</h4>
          </div>
          <button type="button" class="eliza-link-modal-close" id="eliza-link-modal-close" aria-label="Close dialog">&times;</button>
        </div>
        <div class="eliza-link-modal-body">
          <div class="eliza-form-field">
            <label for="eliza-link-text-input">Button Text Label:</label>
            <input type="text" id="eliza-link-text-input" placeholder="e.g. Amazon Paperback, Order Direct">
          </div>
          <div class="eliza-form-field" style="margin-top: 14px;">
            <label for="eliza-link-url-input">Destination URL (Web link, email, or telephone):</label>
            <input type="text" id="eliza-link-url-input" placeholder="https://example.com/...">
            <div class="eliza-link-helpers">
              <span class="eliza-link-chip" data-set-url="#"># (Modal / Trigger)</span>
              <span class="eliza-link-chip" data-set-url="/contact/">/contact/</span>
              <span class="eliza-link-chip" data-set-url="/services/">/services/</span>
              <span class="eliza-link-chip" data-set-url="/books/">/books/</span>
              <span class="eliza-link-chip" data-set-url="tel:+27829269851">Call Phone</span>
            </div>
          </div>
          <div class="eliza-form-field-checkbox" style="margin-top: 14px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.88rem; color: #4A3B32;">
              <input type="checkbox" id="eliza-link-target-input" checked>
              <span>Open link in new tab (<code>target="_blank"</code>)</span>
            </label>
          </div>
        </div>
        <div class="eliza-link-modal-footer">
          <button type="button" class="eliza-btn eliza-btn-cancel" id="eliza-link-modal-cancel">Cancel</button>
          <button type="button" class="eliza-btn eliza-btn-apply" id="eliza-link-modal-apply">Apply to Button</button>
        </div>
      </div>
    </div>

    <!-- All Page Links Management Modal -->
    <div id="eliza-all-links-modal" class="eliza-link-modal-backdrop" aria-hidden="true" role="dialog">
      <div class="eliza-link-modal-card" style="max-width: 600px;">
        <div class="eliza-link-modal-header">
          <div style="display: flex; align-items: center; gap: 8px;">
            <h4 style="margin: 0; font-family: var(--font-serif, Georgia, serif); font-size: 1.28rem; color: #170F0A;">All Buttons &amp; Links on this Page</h4>
          </div>
          <button type="button" class="eliza-link-modal-close" id="eliza-all-links-modal-close" aria-label="Close dialog">&times;</button>
        </div>
        <div class="eliza-link-modal-body" style="max-height: 60vh; overflow-y: auto;">
          <p style="margin: 0 0 14px 0; font-size: 0.88rem; color: #6E5A4E;">
            Click <strong>Edit URL</strong> next to any button below to update its label, destination URL, or new-tab behavior:
          </p>
          <div id="eliza-links-list" class="eliza-links-list">
            <!-- Dynamically populated by JS -->
          </div>
        </div>
        <div class="eliza-link-modal-footer">
          <button type="button" class="eliza-btn eliza-btn-cancel" id="eliza-all-links-modal-done">Close</button>
        </div>
      </div>
    </div>
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

    // Clean rogue scripts, footers, toolbar, dock, and wrapper tags before persisting
    $raw_content = preg_replace('#<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>#is', '', $raw_content);
    $raw_content = preg_replace('#<footer\b[^<]*(?:(?!<\/footer>)<[^<]*)*<\/footer>#is', '', $raw_content);
    $raw_content = preg_replace('#<div id="eliza-live-toolbar"[^>]*>.*?</div>\s*</div>#is', '', $raw_content);
    $raw_content = preg_replace('#<div id="eliza-text-format-dock"[^>]*>.*?</div>\s*</div>\s*</div>#is', '', $raw_content);
    $raw_content = preg_replace('#<button[^>]*id="eliza-dock-open-tab"[^>]*>.*?</button>#is', '', $raw_content);
    $raw_content = preg_replace('#<button[^>]*class="[^"]*eliza-video-edit-badge[^"]*"[^>]*>.*?</button>#is', '', $raw_content);
    $raw_content = preg_replace('#^<main[^>]*>#i', '', trim($raw_content));
    $raw_content = preg_replace('#</main>$#i', '', trim($raw_content));

    // Temporarily remove KSES filter so YouTube iframes are not stripped
    kses_remove_filters();

    $updated = wp_update_post(array(
        'ID'           => $post_id,
        'post_content' => $raw_content,
    ));

    // Re-init KSES filters
    kses_init_filters();

    // Keep Chakra Energetics book product video meta synchronized if present in saved content
    if (preg_match('#(?:id="chakra-energetics"|Chakra Energetics).*?embed/([a-zA-Z0-9_-]{11})#is', $raw_content, $yt_match)) {
        update_post_meta(121, 'product_video_url', sanitize_text_field($yt_match[1]));
    }

    if (is_wp_error($updated)) {
        wp_send_json_error(array('message' => $updated->get_error_message()));
    }

    wp_send_json_success(array(
        'message' => 'All changes saved successfully! Fresh content is live.',
        'post_id' => $post_id,
    ));
}
add_action('wp_ajax_eliza_save_live_page', 'eliza_save_live_page_handler');
