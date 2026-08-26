<?php
/**
 * Template Name: Contact & Inquiries
 * @package Eliza_Reconnection
 */
get_header();

$contact_title   = eliza_field('contact_hero_title', 'Connect with Eliza');
$contact_lede    = eliza_field('contact_hero_lede', '“I invite you to reach out, ask questions, or schedule an informal tea chat to discuss how we can work together.”');
$global_phone    = eliza_field('global_phone', '082 926 9851', 'option');
$global_email    = eliza_field('global_email', 'eliza.reconnection@gmail.com', 'option');
$global_address  = eliza_field('global_address', 'Promenade Road, Lakeside, Cape Town, South Africa', 'option');
?>
<main id="main">
  <section class="page-hero">
    <div class="glow-1" aria-hidden="true"></div>
    <div class="container text-center reveal">
      <span class="eyebrow">Get In Touch</span>
      <h1><?php echo esc_html($contact_title); ?></h1>
      <p class="lede" style="max-width:760px; margin:16px auto 0; font-family:var(--font-serif); font-size:1.24rem; font-style:italic;">
        <?php echo esc_html($contact_lede); ?>
      </p>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="grid-balanced-2" style="gap:48px;">
        <div class="prose reveal">
          <h2>Location &amp; Availability</h2>
          <div class="glass-box" style="margin-bottom:24px;">
            <p><strong>📞 Direct Telephone / WhatsApp:</strong><br><a href="tel:<?php echo esc_attr(str_replace(' ', '', $global_phone)); ?>"><?php echo esc_html($global_phone); ?></a></p>
            <p><strong>✉️ Direct Email:</strong><br><a href="mailto:<?php echo esc_attr($global_email); ?>"><?php echo esc_html($global_email); ?></a></p>
            <p><strong>📍 Practice Location:</strong><br><?php echo esc_html($global_address); ?></p>
          </div>

          <div class="glass-box">
            <h4>Appointment Hours</h4>
            <p><strong>Weekdays:</strong> After 18:00 (6:00 PM)<br>
            <strong>Weekends:</strong> From 15:00 (3:00 PM)<br>
            <em>Distant and remote sessions are available globally by scheduled arrangement.</em></p>
          </div>
        </div>

        <div class="reveal delay-1">
          <div class="contact-form-wrap glass-card" style="padding:32px; border-radius:18px; border:1px solid rgba(229,191,101,0.25);">
            <h3>Send an Inquiry</h3>
            <p style="font-size:0.92rem; color:var(--ink-soft); margin-bottom:20px;">Fill out the form below and Eliza will personally respond to you.</p>
            <form id="contactForm" method="POST" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
              <input type="hidden" name="action" value="eliza_contact_submit">
              <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('eliza_contact_nonce')); ?>">
              
              <div class="form-group" style="margin-bottom:16px;">
                <label for="name" style="display:block; font-weight:600; margin-bottom:6px;">Your Name *</label>
                <input type="text" id="name" name="name" required style="width:100%; padding:12px; border:1px solid #ccc; border-radius:8px;">
              </div>

              <div class="form-group" style="margin-bottom:16px;">
                <label for="email" style="display:block; font-weight:600; margin-bottom:6px;">Email Address *</label>
                <input type="email" id="email" name="email" required style="width:100%; padding:12px; border:1px solid #ccc; border-radius:8px;">
              </div>

              <div class="form-group" style="margin-bottom:16px;">
                <label for="phone" style="display:block; font-weight:600; margin-bottom:6px;">Phone Number (Optional)</label>
                <input type="tel" id="phone" name="phone" style="width:100%; padding:12px; border:1px solid #ccc; border-radius:8px;">
              </div>

              <div class="form-group" style="margin-bottom:16px;">
                <label for="service" style="display:block; font-weight:600; margin-bottom:6px;">Service of Interest</label>
                <select id="service" name="service" style="width:100%; padding:12px; border:1px solid #ccc; border-radius:8px;">
                  <option value="General Inquiry">General Inquiry / Informal Tea Chat</option>
                  <option value="Reconnective Healing">Reconnective Healing (In-person or Distant)</option>
                  <option value="Curator of Consciousness">Curator of Consciousness Life Coaching</option>
                  <option value="Meditation & Conscious Breathing">Meditation &amp; Conscious Breathing Workshop</option>
                  <option value="Book Inquiry">Book: A Most Extraordinary Journey</option>
                </select>
              </div>

              <div class="form-group" style="margin-bottom:20px;">
                <label for="message" style="display:block; font-weight:600; margin-bottom:6px;">Your Message *</label>
                <textarea id="message" name="message" rows="4" required style="width:100%; padding:12px; border:1px solid #ccc; border-radius:8px;"></textarea>
              </div>

              <button type="submit" class="btn btn-primary" style="width:100%;">Send Inquiry</button>
              <div id="formFeedback" style="margin-top:14px; font-weight:600; display:none;"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
