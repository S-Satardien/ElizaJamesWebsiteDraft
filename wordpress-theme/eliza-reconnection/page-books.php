<?php
/**
 * Template Name: Books & Publications
 * @package Eliza_Reconnection
 */
get_header();

// Dynamic Query for Book Products
    $b_chakra_price = 'R450';
    $b_chakra_amz_paperback = 'https://a.co/d/0iG4TYR3';
    $b_chakra_amz_kindle = 'https://a.co/d/035Pg1NZ';
    $b_chakra_takealot = '';
    $b_chakra_youtube_id = 'aOVbAlEVY5g';

    $b_extraordinary_price = 'R450';
    $b_extraordinary_amz_paperback = '';
    $b_extraordinary_amz_kindle = '';
    $b_extraordinary_takealot = '';
    $b_extraordinary_youtube_id = 'VmsQBtoa7h0';

    // Query book_product posts for custom URLs / prices
    $product_posts = get_posts(array(
        'post_type'      => 'book_product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ));

    foreach ($product_posts as $p) {
        $slug = $p->post_name;
        if (strpos($slug, 'chakra') !== false) {
            $val_price = get_post_meta($p->ID, 'product_price_zar', true);
            if (!empty($val_price)) $b_chakra_price = $val_price;
            $val_amz_p = get_post_meta($p->ID, 'product_amazon_paperback_url', true);
            if (!empty($val_amz_p)) $b_chakra_amz_paperback = $val_amz_p;
            $val_amz_k = get_post_meta($p->ID, 'product_amazon_kindle_url', true);
            if (!empty($val_amz_k)) $b_chakra_amz_kindle = $val_amz_k;
            $val_tak = get_post_meta($p->ID, 'product_takealot_url', true);
            if (!empty($val_tak)) $b_chakra_takealot = $val_tak;
            $val_yt = get_post_meta($p->ID, 'product_video_url', true);
            if (!empty($val_yt)) $b_chakra_youtube_id = $val_yt;
        } elseif (strpos($slug, 'extraordinary') !== false) {
            $val_price = get_post_meta($p->ID, 'product_price_zar', true);
            if (!empty($val_price)) $b_extraordinary_price = $val_price;
            $val_amz_p = get_post_meta($p->ID, 'product_amazon_paperback_url', true);
            if (!empty($val_amz_p)) $b_extraordinary_amz_paperback = $val_amz_p;
            $val_amz_k = get_post_meta($p->ID, 'product_amazon_kindle_url', true);
            if (!empty($val_amz_k)) $b_extraordinary_amz_kindle = $val_amz_k;
            $val_tak = get_post_meta($p->ID, 'product_takealot_url', true);
            if (!empty($val_tak)) $b_extraordinary_takealot = $val_tak;
            $val_yt = get_post_meta($p->ID, 'product_video_url', true);
            if (!empty($val_yt)) $b_extraordinary_youtube_id = $val_yt;
        }
    }

/**
 * Render the dynamic grid of all published digital PDF products.
 *
 * @return string HTML output for the digital product cards grid.
 */
function eliza_render_digital_products_grid() {
    $digital_items = function_exists('eliza_get_digital_pdf_products') 
        ? eliza_get_digital_pdf_products() 
        : array();

    ob_start();
    ?>
    <div class="grid-balanced-2 eliza-digital-grid" style="gap: 32px; align-items: stretch;">
      <?php
      if (!empty($digital_items)) {
          foreach ($digital_items as $pdf_item) {
              $p_id    = $pdf_item->ID;
              $p_title = $pdf_item->post_title;
              $p_desc  = !empty($pdf_item->post_excerpt) 
                  ? $pdf_item->post_excerpt 
                  : (!empty($pdf_item->post_content) ? wp_strip_all_tags($pdf_item->post_content) : get_post_meta($p_id, 'product_subtitle', true));
              if (empty($p_desc)) {
                  $p_desc = 'Comprehensive sacred wisdom and companion practical guide available for instant digital download upon purchase.';
              }
              $p_price = get_post_meta($p_id, 'product_price_zar', true);
              if (empty($p_price)) $p_price = 'R250';
              if (strpos($p_price, 'R') === false) $p_price = 'R' . $p_price;
              ?>
              <div class="glass-box pdf-product-card" style="padding: 32px 28px; border-radius: 14px; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid rgba(212,175,55,0.35); background: rgba(255,255,255,0.85); box-shadow: 0 12px 36px rgba(0,0,0,0.04);">
                <div>
                  <div class="glass-chip" style="margin-bottom: 14px;">
                    <span class="pulse-dot" aria-hidden="true"></span>
                    <span>Instant PDF Download &middot; Digital Publication</span>
                  </div>
                  <h3 class="pdf-product-title" style="margin: 0 0 10px 0; font-family: var(--font-serif); font-size: 1.4rem; color: var(--ink); line-height: 1.35;"><?php echo esc_html($p_title); ?></h3>
                  <div class="pdf-product-desc" style="font-size: 0.95rem; line-height: 1.65; color: var(--ink-soft); margin-bottom: 22px;">
                    <?php echo wpautop(esc_html($p_desc)); ?>
                  </div>
                </div>
                <div class="pdf-card-bottom" style="border-top: 1px solid rgba(212,175,55,0.22); padding-top: 18px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;">
                  <div class="channel-price">
                    <span class="price-val"><?php echo esc_html($p_price); ?></span>
                  </div>
                  <a href="#authorOrderModal" role="button" class="btn-primary-presence open-order-modal"
                     onclick="window.openOrderModal(this); return false;"
                     data-product-id="<?php echo esc_attr($p_id); ?>"
                     data-product-type="digital"
                     data-book-title="<?php echo esc_attr($p_title); ?>"
                     data-book-price="<?php echo esc_attr($p_price); ?>"
                     data-book-author="Eliza James">
                    <span class="btn-text-content">Buy PDF &middot; Instant Delivery</span>
                    <span class="btn-arrow">&rarr;</span>
                  </a>
                </div>
              </div>
              <?php
          }
      } else {
          $defaults = array(
              array(
                  'id'    => 155,
                  'title' => 'The Process of Thinking (PDF)',
                  'desc'  => 'A lot of people want to find a Text, a School, a Teacher, a Guru, a Saint, a Master, a something that is perfect so that they don’t have to worry about the imperfection inherent in everything. That’s ducking the problem – looking for the easy way out. You must empower yourself to discover the Truth of Yourself.',
                  'price' => 'R120'
              ),
              array(
                  'id'    => 156,
                  'title' => 'Working on the Self (PDF)',
                  'desc'  => 'St Germain’s core message is that of Freedom in God. Freedom from all manner of systems (religious, political, financial, societal etc.) that holds the soul in bondage. The only way to uncover (discover) the truth of yourself is through your relationships and your interaction with others.',
                  'price' => 'R95'
              )
          );
          foreach ($defaults as $d) {
              ?>
              <div class="glass-box pdf-product-card" style="padding: 32px 28px; border-radius: 14px; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid rgba(212,175,55,0.35); background: rgba(255,255,255,0.85); box-shadow: 0 12px 36px rgba(0,0,0,0.04);">
                <div>
                  <div class="glass-chip" style="margin-bottom: 14px;">
                    <span class="pulse-dot" aria-hidden="true"></span>
                    <span>Instant PDF Download &middot; Digital Publication</span>
                  </div>
                  <h3 class="pdf-product-title" style="margin: 0 0 10px 0; font-family: var(--font-serif); font-size: 1.4rem; color: var(--ink); line-height: 1.35;"><?php echo esc_html($d['title']); ?></h3>
                  <div class="pdf-product-desc" style="font-size: 0.95rem; line-height: 1.65; color: var(--ink-soft); margin-bottom: 22px;">
                    <?php echo wpautop(esc_html($d['desc'])); ?>
                  </div>
                </div>
                <div class="pdf-card-bottom" style="border-top: 1px solid rgba(212,175,55,0.22); padding-top: 18px; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;">
                  <div class="channel-price">
                    <span class="price-val"><?php echo esc_html($d['price']); ?></span>
                  </div>
                  <a href="#authorOrderModal" role="button" class="btn-primary-presence open-order-modal"
                     onclick="window.openOrderModal(this); return false;"
                     data-product-id="<?php echo esc_attr($d['id']); ?>"
                     data-product-type="digital"
                     data-book-title="<?php echo esc_attr($d['title']); ?>"
                     data-book-price="<?php echo esc_attr($d['price']); ?>"
                     data-book-author="Eliza James">
                    <span class="btn-text-content">Buy PDF &middot; Instant Delivery</span>
                    <span class="btn-arrow">&rarr;</span>
                  </a>
                </div>
              </div>
              <?php
          }
      }
      ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Injects the fresh dynamic digital products grid into the saved content,
 * strictly preserving the client's custom section heading, intro text,
 * and all surrounding sections.
 *
 * @param string $content Post content string from wp_posts.
 * @param string $dynamic_grid_html Live generated product cards grid HTML.
 * @return string Post content with dynamic product cards injected.
 */
function eliza_inject_digital_products($content, $dynamic_grid_html) {
    $pos = strpos($content, 'id="digital-editions"');
    if ($pos === false) return $content;

    // Locate the grid container within this section
    $grid_pos = strpos($content, 'class="grid-balanced-2', $pos);
    if ($grid_pos === false) {
        $grid_pos = strpos($content, 'class="eliza-digital-grid', $pos);
    }
    if ($grid_pos === false) return $content;

    $grid_start = strrpos(substr($content, 0, $grid_pos), '<div');
    if ($grid_start === false) return $content;

    $section_end = strpos($content, '</section>', $grid_start);
    if ($section_end === false) return $content;

    $container_close = strrpos(substr($content, 0, $section_end), '</div>');
    if ($container_close === false || $container_close <= $grid_start) return $content;

    $prefix = substr($content, 0, $grid_start);
    $suffix = substr($content, $container_close);

    return $prefix . $dynamic_grid_html . "\n      " . $suffix;
}

/**
 * Render the PayFast transaction confirmation or cancellation banner.
 * Automatically resolves the purchased product's real download URL and dispatches
 * the delivery email if not yet sent.
 */
function eliza_render_payment_banner() {
    if (!isset($_GET['payment'])) return;

    if ($_GET['payment'] === 'success') {
        $p_type     = sanitize_text_field($_GET['type'] ?? 'physical');
        $p_title    = sanitize_text_field(urldecode($_GET['title'] ?? 'Your Order'));
        $p_order    = sanitize_text_field($_GET['order_id'] ?? '');
        $p_id_param = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

        $download_url = '';
        $matched_order = null;

        // Process order confirmation and dispatch customer emails
        if (!empty($p_order)) {
            $orders = get_option('eliza_recent_orders', array());
            $updated_orders = false;
            foreach ($orders as &$ord) {
                if ($ord['order_id'] === $p_order) {
                    if (!empty($ord['download_url'])) {
                        $download_url = $ord['download_url'];
                    }
                    if ($ord['status'] === 'PENDING_PAYMENT') {
                        $ord['status'] = 'PAID';
                        $ord['paid_at'] = current_time('Y-m-d H:i:s');
                        $updated_orders = true;
                    }
                    if (empty($ord['customer_email_sent'])) {
                        if ($p_type === 'digital') {
                            if (function_exists('eliza_send_customer_download_email')) {
                                eliza_send_customer_download_email($ord);
                            }
                        } else {
                            if (function_exists('eliza_send_customer_physical_order_email')) {
                                eliza_send_customer_physical_order_email($ord);
                            }
                        }
                        $ord['customer_email_sent'] = true;
                        $updated_orders = true;
                    }
                    $matched_order = $ord;
                    break;
                }
            }
            if ($updated_orders) {
                update_option('eliza_recent_orders', $orders);
            }
        }

        // Determine download URL if still empty for digital publications
        if ($p_type === 'digital') {
            if (empty($download_url) && $p_id_param > 0) {
                $download_url = get_post_meta($p_id_param, 'product_download_url', true);
            }
            if (empty($download_url) && function_exists('eliza_get_digital_pdf_products')) {
                $all_dig = eliza_get_digital_pdf_products();
                foreach ($all_dig as $d) {
                    if ($d->post_title === $p_title) {
                        $download_url = get_post_meta($d->ID, 'product_download_url', true);
                        break;
                    }
                }
            }
            if (empty($download_url)) {
                if (stripos($p_title, 'test') !== false) {
                    $download_url = home_url('/wp-content/uploads/test-digital-guide-eliza-james.pdf');
                } else {
                    $download_url = home_url('/wp-content/uploads/chakra-energetics-guide.pdf');
                }
            }
        }
        ?>
        <!-- ========================================================================= -->
        <!-- PAYMENT CONFIRMATION SUCCESS MODAL (DOES NOT DISRUPT PAGE STRUCTURE)     -->
        <!-- ========================================================================= -->
        <div id="orderConfirmationModal" class="order-modal-backdrop is-active" style="display: flex; position: fixed; inset: 0; z-index: 999999; background: rgba(15, 10, 6, 0.78); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); align-items: center; justify-content: center; padding: 20px;" onclick="if(event.target===this) window.closeConfirmationModal();" role="dialog" aria-modal="true" aria-labelledby="confirmModalTitle">
          <div class="order-modal-card" style="position: relative; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; background: #FFFFFF; border-radius: 18px; border: 2px solid #D4AF37; box-shadow: 0 24px 60px rgba(0,0,0,0.35); padding: 36px 32px; animation: modalPop 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
            <button type="button" class="order-modal-close" onclick="window.closeConfirmationModal();" aria-label="Close Confirmation Window" style="position: absolute; top: 16px; right: 18px; background: none; border: none; font-size: 28px; line-height: 1; color: #786C5E; cursor: pointer; padding: 4px 8px;">&times;</button>
            
            <div style="text-align: center; margin-bottom: 22px;">
              <div style="width: 56px; height: 56px; border-radius: 50%; background: #ECFDF5; border: 2px solid #10B981; display: inline-flex; align-items: center; justify-content: center; color: #059669; margin-bottom: 14px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              </div>
              <div>
                <span class="eyebrow" style="color: #059669; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; font-size: 0.78rem;">Payment Confirmed &middot; Thank You</span>
              </div>
              <h2 id="confirmModalTitle" style="margin: 6px 0 8px; font-family: var(--font-serif); font-size: 1.65rem; color: #170F0A; line-height: 1.3;">
                Order Received for <?php echo esc_html($p_title); ?>
              </h2>
              <?php if (!empty($p_order)) : ?>
                <div style="font-size: 0.88rem; color: #786C5E;">
                  Order Reference: <strong style="font-family: monospace; color: #8E6516; background: #FAF6EE; padding: 3px 8px; border-radius: 4px; border: 1px solid rgba(212,175,55,0.3);"><?php echo esc_html($p_order); ?></strong>
                </div>
              <?php endif; ?>
            </div>

            <?php if ($p_type === 'digital') : ?>
              <div style="font-size: 0.95rem; line-height: 1.65; color: #52473E; margin-bottom: 24px; text-align: center;">
                <p style="margin: 0 0 14px;">
                  Your payment has been successfully confirmed by PayFast. A confirmation receipt and permanent download link have been sent to your email<?php echo (!empty($matched_order['customer_email']) ? ' (<strong>' . esc_html($matched_order['customer_email']) . '</strong>)' : ''); ?>.
                </p>
                <div style="background: #FAF6EE; border-radius: 12px; border: 1px solid rgba(212,175,55,0.4); padding: 20px; text-align: center; margin-bottom: 10px;">
                  <div style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8E6516; margin-bottom: 6px;">
                    Instant Digital Delivery
                  </div>
                  <a href="<?php echo esc_url($download_url); ?>" target="_blank" download class="btn-primary-presence" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; padding: 13px 28px; width: auto; margin: 4px auto 0; text-decoration: none;">
                    <span class="btn-text-content">Download Publication (PDF)</span>
                    <span class="btn-arrow">&darr;</span>
                  </a>
                </div>
              </div>
            <?php else : ?>
              <div style="font-size: 0.95rem; line-height: 1.65; color: #52473E; margin-bottom: 22px;">
                <p style="margin: 0 0 16px; text-align: center;">
                  Your payment has been successfully confirmed by PayFast. An official confirmation email with your order summary has been dispatched to your email<?php echo (!empty($matched_order['customer_email']) ? ' (<strong>' . esc_html($matched_order['customer_email']) . '</strong>)' : ''); ?>.
                </p>

                <div style="background: #FAF6EE; border-radius: 12px; border: 1px solid rgba(212,175,55,0.4); padding: 20px 22px; margin-bottom: 16px;">
                  <div style="font-size: 0.76rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8E6516; margin-bottom: 8px;">
                    Tracked Door-to-Door Courier Delivery
                  </div>
                  <?php if (!empty($matched_order)) : ?>
                    <div style="font-weight: 700; color: #170F0A; font-size: 0.95rem; margin-bottom: 4px;">
                      <?php echo esc_html($matched_order['customer_name']); ?>
                    </div>
                    <div style="font-size: 0.9rem; color: #52473E; line-height: 1.5; margin-bottom: 8px;">
                      <?php echo esc_html($matched_order['street_address']); ?><br>
                      <?php echo esc_html($matched_order['city']); ?>, <?php echo esc_html($matched_order['province']); ?> <?php echo esc_html($matched_order['postal_code']); ?>
                    </div>
                    <?php if (!empty($matched_order['dedication'])) : ?>
                      <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed rgba(212,175,55,0.35); font-size: 0.85rem; color: #786C5E;">
                        <strong style="color: #8E6516;">Personal Dedication:</strong> &ldquo;<?php echo esc_html($matched_order['dedication']); ?>&rdquo;
                      </div>
                    <?php endif; ?>
                  <?php else : ?>
                    <p style="margin: 0; font-size: 0.88rem; color: #52473E;">
                      Your book will be packaged with personal care and couriered directly to your door with tracked delivery.
                    </p>
                  <?php endif; ?>
                  <div style="margin-top: 10px; font-size: 0.82rem; color: #8E6516; font-weight: 600;">
                    &check; Estimated delivery: 10 to 14 business days across South Africa.
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <div style="display: flex; gap: 12px; justify-content: center; margin-top: 24px;">
              <button type="button" class="btn-primary-presence" onclick="window.closeConfirmationModal();" style="width: 100%;">
                <span class="btn-text-content">Continue Browsing Books</span>
                <span class="btn-arrow">&rarr;</span>
              </button>
            </div>
          </div>
        </div>
        <script>
        window.closeConfirmationModal = function() {
          var modal = document.getElementById('orderConfirmationModal');
          if (modal) {
            modal.style.opacity = '0';
            modal.style.transition = 'opacity 0.2s ease';
            setTimeout(function() { modal.remove(); }, 200);
          }
          document.body.style.overflow = '';
          if (window.history && window.history.replaceState) {
            var cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
          }
        };
        </script>
        <?php
    } elseif ($_GET['payment'] === 'cancelled') {
        ?>
        <div id="orderCancelledModal" class="order-modal-backdrop is-active" style="display: flex; position: fixed; inset: 0; z-index: 999999; background: rgba(15, 10, 6, 0.75); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;" onclick="if(event.target===this) window.closeCancelledModal();" role="dialog" aria-modal="true">
          <div class="order-modal-card" style="position: relative; max-width: 500px; width: 100%; background: #FFFFFF; border-radius: 16px; border: 1.5px solid rgba(212,175,55,0.4); box-shadow: 0 20px 50px rgba(0,0,0,0.3); padding: 32px 28px; text-align: center;">
            <button type="button" class="order-modal-close" onclick="window.closeCancelledModal();" aria-label="Close Window" style="position: absolute; top: 14px; right: 16px; background: none; border: none; font-size: 26px; line-height: 1; color: #786C5E; cursor: pointer;">&times;</button>
            <h3 style="margin: 0 0 10px; color: var(--ink); font-family: var(--font-serif); font-size: 1.45rem;">Payment Session Cancelled</h3>
            <p style="margin: 0 0 22px; color: var(--ink-soft); font-size: 0.94rem; line-height: 1.6;">
              Your PayFast payment session was cancelled. No funds were debited. If you would like to complete your order or have questions, please feel free to try again or contact Eliza directly.
            </p>
            <button type="button" class="btn-primary-presence" onclick="window.closeCancelledModal();" style="width: 100%;">
              <span class="btn-text-content">Return to Books</span>
            </button>
          </div>
        </div>
        <script>
        window.closeCancelledModal = function() {
          var modal = document.getElementById('orderCancelledModal');
          if (modal) modal.remove();
          document.body.style.overflow = '';
          if (window.history && window.history.replaceState) {
            var cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
          }
        };
        </script>
        <?php
    }
}

    $page_id = get_the_ID();
    if (is_front_page() || is_home()) {
        $page_id = get_option('page_on_front') ?: $page_id;
    }
    $saved_content = get_post_field('post_content', $page_id);

    if (!empty(trim($saved_content))) {
        echo '<main id="main">';
        eliza_render_payment_banner();
        $dynamic_grid = eliza_render_digital_products_grid();
        $saved_content = eliza_inject_digital_products($saved_content, $dynamic_grid);
        $saved_content = str_replace('{theme_uri}', get_template_directory_uri(), $saved_content);
        // Ensure test sandbox is removed and digital editions hidden
        $saved_content = preg_replace('/<section[^>]*id="payfast-test-sandbox"[^>]*>.*?<\/section>/s', '', $saved_content);
        if (strpos($saved_content, 'id="digital-editions"') !== false) {
            $saved_content = preg_replace('/<section([^>]*id="digital-editions"[^>]*)style="/s', '<section$1style="display: none; ', $saved_content);
            if (strpos($saved_content, 'style="display: none;') === false) {
                $saved_content = str_replace('id="digital-editions"', 'id="digital-editions" style="display: none;"', $saved_content);
            }
        }
        echo $saved_content;
        echo '</main>';
    } else {
?>
<main id="main">
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="glow" aria-hidden="true"></div>
    <div class="container reveal">
      <span class="eyebrow eyebrow-on-dusk">Literary Works &middot; Eliza James</span>
      <h1>Embracing Sacred Wisdom</h1>
      <p>&ldquo;Literature shared to gently awaken your curiosity, expand your consciousness, and guide seekers of truth on their journey toward personal sovereignty and spiritual alignment.&rdquo;</p>
    </div>
  </section>

  <!-- PAYFAST TRANSACTION NOTIFICATION BANNER -->
  <?php eliza_render_payment_banner(); ?>

  <!-- ========================================================================= -->
  <!-- SECTION 1: BOOK 1 SHOWCASE (Chakra Energetics) - PROMOTED TO TOP         -->
  <!-- ========================================================================= -->
  <section class="section-subtle" id="chakra-energetics" style="padding: 72px 0 80px;">
    <div class="container-wide">
      <!-- Section Header -->
      <div class="reveal text-center" style="max-width: 860px; margin: 0 auto 44px;">
        <span class="eyebrow">&lang; Publication 01 &rang; &middot; Sacred Anatomy, clarified</span>
        <h2 class="section-title">Chakra Energetics</h2>
        <p class="section-intro" style="margin: 12px auto 0; font-family: var(--font-serif); font-size: 1.18rem; font-style: italic; color: var(--ink-soft); max-width: 700px;">
          Teachers of Ancient and Inner Wisdom &middot; Ascended Master Transmissions &middot; By Eliza James
        </p>
      </div>

      <!-- Top 2-Column Row: Left Prose, Right YouTube Trailer -->
      <div class="grid-balanced-2" style="align-items: start; gap: 48px;">
        <!-- Left: Prose & Narrative -->
        <div class="prose reveal">
          <div class="glass-chip" style="margin-bottom: 18px;">
            <span class="pulse-dot" aria-hidden="true"></span>
            <span>Ascended Master Teachings &middot; St Germain &amp; Serapis Bey</span>
          </div>

          <p class="lede" style="color: var(--ink); font-weight: 600; font-size: 1.12rem; line-height: 1.6; margin-bottom: 18px;">
            <span style="font-weight: normal;">
              &ldquo;The first to the seventh chakra: that which is incarnate, temporal and mortal. The eighth to the twelfth chakra: that which is the I AM, the eternal and infinite.&rdquo;
            </span>
          </p>

          <p style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft); margin-bottom: 20px;">
            <em>Chakra Energetics</em> offers insight into the multidimensional development of the human entity. Drawing on guidance from the Ascended Masters Saint Germain and Serapis Bey, Eliza James elucidates the energetic dynamics of both physical and higher cosmic chakras, understanding of the masculine and feminine energy systems, and unlocking the timeless truth of who we are.
          </p>

          <ul style="margin: 0; padding-left: 20px; font-size: 0.95rem; color: var(--ink-soft); line-height: 1.7;">
            <li><strong>Physical Chakras 1 to 7:</strong> Base, Sacral, Solar Plexus, Heart, Throat, Third Eye &amp; Crown.</li>
            <li><strong>Higher Cosmic Chakras 8 to 13:</strong> Personal, Planetary, Solar, Galactic, Cosmic &amp; the I AM Presence (representing the 13th chakra).</li>
            <li><strong>Ascended Master Teachings:</strong> Channelled wisdom on: Ascension, the Christ Grid, The Seperation experience, The vastness of Dimensional Consciousness and more.</li>
          </ul>
        </div>

        <!-- Right: 3D Book Showcase & Official Trailer Link -->
        <div class="reveal delay-1 book-showcase-column">
          <a href="https://www.youtube.com/watch?v=<?php echo esc_attr($b_chakra_youtube_id); ?>" target="_blank" rel="noopener noreferrer" class="book-3d-presentation" aria-label="Watch Chakra Energetics Official Trailer on YouTube">
            <div class="book-3d-glow" aria-hidden="true"></div>
            <picture>
              <source srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/chakra-energetics-3d.webp" type="image/webp">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/chakra-energetics-3d.png" 
                   alt="Chakra Energetics - 3D Hardcover Rendition" 
                   class="book-3d-mockup-img" 
                   loading="eager" 
                   fetchpriority="high"
                   width="240" 
                   height="330">
            </picture>
          </a>
          <div class="video-footer-link">
            <a href="https://www.youtube.com/watch?v=<?php echo esc_attr($b_chakra_youtube_id); ?>" target="_blank" rel="noopener noreferrer" class="btn-trailer-presence">
              <span class="trailer-play-icon" aria-hidden="true">&#9654;</span>
              <span>Watch Official Trailer on YouTube &#8599;</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Bottom Horizontal Bar: Spans Sideways Underneath Both Writing & Video -->
      <div class="reveal delay-2 book-order-horizontal">
        <!-- Left Side: South Africa Direct (Payfast) -->
        <div class="order-col-domestic">
          <div>
            <div class="channel-top">
              <div>
                <span class="channel-tag">South Africa &middot; Author Direct</span>
                <h4 class="channel-title">Order Directly from Eliza</h4>
              </div>
              <div class="channel-price">
                <span class="price-val"><?php echo esc_html($b_chakra_price); ?></span>
              </div>
            </div>
            <p class="channel-desc">
              Printed through local press and couriered directly to clients across South Africa. Tracked door-to-door courier delivery included. Personal author dedication available upon request. R450 Includes your packaging &amp; delivery. A full refund or replacement will be made if the book is proven to have been damaged in transit. Available Now!
            </p>
          </div>
          <a href="#authorOrderModal" role="button" class="btn-primary-presence open-order-modal" 
             onclick="window.openOrderModal(this); return false;"
             data-product-id="121"
             data-product-type="physical"
             data-book-title="Chakra Energetics"
             data-book-price="<?php echo esc_attr($b_chakra_price); ?>"
             data-book-author="Eliza James">
            <span class="btn-text-content">Order Direct from Author &middot; <?php echo esc_html($b_chakra_price); ?></span>
            <span class="btn-arrow">&rarr;</span>
          </a>
        </div>

        <!-- Right Side: International & Digital Editions -->
        <div class="order-col-intl">
          <div>
            <span class="intl-heading">International &amp; Digital Editions</span>
            <p class="intl-subtext">For readers outside South African borders, or for immediate global delivery:</p>
            
            <div class="retailer-grid-presence">
              <?php if (!empty($b_chakra_amz_paperback)) : ?>
                <a href="<?php echo esc_url($b_chakra_amz_paperback); ?>" target="_blank" rel="noopener noreferrer" class="btn-solid-cta">
                  <span class="btn-text-content">Amazon Paperback</span>
                  <span class="arrow-up">&#8599;</span>
                </a>
              <?php else : ?>
                <a href="#" role="button" class="btn-solid-cta btn-solid-pending" data-notice="The Amazon Paperback listing link for this title will be available shortly.">
                  <span class="btn-text-content">Amazon Paperback (Coming Soon)</span>
                </a>
              <?php endif; ?>

              <?php if (!empty($b_chakra_amz_kindle)) : ?>
                <a href="<?php echo esc_url($b_chakra_amz_kindle); ?>" target="_blank" rel="noopener noreferrer" class="btn-solid-cta">
                  <span class="btn-text-content">Amazon Kindle</span>
                  <span class="arrow-up">&#8599;</span>
                </a>
              <?php else : ?>
                <a href="#" role="button" class="btn-solid-cta btn-solid-pending" data-notice="The Amazon Kindle eBook link for this title will be available shortly.">
                  <span class="btn-text-content">Amazon Kindle (Coming Soon)</span>
                </a>
              <?php endif; ?>

              <?php if (!empty($b_chakra_takealot)) : ?>
                <a href="<?php echo esc_url($b_chakra_takealot); ?>" target="_blank" rel="noopener noreferrer" class="btn-solid-cta">
                  <span class="btn-text-content">Takealot</span>
                  <span class="arrow-up">&#8599;</span>
                </a>
              <?php else : ?>
                <a href="#" role="button" class="btn-solid-cta btn-solid-pending" data-notice="The Takealot listing link for this title will be active soon.">
                  <span class="btn-text-content">Takealot (Coming Soon)</span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- SECTION 2: BOOK 2 SHOWCASE (A Most Extraordinary Journey)                  -->
  <!-- ========================================================================= -->
  <section class="section-alt" id="extraordinary-journey" style="padding: 72px 0 80px;">
    <div class="container-wide">
      <!-- Section Header -->
      <div class="reveal text-center" style="max-width: 860px; margin: 0 auto 44px;">
        <span class="eyebrow">&lang; Publication 02 &rang; &middot; Spiritual Memoir</span>
        <h2 class="section-title">A Most Extraordinary Journey of Self-Discovery</h2>
        <p class="section-intro" style="margin: 12px auto 0; font-family: var(--font-serif); font-size: 1.18rem; font-style: italic; color: var(--ink-soft); max-width: 700px;">
          A 9-Year Spiritual Journey with the Ascended Master St Germain &middot; By Eliza James
        </p>
      </div>

      <!-- Top 2-Column Row: Left Prose, Right YouTube Trailer -->
      <div class="grid-balanced-2" style="align-items: start; gap: 48px;">
        <!-- Left: Prose & Narrative -->
        <div class="prose reveal">
          <div class="glass-chip" style="margin-bottom: 18px;">
            <span class="pulse-dot" aria-hidden="true"></span>
            <span>Spiritual Memoir &middot; Metaphysical Wisdom</span>
          </div>

          <p class="lede" style="color: var(--ink); font-weight: 600; font-size: 1.12rem; line-height: 1.6; margin-bottom: 18px;">
            <span style="font-weight: normal;">
              &ldquo;Being a student and friend of St Germain, Hierarch of this Age of Aquarius, is what continues to bring me the most joy. My nine-year Spiritual Journey under the auspices of Ascended Master St Germain is shared with the world in this work.&rdquo;
            </span>
          </p>

          <p style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft); margin-bottom: 20px;">
            In this deeply personal and transformative book, Eliza chronicles her extraordinary communion with Saint Germain. Spanning profound metaphysical insights, guidance from higher dimensions, and accessing one's inner wisdom, the book serves as a trusted companion for individuals yearning to align with their authentic Self.
          </p>

          <ul style="margin: 0; padding-left: 20px; font-size: 0.95rem; color: var(--ink-soft); line-height: 1.7;">
            <li><strong>Personal Tutelage:</strong> Nine years of direct spiritual guidance under the auspices of St Germain - transcribed and shared for our collective enlightenment.</li>
            <li><strong>The Age of Aquarius:</strong> It's about authentic power of Self and spiritual sovereignty. No parent, priest, guru, politician, not the one next to you that is seemingly more learned, can take responsibility for who you are at your core.</li>
            <li><strong>Sacredness - the way of the heart:</strong> Bringing into the heart and mind - love, honour, respect and finding a new way to BE - authentic and true to Self.</li>
          </ul>
        </div>

        <!-- Right: 3D Book Showcase & Official Trailer Modal Link -->
        <div class="reveal delay-1 book-showcase-column">
          <a href="#extraordinaryTrailerModal" role="button" class="book-3d-presentation open-trailer-modal" aria-label="Watch A Most Extraordinary Journey Official Trailer" onclick="window.openExtraordinaryTrailerModal(this); return false;">
            <div class="book-3d-glow" aria-hidden="true"></div>
            <picture>
              <source srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/extraordinary-journey-3d.webp" type="image/webp">
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/extraordinary-journey-3d.png" 
                   alt="A Most Extraordinary Journey of Self-Discovery - 3D Hardcover Rendition" 
                   class="book-3d-mockup-img" 
                   loading="eager" 
                   fetchpriority="high" 
                   width="240" 
                   height="330">
            </picture>
          </a>
          <div class="video-footer-link">
            <a href="#extraordinaryTrailerModal" role="button" class="btn-trailer-presence open-trailer-modal" onclick="window.openExtraordinaryTrailerModal(this); return false;">
              <span class="trailer-play-icon" aria-hidden="true">&#9654;</span>
              <span>Watch Official Trailer</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Bottom Horizontal Bar: Spans Sideways Underneath Both Writing & Video -->
      <div class="reveal delay-2 book-order-horizontal">
        <!-- Left Side: South Africa Direct (Payfast) -->
        <div class="order-col-domestic">
          <div>
            <div class="channel-top">
              <div>
                <span class="channel-tag">South Africa &middot; Author Direct</span>
                <h4 class="channel-title">Order Directly from Eliza</h4>
              </div>
              <div class="channel-price">
                <span class="price-val"><?php echo esc_html($b_extraordinary_price); ?></span>
              </div>
            </div>
            <p class="channel-desc">
              Printed through local press and couriered directly to clients across South Africa. Tracked door-to-door courier delivery included. Personal author dedication available upon request. R450 Includes your packaging &amp; delivery. A full refund or replacement will be made if the book is proven to have been damaged in transit. Available 15 December. Pre-order by 30 November and get your signed copy at R300.
            </p>
          </div>
          <a href="#authorOrderModal" role="button" class="btn-primary-presence open-order-modal" 
             onclick="window.openOrderModal(this); return false;"
             data-product-id="120"
             data-product-type="physical"
             data-book-title="A Most Extraordinary Journey of Self-Discovery"
             data-book-price="<?php echo esc_attr($b_extraordinary_price); ?>"
             data-book-author="Eliza James">
            <span class="btn-text-content">Order Direct from Author &middot; <?php echo esc_html($b_extraordinary_price); ?></span>
            <span class="btn-arrow">&rarr;</span>
          </a>
        </div>

        <!-- Right Side: International & Digital Editions -->
        <div class="order-col-intl">
          <div>
            <span class="intl-heading">International &amp; Digital Editions</span>
            <p class="intl-subtext">For readers outside South African borders, or for immediate digital delivery:</p>
            
            <div class="retailer-grid-presence">
              <?php if (!empty($b_extraordinary_amz_paperback)) : ?>
                <a href="<?php echo esc_url($b_extraordinary_amz_paperback); ?>" target="_blank" rel="noopener noreferrer" class="btn-solid-cta">
                  <span class="btn-text-content">Amazon Paperback</span>
                  <span class="arrow-up">&#8599;</span>
                </a>
              <?php else : ?>
                <a href="#" role="button" class="btn-solid-cta btn-solid-pending" data-notice="The Amazon Paperback listing link for this title will be available shortly.">
                  <span class="btn-text-content">Amazon Paperback (Coming Soon)</span>
                </a>
              <?php endif; ?>

              <?php if (!empty($b_extraordinary_amz_kindle)) : ?>
                <a href="<?php echo esc_url($b_extraordinary_amz_kindle); ?>" target="_blank" rel="noopener noreferrer" class="btn-solid-cta">
                  <span class="btn-text-content">Amazon Kindle</span>
                  <span class="arrow-up">&#8599;</span>
                </a>
              <?php else : ?>
                <a href="#" role="button" class="btn-solid-cta btn-solid-pending" data-notice="The Amazon Kindle eBook link for this title will be available shortly.">
                  <span class="btn-text-content">Amazon Kindle (Coming Soon)</span>
                </a>
              <?php endif; ?>

              <?php if (!empty($b_extraordinary_takealot)) : ?>
                <a href="<?php echo esc_url($b_extraordinary_takealot); ?>" target="_blank" rel="noopener noreferrer" class="btn-solid-cta">
                  <span class="btn-text-content">Takealot</span>
                  <span class="arrow-up">&#8599;</span>
                </a>
              <?php else : ?>
                <a href="#" role="button" class="btn-solid-cta btn-solid-pending" data-notice="The Takealot listing link for this title will be active soon.">
                  <span class="btn-text-content">Takealot (Coming Soon)</span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- SECTION 3: DIGITAL PUBLICATIONS & SACRED GUIDES (DYNAMIC PDF EDITIONS)     -->
  <!-- Toggled hidden pending publication file setup                              -->
  <!-- ========================================================================= -->
  <section class="section-subtle" id="digital-editions" style="display: none; padding: 72px 0 80px; border-top: 1px solid rgba(212,175,55,0.25);">
    <div class="container-wide">
      <div class="reveal text-center" style="max-width: 840px; margin: 0 auto 44px;">
        <span class="eyebrow">&lang; Digital Library &rang; &middot; Instant PDF Editions</span>
        <h2 class="section-title">Digital Guides &amp; Sacred PDF Publications</h2>
        <p class="section-intro" style="margin: 12px auto 0; font-family: var(--font-serif); font-size: 1.18rem; font-style: italic; color: var(--ink-soft); max-width: 700px;">
          Sacred wisdom, guided companion materials, and printable workbooks available for immediate digital delivery to your inbox upon purchase.
        </p>
      </div>

      <?php echo eliza_render_digital_products_grid(); ?>
    </div>
  </section>

  <!-- Author Direct Service Information Strip (No Emojis) -->
  <section style="background: var(--bg); padding: 56px 0; border-top: 1px solid rgba(212,175,55,0.2);">
    <div class="container">
      <div class="grid-balanced-3" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 28px;">
        <div class="glass-box" style="padding: 24px;">
          <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.05rem;">
            Author Signed Copies
          </h4>
          <p style="margin: 0; font-size: 0.92rem; color: var(--ink-soft); line-height: 1.55;">
            Orders placed directly through this website may, on request, include a personalized handwritten message or dedication signed by Eliza.
          </p>
        </div>

        <div class="glass-box" style="padding: 24px;">
          <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.05rem;">
            Nationwide Courier Delivery
          </h4>
          <p style="margin: 0; font-size: 0.92rem; color: var(--ink-soft); line-height: 1.55;">
            Delivered anywhere in South Africa via secure, tracked door-to-door courier to your door within 10 to 14 business days.
          </p>
        </div>

        <div class="glass-box" style="padding: 24px;">
          <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.05rem;">
            Secure Payfast Processing
          </h4>
          <p style="margin: 0; font-size: 0.92rem; color: var(--ink-soft); line-height: 1.55;">
            Pay securely with South Africa's leading payment gateway supporting Visa, Mastercard, Instant EFT, SnapScan, and Zapper.
          </p>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
    }
?>

<!-- REMASTERED 1080P BOOK TRAILER MODAL (GOLDEN DAWN COVER, NO AUSTIN MACAULEY) -->
<div id="extraordinaryTrailerModal" class="order-modal-backdrop" onclick="if(event.target===this) window.closeExtraordinaryTrailerModal();" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="trailerModalTitle">
  <div class="order-modal-card" style="max-width: 900px; width: 92%; padding: 24px; background: rgba(18, 22, 34, 0.96); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1.5px solid rgba(212, 175, 55, 0.45); border-radius: 18px; box-shadow: 0 25px 60px rgba(0,0,0,0.65), 0 0 40px rgba(212,175,55,0.15);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid rgba(212,175,55,0.2); padding-bottom: 12px;">
      <div>
        <span class="eyebrow" style="color: #d4af37; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.12em; display: block; margin-bottom: 4px;">Official Book Trailer</span>
        <h3 id="trailerModalTitle" style="margin: 0; font-family: var(--font-serif); font-size: 1.35rem; color: #fff; font-weight: 500;">A Most Extraordinary Journey of Self-Discovery</h3>
      </div>
      <button type="button" class="order-modal-close" onclick="window.closeExtraordinaryTrailerModal();" aria-label="Close Video" style="position: static; font-size: 2rem; color: #d4af37; background: transparent; border: none; cursor: pointer; line-height: 1; padding: 4px 8px;">&times;</button>
    </div>
    
    <div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border: 1px solid rgba(212,175,55,0.25);">
      <video id="extraordinaryTrailerVideo" controls playsinline preload="metadata" style="width: 100%; height: 100%; object-fit: cover; display: block;" poster="<?php echo esc_url(get_template_directory_uri()); ?>/assets/extraordinary-journey-3d.webp">
        <source src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/extraordinary-journey-trailer.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    
    <div style="margin-top: 14px; display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; color: rgba(255,255,255,0.7); flex-wrap: wrap; gap: 10px;">
      <span>Featuring Eliza James &middot; 9-Year Spiritual Journey with St Germain</span>
      <span style="color: #d4af37; font-size: 0.8rem;">1080p Full HD &middot; Author Edition</span>
    </div>
  </div>
</div>

<!-- ORDER FROM AUTHOR MODAL (NO EMOJIS, CLEAN LUXURY) -->
<div id="authorOrderModal" class="order-modal-backdrop" onclick="if(event.target===this) window.closeOrderModal();" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalBookTitle">
  <div class="order-modal-card">
    <button type="button" class="order-modal-close" onclick="window.closeOrderModal();" aria-label="Close Order Window">&times;</button>
    
    <div class="order-modal-header">
      <span class="eyebrow" id="modalOrderBadge" style="color: var(--gold); font-size: 0.78rem;">Direct Author Order &middot; South Africa Only</span>
      <h3 id="modalBookTitle" style="margin: 6px 0 4px; font-family: var(--font-serif); font-size: 1.45rem; color: var(--ink);">Book Title</h3>
      <div id="modalBookPrice" style="font-weight: 700; color: var(--copper, #A85A32); font-size: 1.25rem; margin-bottom: 8px;">R450</div>
      <p id="modalOrderSubtext" style="margin: 0; font-size: 0.88rem; color: var(--ink-soft); line-height: 1.5;">
        Please enter your South African shipping information. Includes tracked door-to-door courier delivery across all 9 provinces within 10 to 14 business days.
      </p>
    </div>

    <form id="authorOrderForm" class="order-modal-form" onsubmit="handleOrderSubmit(event)">
      <input type="hidden" id="orderProductId" name="product_id" value="0">
      <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px;">
        <div class="form-group">
          <label for="orderName">Full Name *</label>
          <input type="text" id="orderName" name="customer_name" required placeholder="e.g. Sarah van der Merwe">
        </div>
        <div class="form-group">
          <label for="orderPhone">Mobile Number (for SMS / Order Updates) *</label>
          <input type="tel" id="orderPhone" name="customer_phone" required placeholder="e.g. 082 123 4567" pattern="[0-9+ ]{10,14}">
        </div>
      </div>

      <div class="form-group" style="margin-top: 12px;">
        <label for="orderEmail">Email Address (for Receipt &amp; Digital PDF Delivery) *</label>
        <input type="email" id="orderEmail" name="customer_email" required placeholder="name@example.com">
      </div>

      <div class="form-group physical-only-field" style="margin-top: 12px;">
        <label for="orderStreet">Physical Street Address (Door Delivery) *</label>
        <input type="text" id="orderStreet" name="street_address" required placeholder="e.g. 12 Promenade Road">
      </div>

      <div class="form-row physical-only-field" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 12px;">
        <div class="form-group">
          <label for="orderCity">City / Town *</label>
          <input type="text" id="orderCity" name="city" required placeholder="e.g. Cape Town">
        </div>
        <div class="form-group">
          <label for="orderProvince">Province *</label>
          <select id="orderProvince" name="province" required>
            <option value="">Select Province</option>
            <option value="Western Cape">Western Cape</option>
            <option value="Gauteng">Gauteng</option>
            <option value="KwaZulu-Natal">KwaZulu-Natal</option>
            <option value="Eastern Cape">Eastern Cape</option>
            <option value="Free State">Free State</option>
            <option value="Mpumalanga">Mpumalanga</option>
            <option value="Limpopo">Limpopo</option>
            <option value="North West">North West</option>
            <option value="Northern Cape">Northern Cape</option>
          </select>
        </div>
        <div class="form-group">
          <label for="orderPostal">Postal Code *</label>
          <input type="text" id="orderPostal" name="postal_code" required placeholder="e.g. 7945">
        </div>
      </div>

      <div class="form-group physical-only-field" style="margin-top: 12px;">
        <label for="orderDedication">Optional Inscription / Personal Dedication</label>
        <textarea id="orderDedication" name="dedication" rows="2" placeholder="If you'd like Eliza to sign the book to a specific name or include a personal blessing, mention it here."></textarea>
      </div>

      <!-- PAYFAST PAYMENT SECTION -->
      <div class="payfast-checkout-box" style="margin-top: 20px; padding: 18px; border-radius: 8px; background: rgba(212,175,55,0.06); border: 1px solid rgba(212,175,55,0.35);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
          <div>
            <span style="font-weight: 600; font-size: 0.95rem; color: var(--ink);">Payment Gateway:</span>
            <span style="font-size: 0.85rem; color: var(--ink-soft); display: block;">Instant EFT, Credit/Debit Card, SnapScan, Zapper, Capitec Pay</span>
          </div>
          <div style="display: flex; gap: 6px; align-items: center;">
            <span style="display: inline-flex; align-items: center; background: #fff; padding: 4px 10px; border-radius: 4px; border: 1px solid #ddd; font-weight: 700; font-size: 0.85rem; color: #EE2E24; letter-spacing: -0.02em;">
              Pay<span style="color:#009FE3;">Fast</span>
            </span>
          </div>
        </div>

        <!-- TERMS & CONDITIONS AND POLICY CONFIRMATION (PAYFAST COMPLIANCE) -->
        <div class="order-terms-agreement" style="margin-bottom: 16px; padding: 12px 14px; border-radius: 8px; background: rgba(255,255,255,0.92); border: 1px solid rgba(212,175,55,0.32);">
          <label for="orderTermsCheckbox" style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 0.84rem; color: var(--ink); line-height: 1.5; margin: 0;">
            <input type="checkbox" id="orderTermsCheckbox" name="terms_confirmed" required style="margin-top: 3px; width: 17px; height: 17px; accent-color: var(--gold-dark, #AA7C11); cursor: pointer; flex-shrink: 0;">
            <span>
              I agree to the 
              <a href="<?php echo esc_url(home_url('/terms/')); ?>" target="_blank" rel="noopener noreferrer" style="color: var(--gold-dark, #AA7C11); font-weight: 600; text-decoration: underline;">Terms &amp; Conditions</a>, 
              including the 
              <a href="<?php echo esc_url(home_url('/terms/#delivery')); ?>" target="_blank" rel="noopener noreferrer" style="color: var(--gold-dark, #AA7C11); font-weight: 600; text-decoration: underline;">Delivery Policy (10&ndash;14 business days via courier)</a>, 
              and the 
              <a href="<?php echo esc_url(home_url('/terms/#refunds')); ?>" target="_blank" rel="noopener noreferrer" style="color: var(--gold-dark, #AA7C11); font-weight: 600; text-decoration: underline;">Refund &amp; Cancellation Policy</a>. *
            </span>
          </label>
          <div style="margin-top: 8px; padding-top: 8px; border-top: 1px dashed rgba(212,175,55,0.25); display: flex; justify-content: space-between; align-items: center; font-size: 0.78rem; color: var(--ink-soft);">
            <span>Door-to-door tracked courier within 10 to 14 business days</span>
            <button type="button" onclick="window.toggleTermsDrawer(event)" style="background: none; border: none; padding: 0; color: var(--gold-dark, #AA7C11); font-weight: 600; font-size: 0.78rem; cursor: pointer; text-decoration: underline;">
              View Policy Summary &darr;
            </button>
          </div>
          <!-- Collapsible Quick Policy Summary Drawer for instant viewing inside checkout -->
          <div id="checkoutTermsDrawer" style="display: none; margin-top: 10px; padding: 12px; background: rgba(250,248,245,0.95); border-radius: 6px; border: 1px solid rgba(212,175,55,0.2); font-size: 0.78rem; color: var(--ink-soft); line-height: 1.55; max-height: 180px; overflow-y: auto;">
            <p style="margin: 0 0 6px 0;"><strong>Delivery Policy:</strong> Physical books are couriered door-to-door within 10 to 14 business days across South Africa. Tracking number sent via SMS/Email. Digital PDFs are delivered instantly to your email upon payment.</p>
            <p style="margin: 0 0 6px 0;"><strong>Refund &amp; Return Policy:</strong> In line with the CPA, damaged or defective books will be replaced immediately or fully refunded within 14 days of receipt. Due to instant access, digital downloads are non-refundable unless technically defective.</p>
            <p style="margin: 0 0 6px 0;"><strong>Cancellation Policy:</strong> Orders can be cancelled prior to courier dispatch for a 100% refund. Once dispatched, standard return procedures apply.</p>
            <p style="margin: 0;"><strong>Secure Payments:</strong> Processed through PayFast (Pty) Ltd with 256-bit SSL encryption. We never store card or banking details.</p>
          </div>
        </div>

        <button type="submit" id="payfastButton" class="btn btn-primary" style="width: 100%; display: flex; justify-content: center; align-items: center; gap: 10px; font-size: 1rem; padding: 14px 20px; background: linear-gradient(135deg, #170F0A 0%, #301E13 100%); border: 1.5px solid var(--gold);">
          <span>Pay with Payfast &middot; R450</span>
        </button>

        <div id="payfastNotice" style="margin-top: 10px; font-size: 0.8rem; color: var(--ink-soft); text-align: center;">
          <em>Secure 256-bit encrypted PayFast South Africa connection. You will be forwarded to PayFast to complete payment via Card, Instant EFT, SnapScan or Zapper.</em>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
/* ========================================================================= */
/* HORIZONTAL SIDEWAYS ACQUISITION CARD STYLING */
/* ========================================================================= */
.book-order-horizontal {
  margin-top: 40px;
  background: rgba(255, 255, 255, 0.75);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1.5px solid rgba(212, 175, 55, 0.35);
  border-radius: 16px;
  box-shadow: 0 16px 45px rgba(0, 0, 0, 0.06);
  display: grid;
  grid-template-columns: 1.15fr 1fr;
  overflow: hidden;
}

@media (max-width: 960px) {
  .book-order-horizontal {
    grid-template-columns: 1fr;
  }
}

.order-col-domestic {
  padding: 34px 38px;
  background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.02) 100%);
  border-right: 1px solid rgba(212, 175, 55, 0.22);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 22px;
}

