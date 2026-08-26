<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <a class="skip-link" href="#main"><?php esc_html_e("Skip to content", "eliza-reconnection"); ?></a>

  <header class="site-header">
    <div class="bar">
      <a class="brand" href="<?php echo esc_url(home_url("/")); ?>" aria-label="<?php esc_attr_e("Eliza Reconnection Home", "eliza-reconnection"); ?>">
        <span class="brand-mark" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2c1.6 2.1 2.6 3.8 2.6 5.4 0 1.2-.8 2-1.8 2s-1.7-.8-1.7-1.8c0-.6.2-1.1.5-1.6-1.1.8-1.9 2.1-1.9 3.6a3 3 0 0 0 3 3 3.9 3.9 0 0 0 3.3-4.1C16 6.2 13.7 3.7 12 2z"/>
          </svg>
        </span>
        <span class="brand-name">Eliza<small>Sacred Alignment</small></span>
      </a>

      <nav class="main-nav" aria-label="<?php esc_attr_e("Primary Navigation", "eliza-reconnection"); ?>">
        <?php
        if (has_nav_menu("primary-menu")) {
            wp_nav_menu(array(
                "theme_location" => "primary-menu",
                "container"      => false,
                "items_wrap"     => "<ul>%3$s</ul>",
                "fallback_cb"    => false,
            ));
        } else {
            ?>
            <ul>
              <li><a href="<?php echo esc_url(home_url("/")); ?>" <?php echo is_front_page() ? "aria-current=\"page\"" : ""; ?>>Home</a></li>
              <li><a href="<?php echo esc_url(home_url("/about/")); ?>">About</a></li>
              <li><a href="<?php echo esc_url(home_url("/services/")); ?>">Services</a></li>
              <li><a href="<?php echo esc_url(home_url("/science-evidence/")); ?>">Science &amp; Evidence</a></li>
              <li><a href="<?php echo esc_url(home_url("/results/")); ?>">Results</a></li>
              <li><a href="<?php echo esc_url(home_url("/contact/")); ?>">Contact Us</a></li>
            </ul>
            <?php
        }
        $global_phone = eliza_field("global_phone", "082 926 9851", "option");
        $phone_clean  = preg_replace("/[^0-9+]/", "", $global_phone);
        ?>
        <a class="header-phone" href="tel:<?php echo esc_attr($phone_clean); ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
          </svg>
          <?php echo esc_html($global_phone); ?>
        </a>
      </nav>

      <button class="nav-toggle" aria-label="<?php esc_attr_e("Toggle Navigation Menu", "eliza-reconnection"); ?>" aria-expanded="false">
        <span></span>
      </button>
    </div>
  </header>
  <div class="nav-backdrop" aria-hidden="true"></div>
