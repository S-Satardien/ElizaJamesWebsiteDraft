<?php
/**
 * Template Name: Contact & Inquiries
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
        <span class="eyebrow eyebrow-on-dusk">Get In Touch</span>
        <h1>Contact Us</h1>
        <p>&ldquo;Do call me &ndash; let's have an informal chat over a cup of tea. I am sure you have lots of questions and you will be under no obligation to then book a session.&rdquo;</p>
      </div>
    </section>

    <!-- Main Contact Section (Evenly Balanced Columns) -->
    <section>
      <div class="container">
        <div class="grid-balanced-2" style="align-items: start;">
          <!-- Column 1: Contact Info & Logistics -->
          <div class="reveal equal-col">
            <span class="eyebrow">Direct Details</span>
            <h2 class="section-title">Contact Details</h2>
            <p style="margin-bottom: 24px;">Healing sessions are strictly by appointment at my home-office in Lakeside, Cape Town, or via distant / remote sessions worldwide.</p>

            <div class="contact-card-group">
              <div class="contact-item-card">
                <div class="info">
                  <span class="label">Telephone</span>
                  <a href="tel:+27829269851">082 926 9851</a>
                </div>
                <button class="copy-btn" data-copy="0829269851" aria-label="Copy phone number">Copy</button>
              </div>

              <div class="contact-item-card">
                <div class="info">
                  <span class="label">Email</span>
                  <a href="mailto:eliza.reconnection@gmail.com">eliza.reconnection@gmail.com</a>
                </div>
                <button class="copy-btn" data-copy="eliza.reconnection@gmail.com" aria-label="Copy email address">Copy</button>
              </div>

              <div class="contact-item-card">
                <div class="info">
                  <span class="label">Physical Address</span>
                  <span style="font-weight:600; color:var(--ink);">Promenade Road, Lakeside, Cape Town, South Africa</span>
                </div>
                <button class="copy-btn" data-copy="Promenade Road, Lakeside, Cape Town" aria-label="Copy address">Copy</button>
              </div>
            </div>

            <!-- Hours Table -->
            <div style="margin-top: 10px;">
              <span class="eyebrow">Availability</span>
              <h3 style="font-size:1.25rem; margin-bottom:10px;">Session Hours (Strictly by Appointment)</h3>
              <table class="hours-table">
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Available Times</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Monday &ndash; Friday</td>
                    <td>After 6:00 PM (Evenings)</td>
                  </tr>
                  <tr>
                    <td>Saturday &ndash; Sunday</td>
                    <td>From 3:00 PM (Afternoons)</td>
                  </tr>
                  <tr>
                    <td>Distant / Remote Sessions</td>
                    <td>Scheduled by arrangement across timezones</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Tea Chat Callout -->
            <div class="tea-cta">
              <div>
                <strong style="color:var(--ink); font-size:1.05rem; display:block; margin-bottom:4px;">Informal Tea Chat</strong>
                <p>Psssssttt &ndash; really, I don't charge &ldquo;an arm and a leg&rdquo; for a 30 minute session. Let's connect over tea to answer all your questions.</p>
              </div>
              <a class="btn btn-primary" href="tel:+27829269851">Call Eliza</a>
            </div>
          </div>

          <!-- Column 2: Contact Form & Map -->
          <div class="reveal delay-1 equal-col">
            <div class="form-glass">
              <span class="eyebrow">Send A Message</span>
              <h2 class="section-title" style="font-size:1.6rem; margin-bottom:18px;">Contact Form</h2>
              
              <form class="contact-form" action="#" method="post" novalidate>
                <div class="field">
                  <label for="name">Name *</label>
                  <input type="text" id="name" name="your-name" placeholder="Your Full Name" required>
                </div>

                <div class="field">
                  <label for="tel">Tel *</label>
                  <input type="tel" id="tel" name="tel-810" placeholder="Your Contact number (e.g. 082 123 4567)" required>
                </div>

                <div class="field">
                  <label for="email">Email *</label>
                  <input type="email" id="email" name="your-email" placeholder="Your email address" required>
                </div>

                <div class="field">
                  <label for="subject">Subject *</label>
                  <input type="text" id="subject" name="your-subject" placeholder="Your Subject (e.g. Reconnective Healing / Tea Chat)" required>
                </div>

                <div class="field">
                  <label for="message">Message *</label>
                  <textarea id="message" name="your-message" placeholder="Your Message" required></textarea>
                </div>

                <div id="form-status" class="form-status" role="alert">
                  Thank you! Your message has been sent successfully. Eliza will be in touch with you shortly.
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">Send Message</button>
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
          <a class="btn btn-ghost-light" href="<?php echo esc_url(home_url('/about-us/')); ?>">About Eliza</a>
        </div>
      </div>
    </section>
  </main>
<?php
}
?>

<?php
get_footer();