@media (max-width: 960px) {
  .order-col-domestic {
    border-right: none;
    border-bottom: 1px solid rgba(212, 175, 55, 0.22);
    padding: 26px 22px;
  }
}

.order-col-intl {
  padding: 34px 38px;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

@media (max-width: 960px) {
  .order-col-intl {
    padding: 26px 22px;
  }
}

.channel-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 16px;
  margin-bottom: 12px;
}

.channel-tag {
  display: inline-block;
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--gold-dark, #AA7C11);
  margin-bottom: 4px;
}

.channel-title {
  margin: 0;
  font-family: var(--font-serif);
  font-size: 1.35rem;
  font-weight: 600;
  color: var(--ink);
}

.channel-price {
  display: flex;
  align-items: baseline;
  color: var(--copper, #A85A32);
  font-weight: 700;
}

.price-currency {
  font-size: 1.05rem;
  margin-right: 2px;
}

.price-val {
  font-family: var(--font-serif);
  font-size: 1.85rem;
  line-height: 1;
}

.channel-desc {
  margin: 0;
  font-size: 0.93rem;
  line-height: 1.6;
  color: var(--ink-soft);
}

/* High-Presence Primary Action Button */
.btn-primary-presence {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  padding: 15px 28px;
  font-size: 1.02rem;
  font-weight: 600;
  letter-spacing: 0.02em;
  color: #FFFDF9;
  background: linear-gradient(135deg, #1C120C 0%, #382417 50%, #1C120C 100%);
  border: 1.5px solid var(--gold);
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 0 8px 24px rgba(28, 18, 12, 0.25);
  transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
  width: 100%;
}

.btn-primary-presence:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(170, 124, 17, 0.35);
  background: linear-gradient(135deg, #2A1B12 0%, #4D3220 50%, #2A1B12 100%);
}

.btn-arrow {
  font-size: 1.15rem;
  transition: transform 0.2s ease;
}

.btn-primary-presence:hover .btn-arrow {
  transform: translateX(4px);
}

/* International Side */
.intl-heading {
  display: block;
  font-size: 0.82rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  color: var(--ink);
  margin-bottom: 6px;
}

.intl-subtext {
  margin: 0 0 16px 0;
  font-size: 0.9rem;
  color: var(--ink-soft);
  line-height: 1.5;
}

.retailer-grid-presence {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
  gap: 12px;
}

/* High-Presence Solid Retailer Buttons */
.btn-solid-cta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  padding: 13px 18px;
  font-size: 0.88rem;
  font-weight: 600;
  color: var(--ink);
  background: #FFFFFF;
  border: 1.5px solid rgba(212, 175, 55, 0.45);
  border-radius: 8px;
  text-decoration: none;
  cursor: pointer;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
  transition: all 0.2s ease;
}

.btn-solid-cta:hover {
  background: #FAF6EE;
  border-color: var(--gold-dark, #AA7C11);
  color: var(--gold-dark, #AA7C11);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(170, 124, 17, 0.2);
}

.btn-solid-pending {
  background: #F8F7F4;
  border: 1.5px solid rgba(0, 0, 0, 0.12);
  color: var(--ink-soft);
  cursor: pointer;
}

.btn-solid-pending:hover {
  background: #F0EDE6;
  border-color: rgba(212, 175, 55, 0.45);
  color: var(--ink);
}

.arrow-up {
  font-size: 0.88rem;
  opacity: 0.75;
}

/* ========================================================================= */
/* MODAL STYLES */
/* ========================================================================= */
.order-modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(10, 7, 5, 0.78);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  z-index: 999999 !important;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s;
}

.order-modal-backdrop.is-active {
  opacity: 1 !important;
  visibility: visible !important;
  pointer-events: auto !important;
}

.order-modal-card {
  background: var(--bg-card, #FFFDFB);
  border: 1px solid rgba(212, 175, 55, 0.4);
  border-radius: 14px;
  max-width: 620px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  padding: 32px 28px;
  box-shadow: 0 24px 60px rgba(0,0,0,0.35);
  position: relative;
  transform: translateY(20px) scale(0.98);
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.order-modal-backdrop.is-active .order-modal-card {
  transform: translateY(0) scale(1);
}

.order-modal-close {
  position: absolute;
  top: 16px;
  right: 16px;
  background: transparent;
  border: none;
  font-size: 28px;
  line-height: 1;
  color: var(--ink-soft);
  cursor: pointer;
  padding: 4px 8px;
  transition: color 0.2s;
}

.order-modal-close:hover {
  color: var(--ink);
}

.order-modal-form .form-group label {
  display: block;
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--ink);
  margin-bottom: 5px;
  letter-spacing: 0.02em;
}

.order-modal-form input[type="text"],
.order-modal-form input[type="email"],
.order-modal-form input[type="tel"],
.order-modal-form select,
.order-modal-form textarea {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid rgba(0,0,0,0.15);
  border-radius: 6px;
  font-family: inherit;
  font-size: 0.92rem;
  color: var(--ink);
  background: #FFF;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.order-modal-form input:focus,
.order-modal-form select:focus,
.order-modal-form textarea:focus {
  outline: none;
  border-color: var(--gold);
  box-shadow: 0 0 0 3px rgba(212,175,55,0.2);
}
</style>

<script>
window.currentProductType = 'physical';
window.currentProductPrice = 'R450';

window.openOrderModal = function(btn) {
  var modal = document.getElementById('authorOrderModal');
  if (!modal) {
    console.warn('Order modal element #authorOrderModal not found');
    return false;
  }

  var targetBtn = (btn && btn.closest) ? (btn.closest('.open-order-modal') || btn) : btn;
  var productId = (targetBtn && targetBtn.getAttribute) ? (targetBtn.getAttribute('data-product-id') || '0') : '0';
  var productType = (targetBtn && targetBtn.getAttribute) ? (targetBtn.getAttribute('data-product-type') || 'physical') : 'physical';
  var title = (targetBtn && targetBtn.getAttribute) ? (targetBtn.getAttribute('data-book-title') || 'Publication Order') : 'Publication Order';

  // Smart price detection: check data-book-price, or dynamically read from parent price badge
  var priceAttr = (targetBtn && targetBtn.getAttribute) ? targetBtn.getAttribute('data-book-price') : null;
  var cardPriceEl = (targetBtn && targetBtn.closest) ? (targetBtn.closest('.order-col-domestic, .pdf-product-card, .book-order-horizontal, .channel-top, .test-product-card') ? targetBtn.closest('.order-col-domestic, .pdf-product-card, .book-order-horizontal, .channel-top, .test-product-card').querySelector('.price-val') : null) : null;
  var detectedCardPrice = cardPriceEl ? cardPriceEl.textContent.trim() : null;

  var price = priceAttr || detectedCardPrice || 'R450';
  if (price === 'R550' && detectedCardPrice && detectedCardPrice !== 'R550') {
    price = detectedCardPrice;
  }

  window.currentProductId = productId;
  window.currentProductType = productType;
  window.currentProductPrice = price;

  var prodIdInput = document.getElementById('orderProductId');
  if (prodIdInput) prodIdInput.value = productId;

  var modalTitle = document.getElementById('modalBookTitle');
  var modalPrice = document.getElementById('modalBookPrice');
  var modalBadge = document.getElementById('modalOrderBadge');
  var modalSubtext = document.getElementById('modalOrderSubtext');
  var payfastButton = document.getElementById('payfastButton');

  if (modalTitle) modalTitle.textContent = title;

  var courierFields = modal.querySelectorAll('.physical-only-field');

  if (productType === 'digital') {
    if (modalBadge) modalBadge.textContent = 'Direct Author Order \u00B7 Instant Digital Download';
    if (modalPrice) modalPrice.textContent = price + ' (Immediate PDF Email Delivery)';
    if (modalSubtext) modalSubtext.textContent = 'Enter your contact details below. Your secure PDF download link will be emailed immediately upon successful Payfast payment.';
    courierFields.forEach(function(el) {
      el.style.display = 'none';
      var inputs = el.querySelectorAll('input, select, textarea');
      inputs.forEach(function(inp) { inp.required = false; });
    });
    if (payfastButton) payfastButton.innerHTML = '<span>Pay with Payfast \u00B7 ' + price + '</span>';
  } else {
    if (modalBadge) modalBadge.textContent = 'Direct Author Order \u00B7 South Africa Only';
    if (modalPrice) modalPrice.textContent = price + ' (Tracked SA Courier Included)';
    if (modalSubtext) modalSubtext.textContent = 'Please enter your South African shipping information. Includes tracked door-to-door courier delivery across all 9 provinces within 10 to 14 business days.';
    courierFields.forEach(function(el) {
      el.style.display = '';
      var inputs = el.querySelectorAll('input, select');
      inputs.forEach(function(inp) {
        if (inp.id !== 'orderDedication') inp.required = true;
      });
    });
    if (payfastButton) payfastButton.innerHTML = '<span>Pay with Payfast \u00B7 ' + price + '</span>';
  }

  modal.classList.add('is-active');
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';
  var firstInput = modal.querySelector('input');
  if (firstInput) setTimeout(function() { firstInput.focus(); }, 100);
  return false;
};

window.closeOrderModal = function() {
  var modal = document.getElementById('authorOrderModal');
  if (modal) {
    modal.classList.remove('is-active');
    modal.setAttribute('aria-hidden', 'true');
  }
  document.body.style.overflow = '';
};

window.openExtraordinaryTrailerModal = function(triggerEl) {
  var modal = document.getElementById('extraordinaryTrailerModal');
  var video = document.getElementById('extraordinaryTrailerVideo');
  if (modal) {
    modal.classList.add('is-active');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    if (video) {
      video.currentTime = 0;
      video.play().catch(function() { /* Autoplay restriction fallback */ });
    }
  }
};

window.closeExtraordinaryTrailerModal = function() {
  var modal = document.getElementById('extraordinaryTrailerModal');
  var video = document.getElementById('extraordinaryTrailerVideo');
  if (modal) {
    modal.classList.remove('is-active');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (video) {
      video.pause();
    }
  }
};

// Delegated click listener ensures all buttons with .open-order-modal always trigger the modal
document.addEventListener('click', function(e) {
  var btn = e.target.closest ? e.target.closest('.open-order-modal') : null;
  if (btn) {
    if (e.target.classList && (e.target.classList.contains('eliza-btn-url-badge') || (e.target.closest && e.target.closest('.eliza-btn-url-badge')))) {
      return;
    }
    e.preventDefault();
    e.stopPropagation();
    window.openOrderModal(btn);
  }

  var trailerBtn = e.target.closest ? e.target.closest('.open-trailer-modal') : null;
  if (trailerBtn) {
    e.preventDefault();
    e.stopPropagation();
    window.openExtraordinaryTrailerModal(trailerBtn);
  }
});

// Intercept any legacy Austin Macauley video links (VmsQBtoa7h0) dynamically
document.addEventListener('DOMContentLoaded', function() {
  var legacyTrailerLinks = document.querySelectorAll('a[href*="VmsQBtoa7h0"]');
  legacyTrailerLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      window.openExtraordinaryTrailerModal(this);
    });
  });

  var pendingLinks = document.querySelectorAll('.btn-solid-pending');
  pendingLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      if (document.body.classList.contains('eliza-edit-active')) {
        return;
      }
      e.preventDefault();
      var msg = this.getAttribute('data-notice') || 'This listing will be active shortly.';
      alert(msg);
    });
  });
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    window.closeOrderModal();
    window.closeExtraordinaryTrailerModal();
  }
});

