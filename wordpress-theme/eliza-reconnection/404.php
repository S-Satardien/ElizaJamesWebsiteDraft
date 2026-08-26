<?php
/**
 * 404 Error Template
 */
get_header();
?>
<main id="main">
  <section class="page-hero" style="text-align: center; padding: 100px 0;">
    <div class="glow" aria-hidden="true"></div>
    <div class="container reveal">
      <span class="eyebrow eyebrow-on-dusk">404 Error</span>
      <h1 style="font-size: 3.5rem;">Page Not Found</h1>
      <p style="max-width: 500px; margin: 0 auto 30px;">The sacred path you were looking for could not be found.</p>
      <a class="btn btn-primary" href="<?php echo esc_url(home_url("/")); ?>">Return to Home</a>
    </div>
  </section>
</main>
<?php get_footer(); ?>
