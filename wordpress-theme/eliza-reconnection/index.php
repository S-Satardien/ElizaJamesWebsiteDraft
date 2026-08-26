<?php
/**
 * Default Page Template
 */
get_header();
?>
<main id="main">
  <section class="page-hero">
    <div class="glow" aria-hidden="true"></div>
    <div class="container reveal">
      <h1><?php the_title(); ?></h1>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="prose reveal">
        <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
