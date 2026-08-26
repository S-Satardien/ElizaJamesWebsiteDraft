<?php
/**
 * Single Post Template for Eliza Reconnection Theme
 * Displays individual blog articles with high typography fidelity and NO comments.
 * @package Eliza_Reconnection
 */
get_header();
?>
  <main id="main">
    <?php
    while (have_posts()) : the_post();
        $categories = get_the_category();
        $cat_name = !empty($categories) ? esc_html($categories[0]->name) : 'Spiritual Wisdom';
        $read_time = max(1, round(str_word_count(strip_tags(get_the_content())) / 200)) . ' min read';
        ?>
        <!-- Single Post Hero -->
        <article class="single-post-wrapper">
          <header class="single-post-header">
            <div class="glow-1" aria-hidden="true"></div>
            <div class="container container-narrow reveal">
              <nav class="single-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="sep">/</span>
                <a href="<?php echo esc_url(home_url('/about/')); ?>">About</a>
                <span class="sep">/</span>
                <a href="<?php echo esc_url(home_url('/journal/')); ?>">Articles</a>
                <span class="sep">/</span>
                <span class="current"><?php echo esc_html(wp_trim_words(get_the_title(), 5)); ?></span>
              </nav>

              <div class="single-meta-row">
                <span class="blog-cat-badge"><?php echo $cat_name; ?></span>
                <span class="blog-dot">·</span>
                <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                <span class="blog-dot">·</span>
                <span class="blog-read-time"><?php echo esc_html($read_time); ?></span>
              </div>

              <h1 class="single-post-title"><?php the_title(); ?></h1>

              <?php if (has_excerpt()) : ?>
                <p class="single-post-lede"><?php echo get_the_excerpt(); ?></p>
              <?php endif; ?>
            </div>
          </header>

          <!-- Post Content -->
          <div class="single-post-body">
            <div class="container container-narrow">
              <?php if (has_post_thumbnail()) : ?>
                <div class="single-featured-image reveal">
                  <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                </div>
              <?php endif; ?>

              <div class="single-prose prose dropcap reveal">
                <?php the_content(); ?>
              </div>

              <!-- Author Bio Box -->
              <div class="author-bio-box glass-box reveal" style="margin-top: 56px; border-left: 4px solid var(--gold);">
                <div class="author-bio-flex">
                  <div class="author-bio-avatar">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/eliza-headshot.jpg" alt="Eliza James" width="80" height="80">
                  </div>
                  <div class="author-bio-info">
                    <h4>Written by Eliza James</h4>
                    <p class="author-bio-tagline">Graduate of UCT GSB · Reconnective Healing Practitioner · Author &amp; Student of St Germain</p>
                    <p class="author-bio-text">Sharing insights from over a decade of energy healing practice, consciousness curation, and spiritual exploration from Lakeside, Cape Town.</p>
                  </div>
                </div>
              </div>

              <!-- Post Navigation -->
              <nav class="single-post-pagination reveal" style="margin-top: 40px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--sand-200); padding-top: 24px;">
                <div>
                  <?php previous_post_link('%link', '← Previous: %title'); ?>
                </div>
                <div>
                  <a href="<?php echo esc_url(home_url('/about/')); ?>#journal" class="btn btn-ghost">Back to Articles</a>
                </div>
                <div>
                  <?php next_post_link('%link', 'Next: %title →'); ?>
                </div>
              </nav>
            </div>
          </div>
        </article>
        <?php
    endwhile;
    ?>
  </main>
<?php
get_footer();