window.toggleTermsDrawer = function(e) {
  if (e && e.preventDefault) e.preventDefault();
  var drawer = document.getElementById('checkoutTermsDrawer');
  if (drawer) {
    drawer.style.display = (drawer.style.display === 'none' || !drawer.style.display) ? 'block' : 'none';
  }
};

window.handleOrderSubmit = function(e) {
  e.preventDefault();
  var form = e.target;

  if (form.terms_confirmed && !form.terms_confirmed.checked) {
    alert('Please confirm that you agree to the Terms & Conditions, Delivery, and Refund policies before proceeding to payment.');
    form.terms_confirmed.focus();
    return false;
  }

  var notice = document.getElementById('payfastNotice');
  var submitBtn = document.getElementById('payfastButton');
  var title = document.getElementById('modalBookTitle') ? document.getElementById('modalBookTitle').textContent : 'Publication';
  var price = window.currentProductPrice || 'R450';

  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>Connecting to Secure PayFast...</span>';
  }
  if (notice) notice.innerHTML = '<span style="color: #8e6516; font-weight: 600;">Securely signing transaction and forwarding to PayFast...</span>';

  var formData = new FormData(form);
  formData.append('action', 'eliza_payfast_checkout');
  formData.append('product_id', window.currentProductId || '0');
  formData.append('product_type', window.currentProductType || 'physical');
  formData.append('book_title', title);
  formData.append('book_price', price);

  fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
    method: 'POST',
    body: formData
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    if (data.success && data.data && data.data.process_url && data.data.fields) {
      if (notice) notice.innerHTML = '<span style="color: #2e7d32; font-weight: 600;">Forwarding directly to PayFast South Africa...</span>';

      var pfForm = document.createElement('form');
      pfForm.method = 'POST';
      pfForm.action = data.data.process_url;
      pfForm.style.display = 'none';

      var canonicalKeys = [
        'merchant_id', 'merchant_key', 'return_url', 'cancel_url', 'notify_url',
        'name_first', 'name_last', 'email_address', 'cell_number', 'm_payment_id',
        'amount', 'item_name', 'item_description',
        'custom_int1', 'custom_int2', 'custom_int3', 'custom_int4', 'custom_int5',
        'custom_str1', 'custom_str2', 'custom_str3', 'custom_str4', 'custom_str5',
        'email_confirmation', 'confirmation_address', 'payment_method',
        'signature'
      ];

      canonicalKeys.forEach(function(k) {
        if (data.data.fields[k] !== undefined && data.data.fields[k] !== null && data.data.fields[k] !== '') {
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = k;
          input.value = data.data.fields[k];
          pfForm.appendChild(input);
        }
      });
      for (var [key, value] of Object.entries(data.data.fields)) {
        if (canonicalKeys.indexOf(key) === -1 && value !== '' && value !== null) {
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = key;
          input.value = value;
          pfForm.appendChild(input);
        }
      }

      document.body.appendChild(pfForm);
      pfForm.submit();
    } else {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>Pay with Payfast &middot; ' + price + '</span>';
      }
      var errMsg = (data.data && data.data.message) ? data.data.message : 'Error preparing checkout. Please verify your details.';
      if (notice) notice.innerHTML = '<span style="color: #dc2626;">' + errMsg + '</span>';
      alert(errMsg);
    }
  })
  .catch(function(err) {
    console.error('PayFast checkout error:', err);
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = '<span>Pay with Payfast &middot; ' + price + '</span>';
    }
    if (notice) notice.innerHTML = '<span style="color: #dc2626;">Connection error. Please try again.</span>';
    alert('Unable to connect to checkout gateway. Please check your internet connection or contact Eliza directly.');
  });
};
</script>
<?php
get_footer();
