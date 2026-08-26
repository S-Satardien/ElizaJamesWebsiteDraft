<?php
/**
 * Footer template for Eliza Reconnection Theme
 */
$global_phone    = eliza_field("global_phone", "082 926 9851", "option");
$global_email    = eliza_field("global_email", "eliza.reconnection@gmail.com", "option");
$global_address  = eliza_field("global_address", "Promenade Road, Lakeside, Cape Town, South Africa", "option");
$facebook_url    = eliza_field("facebook_url", "https://www.facebook.com/eliza.james1/", "option");
$instagram_url   = eliza_field("instagram_url", "https://www.instagram.com/eliza.mudita", "option");
$linkedin_url    = eliza_field("linkedin_url", "https://www.linkedin.com/in/eliza-james-8789b3109/", "option");
$phone_clean     = preg_replace("/[^0-9+]/", "", $global_phone);
?>
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <h4>
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M12 2c1.6 2.1 2.6 3.8 2.6 5.4 0 1.2-.8 2-1.8 2s-1.7-.8-1.7-1.8c0-.6.2-1.1.5-1.6-1.1.8-1.9 2.1-1.9 3.6a3 3 0 0 0 3 3 3.9 3.9 0 0 0 3.3-4.1C16 6.2 13.7 3.7 12 2z"/>
            </svg>
            Eliza Reconnection
          </h4>
          <p><?php echo esc_html(eliza_field("footer_bio", "Reconnective Healing, Consciousness Coaching, and Meditation & Conscious Breathing — practiced with care from a home office in Lakeside, Cape Town.", "option")); ?></p>
        </div>
        <div>
          <h4>
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="8.5" fill="none" stroke="currentColor" stroke-width="1.8"/>
              <path d="M15 9l-2 4.5L8.5 15l2-4.5z" fill="currentColor"/>
            </svg>
            Explore
          </h4>
          <ul>
            <li><a href="<?php echo esc_url(home_url("/about/")); ?>">About</a></li>
            <li><a href="<?php echo esc_url(home_url("/services/")); ?>">Services &amp; Coaching</a></li>
            <li><a href="<?php echo esc_url(home_url("/science-evidence/")); ?>">Evidence &amp; Science</a></li>
            <li><a href="<?php echo esc_url(home_url("/results/")); ?>">Results &amp; Voices</a></li>
          </ul>
        </div>
        <div>
          <h4>
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <rect x="3.5" y="5.5" width="17" height="13" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/>
              <path d="M4 6.5l8 6.5 8-6.5" fill="none" stroke="currentColor" stroke-width="1.8"/>
            </svg>
            Get in touch
          </h4>
          <ul>
            <li><a href="tel:<?php echo esc_attr($phone_clean); ?>"><?php echo esc_html($global_phone); ?></a></li>
            <li><a href="mailto:<?php echo esc_attr($global_email); ?>"><?php echo esc_html($global_email); ?></a></li>
            <li><?php echo esc_html($global_address); ?></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <span>&copy; <?php echo date("Y"); ?> Eliza Reconnection. All rights reserved.</span>
        <div class="social-row">
          <?php if ($facebook_url): ?>
          <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener" aria-label="Facebook">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 21v-8h2.7l.4-3.1h-3.1V8c0-.9.2-1.5 1.6-1.5H17V3.7C16.7 3.6 15.6 3.5 14.4 3.5c-2.6 0-4.4 1.6-4.4 4.5v2h-3v3.1h3V21h3.5z" fill="currentColor"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($instagram_url): ?>
          <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="5" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="4.2" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="17.2" cy="6.8" r="1.1" fill="currentColor"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($linkedin_url): ?>
          <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="3" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="8" cy="8.2" r="1.3" fill="currentColor"/><line x1="8" y1="11" x2="8" y2="17" stroke="currentColor" stroke-width="1.8"/><path d="M12 17v-3.5c0-1.6 1-2.5 2.3-2.5s2.2.9 2.2 2.5V17" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
