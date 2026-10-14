<?php
/**
 * Native WordPress Product Meta Box & Admin Columns for Book Products
 * Provides a dedicated, full-featured product management interface in WP-Admin
 * without requiring third-party plugins like WooCommerce or ACF.
 *
 * @package Eliza_Reconnection
 */

if (!defined('ABSPATH')) exit;

/**
 * Register the Product Data Meta Box for 'book_product' CPT.
 */
function eliza_register_book_product_metabox() {
    if (!function_exists('add_meta_box')) {
        if (file_exists(ABSPATH . 'wp-admin/includes/template.php')) {
            require_once ABSPATH . 'wp-admin/includes/template.php';
        }
    }
    if (function_exists('add_meta_box')) {
        add_meta_box(
            'eliza_book_product_metabox',
            __('Product Data, Pricing & Purchasing Channels', 'eliza-reconnection'),
            'eliza_render_book_product_metabox',
            'book_product',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'eliza_register_book_product_metabox');

/**
 * Enqueue WordPress Media Uploader and admin script for book products.
 */
function eliza_book_product_admin_scripts($hook) {
    global $post;
    if (($hook === 'post.php' || $hook === 'post-new.php') && isset($post->post_type) && $post->post_type === 'book_product') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'eliza_book_product_admin_scripts');

/**
 * Render the Product Data Meta Box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function eliza_render_book_product_metabox($post) {
    wp_nonce_field('eliza_save_book_product_nonce', 'eliza_book_product_nonce');

    // Retrieve existing meta values
    $product_type         = get_post_meta($post->ID, 'product_type', true) ?: 'physical';
    $price_zar            = get_post_meta($post->ID, 'product_price_zar', true) ?: 'R450';
    $subtitle             = get_post_meta($post->ID, 'product_subtitle', true);
    $publisher            = get_post_meta($post->ID, 'product_publisher', true);
    $video_url            = get_post_meta($post->ID, 'product_video_url', true);
    $download_url         = get_post_meta($post->ID, 'product_download_url', true);
    $courier_info         = get_post_meta($post->ID, 'product_courier_info', true) ?: 'Door-to-door tracked courier across South Africa included';
    $author_service_note  = get_post_meta($post->ID, 'product_author_service_note', true) ?: 'I print through my contact and courier books to clients in South Africa myself. Includes optional personal author dedication.';
    $amazon_paperback_url = get_post_meta($post->ID, 'product_amazon_paperback_url', true);
    $amazon_kindle_url    = get_post_meta($post->ID, 'product_amazon_kindle_url', true);
    $takealot_url         = get_post_meta($post->ID, 'product_takealot_url', true);
    $publisher_url        = get_post_meta($post->ID, 'product_publisher_url', true);
    ?>
    <style>
      .eliza-pmb-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; }
      .eliza-pmb-tabs { display: flex; border-bottom: 1px solid #ccd0d4; background: #f6f7f7; margin: -6px -12px 16px; padding: 0 12px; }
      .eliza-pmb-tab-btn { background: none; border: none; padding: 10px 16px; font-size: 13px; font-weight: 600; color: #50575e; cursor: pointer; border-bottom: 2px solid transparent; }
      .eliza-pmb-tab-btn:hover { color: #1d2327; }
      .eliza-pmb-tab-btn.active { color: #8e6516; border-bottom-color: #8e6516; background: #fff; }
      .eliza-pmb-panel { display: none; }
      .eliza-pmb-panel.active { display: block; }
      .eliza-pmb-row { display: flex; align-items: flex-start; margin-bottom: 16px; gap: 20px; }
      .eliza-pmb-label { width: 220px; flex-shrink: 0; font-weight: 600; font-size: 13px; color: #1d2327; padding-top: 6px; }
      .eliza-pmb-field { flex-grow: 1; max-width: 600px; }
      .eliza-pmb-field input[type="text"], .eliza-pmb-field input[type="url"], .eliza-pmb-field select, .eliza-pmb-field textarea { width: 100%; max-width: 100%; padding: 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; }
      .eliza-pmb-desc { font-size: 12px; color: #646970; margin-top: 4px; font-style: italic; }
      .eliza-badge-type { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
      .eliza-badge-physical { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
      .eliza-badge-digital { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
      .eliza-price-input { font-size: 16px !important; font-weight: 700 !important; color: #8e6516 !important; width: 160px !important; }
    </style>

    <div class="eliza-pmb-wrap">
      <div class="eliza-pmb-tabs" role="tablist">
        <button type="button" class="eliza-pmb-tab-btn active" data-target="panel-general">General &amp; Pricing</button>
        <button type="button" class="eliza-pmb-tab-btn" data-target="panel-sa">South Africa (Author Direct)</button>
        <button type="button" class="eliza-pmb-tab-btn" data-target="panel-intl">International &amp; Retailers</button>
      </div>

      <!-- PANEL 1: GENERAL & PRICING -->
      <div class="eliza-pmb-panel active" id="panel-general">
        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_type">Product Type</label>
          </div>
          <div class="eliza-pmb-field">
            <select name="product_type" id="eliza_product_type" style="max-width: 320px; font-weight: 600;">
              <option value="physical" <?php selected($product_type, 'physical'); ?>>Physical Book (Courier Delivery)</option>
              <option value="digital_pdf" <?php selected($product_type, 'digital_pdf'); ?>>Digital Publication (Downloadable Online PDF)</option>
            </select>
            <div class="eliza-pmb-desc">Select whether this product is a physical book shipped via courier or an immediate downloadable PDF guide.</div>
          </div>
        </div>

        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_price_zar">Price (ZAR)</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="text" name="product_price_zar" id="eliza_product_price_zar" class="eliza-price-input" value="<?php echo esc_attr($price_zar); ?>" placeholder="e.g. R450 or R250">
            <div class="eliza-pmb-desc">Customer purchase price in South African Rands (e.g. R450 for books, R250 for PDFs).</div>
          </div>
        </div>

        <div class="eliza-pmb-row" id="row_download_url">
          <div class="eliza-pmb-label">
            <label for="eliza_product_download_url">Downloadable PDF File / URL</label>
          </div>
          <div class="eliza-pmb-field">
            <div style="display: flex; gap: 8px;">
              <input type="text" name="product_download_url" id="eliza_product_download_url" value="<?php echo esc_attr($download_url); ?>" placeholder="https://.../guide.pdf">
              <button type="button" class="button" id="eliza_upload_pdf_btn">Choose from Media Library</button>
            </div>
            <div class="eliza-pmb-desc">Link to the PDF document delivered to customers upon purchase.</div>
          </div>
        </div>

        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_subtitle">Subtitle / Edition</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="text" name="product_subtitle" id="eliza_product_subtitle" value="<?php echo esc_attr($subtitle); ?>" placeholder="e.g. Companion Study & Meditation Guide">
          </div>
        </div>

        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_video_url">YouTube Trailer Video ID / URL</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="text" name="product_video_url" id="eliza_product_video_url" value="<?php echo esc_attr($video_url); ?>" placeholder="e.g. RbqgaGjtOPs">
            <div class="eliza-pmb-desc">YouTube Video ID (e.g. <code>RbqgaGjtOPs</code>) for the official video player.</div>
          </div>
        </div>
      </div>

      <!-- PANEL 2: SOUTH AFRICA DIRECT -->
      <div class="eliza-pmb-panel" id="panel-sa">
        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_courier_info">Courier &amp; Delivery Information</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="text" name="product_courier_info" id="eliza_product_courier_info" value="<?php echo esc_attr($courier_info); ?>">
            <div class="eliza-pmb-desc">Displayed on product summary cards and in the checkout modal.</div>
          </div>
        </div>

        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_author_service_note">Author Direct Service Note</label>
          </div>
          <div class="eliza-pmb-field">
            <textarea name="product_author_service_note" id="eliza_product_author_service_note" rows="3"><?php echo esc_textarea($author_service_note); ?></textarea>
            <div class="eliza-pmb-desc">Personal note regarding dedication, packaging, and dispatch.</div>
          </div>
        </div>
      </div>

      <!-- PANEL 3: INTERNATIONAL & RETAILERS -->
      <div class="eliza-pmb-panel" id="panel-intl">
        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_amazon_paperback_url">Amazon Paperback URL</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="url" name="product_amazon_paperback_url" id="eliza_product_amazon_paperback_url" value="<?php echo esc_attr($amazon_paperback_url); ?>" placeholder="https://a.co/d/...">
            <div class="eliza-pmb-desc">Leave empty if listing is not yet active.</div>
          </div>
        </div>

        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_amazon_kindle_url">Amazon Kindle URL</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="url" name="product_amazon_kindle_url" id="eliza_product_amazon_kindle_url" value="<?php echo esc_attr($amazon_kindle_url); ?>" placeholder="https://a.co/d/...">
          </div>
        </div>

        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_takealot_url">Takealot URL</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="url" name="product_takealot_url" id="eliza_product_takealot_url" value="<?php echo esc_attr($takealot_url); ?>" placeholder="https://www.takealot.com/...">
          </div>
        </div>

        <div class="eliza-pmb-row">
          <div class="eliza-pmb-label">
            <label for="eliza_product_publisher_url">Publisher Store URL</label>
          </div>
          <div class="eliza-pmb-field">
            <input type="url" name="product_publisher_url" id="eliza_product_publisher_url" value="<?php echo esc_attr($publisher_url); ?>" placeholder="https://...">
          </div>
        </div>
      </div>
    </div>

    <script>
      (function() {
        // Tab switching
        const tabs = document.querySelectorAll('.eliza-pmb-tab-btn');
        tabs.forEach(tab => {
          tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.eliza-pmb-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            const target = document.getElementById(this.getAttribute('data-target'));
            if (target) target.classList.add('active');
          });
        });

        // Media Library PDF Uploader
        const uploadBtn = document.getElementById('eliza_upload_pdf_btn');
        if (uploadBtn) {
          uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const fileFrame = wp.media({
              title: 'Select or Upload PDF Guide',
              button: { text: 'Use this PDF' },
              multiple: false
            });
            fileFrame.on('select', function() {
              const attachment = fileFrame.state().get('selection').first().toJSON();
              document.getElementById('eliza_product_download_url').value = attachment.url;
            });
            fileFrame.open();
          });
        }
      })();
    </script>
    <?php
}

/**
 * Save Product Data Meta Box fields into eliza_postmeta.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function eliza_save_book_product_metabox($post_id, $post) {
    if (!isset($_POST['eliza_book_product_nonce']) || !wp_verify_nonce($_POST['eliza_book_product_nonce'], 'eliza_save_book_product_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if ($post->post_type !== 'book_product') return;

    $fields = array(
        'product_type'                => 'sanitize_text_field',
        'product_price_zar'           => 'sanitize_text_field',
        'product_subtitle'            => 'sanitize_text_field',
        'product_publisher'           => 'sanitize_text_field',
        'product_video_url'           => 'sanitize_text_field',
        'product_download_url'        => 'esc_url_raw',
        'product_courier_info'        => 'sanitize_text_field',
        'product_author_service_note' => 'sanitize_textarea_field',
        'product_amazon_paperback_url'=> 'esc_url_raw',
        'product_amazon_kindle_url'   => 'esc_url_raw',
        'product_takealot_url'        => 'esc_url_raw',
        'product_publisher_url'       => 'esc_url_raw',
    );

    foreach ($fields as $field_key => $sanitizer) {
        if (isset($_POST[$field_key])) {
            $value = call_user_func($sanitizer, $_POST[$field_key]);
            update_post_meta($post_id, $field_key, $value);
        } else {
            delete_post_meta($post_id, $field_key);
        }
    }
}
add_action('save_post_book_product', 'eliza_save_book_product_metabox', 10, 2);

/**
 * Customize WP-Admin Columns for 'book_product' CPT.
 */
function eliza_book_product_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __('Product Title', 'eliza-reconnection');
    $new_columns['product_type'] = __('Type', 'eliza-reconnection');
    $new_columns['product_price'] = __('Price (ZAR)', 'eliza-reconnection');
    $new_columns['product_channels'] = __('Channels / Download', 'eliza-reconnection');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_book_product_posts_columns', 'eliza_book_product_columns');

/**
 * Render custom column content in WP-Admin for 'book_product' CPT.
 */
function eliza_render_book_product_custom_columns($column, $post_id) {
    switch ($column) {
        case 'product_type':
            $type = get_post_meta($post_id, 'product_type', true) ?: 'physical';
            if ($type === 'digital_pdf') {
                echo '<span style="display:inline-block; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700; background:#fef3c7; color:#92400e; border:1px solid #fde68a;">Digital PDF</span>';
            } else {
                echo '<span style="display:inline-block; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700; background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd;">Physical Book</span>';
            }
            break;

        case 'product_price':
            $price = get_post_meta($post_id, 'product_price_zar', true) ?: 'R450';
            echo '<strong style="font-size:14px; color:#8e6516;">' . esc_html($price) . '</strong>';
            break;

        case 'product_channels':
            $type = get_post_meta($post_id, 'product_type', true);
            if ($type === 'digital_pdf') {
                $dl = get_post_meta($post_id, 'product_download_url', true);
                if (!empty($dl)) {
                    echo '<a href="' . esc_url($dl) . '" target="_blank" style="color:#0284c7; font-weight:600;">View PDF File ↗</a>';
                } else {
                    echo '<span style="color:#9ca3af; font-style:italic;">No file attached</span>';
                }
            } else {
                $amz_p = get_post_meta($post_id, 'product_amazon_paperback_url', true);
                $amz_k = get_post_meta($post_id, 'product_amazon_kindle_url', true);
                $tak   = get_post_meta($post_id, 'product_takealot_url', true);
                $links = array();
                if ($amz_p) $links[] = '<a href="' . esc_url($amz_p) . '" target="_blank">Amazon PB</a>';
                if ($amz_k) $links[] = '<a href="' . esc_url($amz_k) . '" target="_blank">Kindle</a>';
                if ($tak) $links[] = '<a href="' . esc_url($tak) . '" target="_blank">Takealot</a>';
                echo !empty($links) ? implode(' &middot; ', $links) : '<span style="color:#9ca3af; font-style:italic;">Author Direct Only</span>';
            }
            break;
    }
}
add_action('manage_book_product_posts_custom_column', 'eliza_render_book_product_custom_columns', 10, 2);

/**
 * Retrieve all published digital downloadable PDF products.
 *
 * Scans the 'book_product' custom post type for items explicitly configured
 * as 'digital_pdf' or possessing a valid download attachment URL. Enables
 * automated, zero-maintenance rendering across frontend templates and email dispatchers.
 *
 * @return WP_Post[] Array of digital book_product post objects.
 */
function eliza_get_digital_pdf_products() {
    $products = get_posts(array(
        'post_type'      => 'book_product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ));

    $digital_items = array();
    foreach ($products as $p) {
        $type = get_post_meta($p->ID, 'product_type', true);
        $dl   = get_post_meta($p->ID, 'product_download_url', true);
        if ($type === 'digital_pdf' || !empty($dl) || strpos($p->post_name, 'pdf') !== false || strpos($p->post_name, 'guide') !== false) {
            $digital_items[] = $p;
        }
    }

    return $digital_items;
}
