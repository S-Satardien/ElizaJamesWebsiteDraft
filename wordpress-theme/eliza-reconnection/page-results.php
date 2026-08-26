<?php
/**
 * Template Name: Results & Testimonials
 * @package Eliza_Reconnection
 */
get_header();

$res_title = eliza_field('results_hero_title', 'Documented Client Results');
$res_lede  = eliza_field('results_hero_lede', '“Authentic testimonials and documented healing experiences from clients across in-person and distant sessions.”');
?>
<main id="main">
  <section class="page-hero">
    <div class="glow-1" aria-hidden="true"></div>
    <div class="container text-center reveal">
      <span class="eyebrow">Client Experiences</span>
      <h1><?php echo esc_html($res_title); ?></h1>
      <p class="lede" style="max-width:760px; margin:16px auto 0; font-family:var(--font-serif); font-size:1.24rem; font-style:italic;">
        <?php echo esc_html($res_lede); ?>
      </p>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="grid-balanced-2" style="gap:36px;">
        <div class="glass-card reveal" style="padding:28px; border-radius:16px; border:1px solid rgba(229,191,101,0.2);">
          <span class="tag" style="margin-bottom:12px; display:inline-block;">Remote Healing · Medical Case</span>
          <h3 style="margin-bottom:10px;">Groote Schuur Hospital Specialized Case</h3>
          <p style="font-style:italic; font-family:var(--font-serif); font-size:1.08rem; color:var(--ink);">“One of my most remarkable remote healing sessions had a team of Specialists at the world-renowned Groote Schuur Hospital stumped when their patient, after remotely administered RH sessions, no longer presented symptoms of an illness for which he was scheduled to go into a 6-month period of strict quarantine.”</p>
          <p style="font-size:0.88rem; color:var(--copper-text); font-weight:700;">— Documented Clinical Case Study</p>
        </div>

        <div class="glass-card reveal delay-1" style="padding:28px; border-radius:16px; border:1px solid rgba(229,191,101,0.2);">
          <span class="tag" style="margin-bottom:12px; display:inline-block;">Emotional &amp; Energy Alignment</span>
          <h3 style="margin-bottom:10px;">Profound Inner Peace and Clarity</h3>
          <p style="font-style:italic; font-family:var(--font-serif); font-size:1.08rem; color:var(--ink);">“The lightness and clarity that came over me during and after our session was unlike anything I had experienced before. A deep physical tension that had persisted for years simply dissolved.”</p>
          <p style="font-size:0.88rem; color:var(--copper-text); font-weight:700;">— Client Healing Testimony</p>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
