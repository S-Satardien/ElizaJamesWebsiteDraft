<?php
/**
 * Template Name: Science & Evidence
 * @package Eliza_Reconnection
 */
get_header();

$sci_title = eliza_field('science_hero_title', 'Science & Scientific Research');
$sci_lede  = eliza_field('science_hero_lede', '“The reality of its existence has been demonstrated clearly in practice, as well as in scientific research laboratories.”');
?>
<main id="main">
  <section class="page-hero">
    <div class="glow-1" aria-hidden="true"></div>
    <div class="container text-center reveal">
      <span class="eyebrow">Scientific Foundation</span>
      <h1><?php echo esc_html($sci_title); ?></h1>
      <p class="lede" style="max-width:760px; margin:16px auto 0; font-family:var(--font-serif); font-size:1.24rem; font-style:italic;">
        <?php echo esc_html($sci_lede); ?>
      </p>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="grid-balanced-2" style="gap:36px; align-items:start;">
        <div class="prose reveal">
          <h2>Stanford University Research</h2>
          <p>Stanford Professor Emeritus Dr. William Tiller states that when information carried through these frequencies is introduced, it creates coherence and order within the field and the body itself.</p>
          <div class="offer-highlight-box" style="margin-top:20px;">
            <span class="box-label">Dr. William Tiller (Stanford University)</span>
            <p style="font-style:italic; font-family:var(--font-serif); font-size:1.08rem; margin:0;">“The result: dramatic reports of regeneration instead of degeneration.”</p>
          </div>
        </div>

        <div class="prose reveal delay-1">
          <h2>Laboratory Findings</h2>
          <p>Extensive studies conducted across international laboratories and published research illustrate that Reconnective Healing frequencies interact with human biofields and cellular structures to encourage biological homeostasis and energetic coherence.</p>
          <div class="glass-box" style="margin-top:20px;">
            <h4>Explore the Modality</h4>
            <p style="font-size:0.92rem; margin-bottom:12px;">Experience the restorative impact of these frequencies firsthand.</p>
            <a class="btn btn-primary" href="<?php echo esc_url(home_url('/services/')); ?>">View Services</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
