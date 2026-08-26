<?php
/**
 * Template Name: Services & Modalities
 * @package Eliza_Reconnection
 */
get_header();

$serv_title = eliza_field('services_hero_title', 'Services & Coaching');
$serv_lede  = eliza_field('services_hero_lede', '“Allow me to guide you toward experiencing this Life Journey in a meaningful way, to gently hold the space as you step onto your unique path toward the unfolding of your Becoming.”');
?>
<main id="main">
  <section class="page-hero">
    <div class="glow-1" aria-hidden="true"></div>
    <div class="container text-center reveal">
      <span class="eyebrow">Offerings &amp; Modalities</span>
      <h1><?php echo esc_html($serv_title); ?></h1>
      <p class="lede" style="max-width:760px; margin:16px auto 0; font-family:var(--font-serif); font-size:1.24rem; font-style:italic;">
        <?php echo esc_html($serv_lede); ?>
      </p>
    </div>
  </section>

  <section class="section-alt">
    <div class="container-wide">
      <div class="offer-grid">
        <!-- Reconnective Healing -->
        <div class="offer-card reveal delay-1" id="reconnective-healing">
          <div class="offer-card-header">
            <span class="tag">Frequency Restoration</span>
            <h3>Reconnective Healing</h3>
            <span class="card-subtitle">(Restoring Balance and Harmony to Body, Mind and Spirit)</span>
          </div>
          <p class="card-desc">Reconnective Healing is often described as a form of energy that conveys corrective information to the body and mind.</p>
          <div class="offer-highlight-box">
            <span class="box-label">Stanford Research &amp; Clinical Impact</span>
            <p style="margin:0;">Stanford Professor Emeritus Dr. William Tiller states that when information carried through these frequencies is introduced, it creates coherence and order within the field and the body itself. The result: dramatic reports of regeneration instead of degeneration.</p>
          </div>
          <a class="card-cta-btn" href="<?php echo esc_url(home_url('/contact/?service=rh')); ?>">Book a Reconnective Session &rarr;</a>
        </div>

        <!-- Curator of Consciousness -->
        <div class="offer-card reveal delay-2" id="curator-of-consciousness">
          <div class="offer-card-header">
            <span class="tag">Life Coaching</span>
            <h3>Curator of Consciousness</h3>
            <span class="card-subtitle">(Aligning your Outer Reality with your Inner World)</span>
          </div>
          <p class="card-desc">A curator doesn't create - hence I select, arrange, and present so others can understand and experience in a meaningful way.</p>
          <div class="offer-highlight-box">
            <span class="box-label">Applied to Consciousness</span>
            <ul>
              <li>Reflect on wisdom from diverse traditions, experiences, and perspectives.</li>
              <li>Hold space for contemplation and genuine dialogue.</li>
              <li>Discover insights and uncover the wisdom that exists within.</li>
            </ul>
          </div>
          <a class="card-cta-btn" href="<?php echo esc_url(home_url('/contact/?service=coaching')); ?>">Schedule Coaching &rarr;</a>
        </div>

        <!-- Meditation & Conscious Breathing -->
        <div class="offer-card reveal delay-3" id="meditation-breathing">
          <div class="offer-card-header">
            <span class="tag">Sacred Practice</span>
            <h3>Meditation and Conscious Breathing</h3>
            <span class="card-subtitle">(Connecting with a Higher Aspect of the Self)</span>
          </div>
          <p class="card-desc">Meditation is that sacred moment where the Consciousness comes to rest in the heartspace and connects to a Higher Aspect of the Self.</p>
          <div class="offer-highlight-box">
            <span class="box-label">The Breath as Elixir</span>
            <p style="margin:0;">15min of deep, conscious breathing - practiced regularly, brings a transformation within that cascades into our outer experiences and enriches our Life Journey.</p>
          </div>
          <a class="card-cta-btn" href="<?php echo esc_url(home_url('/contact/?service=meditation')); ?>">Join a Workshop &rarr;</a>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
