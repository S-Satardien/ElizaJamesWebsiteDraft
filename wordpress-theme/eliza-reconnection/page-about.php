<?php
/**
 * Template Name: About Us & Sacred Journey
 * @package Eliza_Reconnection
 */
get_header();

$about_title       = eliza_field('about_hero_title', 'About Eliza & Her Sacred Journey');
$about_lede        = eliza_field('about_hero_lede', '“I consider myself an ordinary individual grounded in the realities of daily life — on a quest to uncover the deep truth of who I really am.”');
$about_portrait    = eliza_field('about_portrait', get_template_directory_uri() . '/assets/eliza-headshot.jpg');
$about_group_image = eliza_field('about_group_image', get_template_directory_uri() . '/assets/eliza-group-session.jpg');
$about_p1          = eliza_field('about_p1', 'Born with a natural curiosity regarding the deeper mechanics of life, Eliza spent decades exploring spiritual doctrines, consciousness philosophy, and metaphysical truths. Her background spans formal management studies at the UCT Graduate School of Business alongside extensive practice in energy modalities and consciousness coaching.');
$about_p2          = eliza_field('about_p2', 'In 2011, during an intensive Level III Reconnective Healing seminar in Sydney, Australia, an extraordinary spiritual encounter set the stage for a nine-year communion with the Ascended Master, the Comte de St Germain. This transformative journey culminated in her internationally published book, “A Most Extraordinary Journey of Self-Discovery.”');
?>
<main id="main">
  <section class="page-hero">
    <div class="glow-1" aria-hidden="true"></div>
    <div class="container text-center reveal">
      <span class="eyebrow">Sacred Journey</span>
      <h1><?php echo esc_html($about_title); ?></h1>
      <p class="lede" style="max-width:760px; margin:16px auto 0; font-family:var(--font-serif); font-size:1.24rem; font-style:italic;">
        <?php echo esc_html($about_lede); ?>
      </p>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="grid-balanced-2" style="align-items:start;">
        <div class="prose reveal">
          <div class="home-hero-portrait-wrap" style="margin-bottom:28px;">
            <div class="home-hero-portrait" style="max-width:340px;">
              <img src="<?php echo esc_url($about_portrait); ?>" alt="<?php esc_attr_e('Eliza James', 'eliza-reconnection'); ?>" width="565" height="700">
            </div>
          </div>
          <p><?php echo esc_html($about_p1); ?></p>
          <p><?php echo esc_html($about_p2); ?></p>
        </div>

        <div class="prose reveal delay-1">
          <div class="bio-photo-card" style="margin-bottom:24px;">
            <div class="bio-photo-frame">
              <img src="<?php echo esc_url($about_group_image); ?>" alt="<?php esc_attr_e('Group Consciousness Session', 'eliza-reconnection'); ?>" width="1000" height="667">
              <div class="bio-photo-caption">
                <span class="bio-photo-badge">✦ Group Work &amp; Workshops</span>
                <p>Creating sacred spaces for shared insight, frequency calibration, and conscious awareness.</p>
              </div>
            </div>
          </div>

          <div class="glass-box">
            <h4>Lakeside Practice &amp; Remote Sessions</h4>
            <p style="font-size:0.95rem; margin-bottom:14px;">Sessions are offered in-person from Eliza's dedicated home sanctuary in Lakeside, Cape Town, as well as remotely for clients across the globe.</p>
            <a class="btn btn-primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Contact Eliza</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
