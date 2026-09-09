<?php
/**
 * Template Name: Contact Page
 * @package Eliza_Reconnection
 */
get_header();
?>
<?php
$page_id = get_the_ID();
if (is_front_page() || is_home()) {
    $page_id = get_option('page_on_front') ?: $page_id;
}
$saved_content = get_post_field('post_content', $page_id);

if (!empty(trim($saved_content))) {
    echo '<main id="main">' . $saved_content . '</main>';
} else {
?>
  <main id="main">
    <!-- Page Hero -->
    <section class="page-hero">
      <div class="glow" aria-hidden="true"></div>
      <div class="container reveal">
        <span class="eyebrow eyebrow-on-dusk">Get in Touch</span>
        <h1>Contact Us</h1>
        <p>&ldquo;Do call me &ndash; let's have an informal chat over a cup of tea. I am sure you have lots of questions and you will be under no obligation to then book a session.&rdquo;</p>
      </div>
    </section>

    <!-- Main Contact Section -->
    <section>
      <div class="container">
        <div class="grid-balanced-2">
          <!-- Column 1: Contact Details & Logistics -->
          <div class="prose reveal equal-col">
            <div class="reveal" style="margin-bottom: 24px;">
              <span class="eyebrow">Direct Inquiries</span>
              <h2 class="section-title">Reach Out to Eliza</h2>
            </div>

            <p class="lede" style="color:var(--copper-text); font-weight:600; font-size:1.1rem; margin-bottom:14px;">I look forward to connecting with you on your journey of healing and self-discovery.</p>

            <p>Whether you have questions regarding Reconnective Healing, The Reconnection, Consciousness Coaching, or upcoming Meditation Workshops, please feel free to call, email, or fill out the form.</p>

            <div class="glass-box" style="margin: 24px 0;">
              <h4>Contact Information</h4>
              <ul>
                <li><strong>Mobile / WhatsApp:</strong> <a href="tel:+27829269851" style="color:var(--gold); font-weight:600;">082 926 9851</a></li>
                <li><strong>Email:</strong> <a href="mailto:eliza@elizareconnection.co.za" style="color:var(--gold); font-weight:600;">eliza@elizareconnection.co.za</a></li>
                <li><strong>Location:</strong> Lakeside, Cape Town, South Africa</li>
                <li><strong>Sessions:</strong> In-person (Lakeside Home-Office) or Remote Worldwide</li>
              </ul>
            </div>

            <div class="glass-box" style="border-left: 4px solid var(--gold); margin-top: auto;">
              <h4 style="color:var(--gold); margin-bottom:8px;">Availability &amp; Appointments</h4>
              <p style="margin:0; font-size:0.95rem;">Sessions are strictly by appointment.<br>
              <strong>Weekdays:</strong> After 6:00 PM<br>
              <strong>Saturdays &amp; Sundays:</strong> From 3:00 PM onwards</p>
            </div>
          </div>

          <!-- Column 2: Contact Form & Map -->
          <div class="prose reveal delay-1 equal-col">
            <div class="glass-box" style="margin-top: 0;">
              <h3 style="margin-bottom: 18px;">Send a Message</h3>
              <form id="contact-form" class="contact-form" method="post" action="#">
                <?php wp_nonce_field('eliza_contact_nonce', 'contact_nonce'); ?>
                
                <!-- Honeypot Anti-Spam (Invisible to real users) -->
                <div style="display:none !important;" aria-hidden="true">
                  <label for="hp_website">Leave this field blank</label>
                  <input type="text" id="hp_website" name="hp_website" tabindex="-1" autocomplete="off">
                  <input type="hidden" name="form_timestamp" value="<?php echo time(); ?>">
                </div>

                <div class="field">
                  <label for="name">Name *</label>
                  <input type="text" id="name" name="name" placeholder="Your Full Name" required>
                </div>

                <div class="field">
                  <label for="email">Email *</label>
                  <input type="email" id="email" name="email" placeholder="Your email address" required>
                </div>

                <div class="field">
                  <label for="phone">Phone / WhatsApp</label>
                  <input type="tel" id="phone" name="phone" placeholder="e.g. 082 123 4567">
                </div>

                <div class="field">
                  <label for="service">Interested In</label>
                  <select id="service" name="service" style="width:100%; padding:10px 14px; background:rgba(23,15,10,0.6); border:1px solid rgba(229,191,101,0.3); border-radius:var(--radius-sm); color:var(--parchment); font-family:inherit;">
                    <option value="Reconnective Healing">Reconnective Healing / The Reconnection</option>
                    <option value="Curator of Consciousness">Curator of Consciousness Coaching</option>
                    <option value="Raising Frequency">Consciously Raising Vibrations</option>
                    <option value="Meditation Workshops">Meditation &amp; Breathing Workshops</option>
                    <option value="Informal Tea Chat">Informal Tea Chat</option>
                    <option value="Other Inquiries">Other Inquiries</option>
                  </select>
                </div>

                <div class="field">
                  <label for="message">Message *</label>
                  <textarea id="message" name="message" rows="4" placeholder="How can Eliza assist you?" required></textarea>
                </div>

                <div id="form-status" class="form-status" role="alert" style="display:none; padding:12px; border-radius:var(--radius-sm); margin-bottom:14px; font-weight:600;"></div>

                <button type="submit" id="submit-btn" class="btn btn-primary" style="width:100%;">Send Inquiry</button>
              </form>
            </div>

            <!-- Google Map -->
            <div class="glass-box" style="margin-top: 24px;">
              <h4>Location &middot; Lakeside, Cape Town</h4>
              <div style="border-radius: var(--radius-sm); overflow: hidden; height: 180px; margin-top: 10px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13222.97330761273!2d18.4556488!3d-34.0838891!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1dcc43c4eb1a3c79%3A0xc39f997a66970711!2sLakeside%2C%20Cape%20Town!5e0!3m2!1sen!2sza!4v1700000000000!5m2!1sen!2sza" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map of Lakeside, Cape Town"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Tea Chat & Quote CTA -->
    <section class="cta-band">
      <div class="glow" aria-hidden="true"></div>
      <div class="container-narrow reveal">
        <h2>You are alive to give voice, action and physicality to GOD</h2>
        <p>To become the grandest version of the greatest vision you hold about Who You Are.</p>
        <div class="btn-row">
          <a class="btn btn-primary" href="tel:+27829269851">Call 082 926 9851</a>
          <a class="btn btn-ghost-light" href="<?php echo esc_url(home_url('/about/')); ?>">About Eliza</a>
        </div>
      </div>
    </section>
  </main>
<?php
}
?>

<?php
get_footer();
