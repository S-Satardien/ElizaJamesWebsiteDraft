<?php
/**
 * Blog Archive / All Articles Template for Eliza Reconnection Theme
 * @package Eliza_Reconnection
 */
get_header();
?>
  <main id="main">
    <!-- Archive Hero -->
    <section class="page-hero">
      <div class="glow" aria-hidden="true"></div>
      <div class="container reveal">
        <span class="eyebrow eyebrow-on-dusk">Sacred Journal &amp; Teachings</span>
        <h1>All Articles &amp; Insights</h1>
        <p>Explore teachings on 5D consciousness, frequency healing, conscious breathing, and spiritual self-mastery.</p>
      </div>
    </section>

    <!-- Articles Grid Section -->
    <section class="section-alt">
      <div class="container">
        <?php if (have_posts()) : ?>
          <div class="blog-grid-3">
            <?php
            while (have_posts()) : the_post();
                $categories = get_the_category();
                $cat_name = !empty($categories) ? esc_html($categories[0]->name) : 'Spiritual Journey';
                $read_time = max(1, round(str_word_count(strip_tags(get_the_content())) / 200)) . ' min read';
                ?>
                <article class="blog-card reveal">
                  <a href="<?php the_permalink(); ?>" class="blog-card-img-link" tabindex="-1" aria-hidden="true">
                    <?php if (has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('medium_large', array('class' => 'blog-card-img', 'alt' => get_the_title())); ?>
                    <?php else : ?>
                      <div class="blog-card-placeholder-img">
                        <svg viewBox="0 0 100 100" class="blog-mandala-icon" aria-hidden="true">
                          <circle cx="50" cy="50" r="42" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 3"/>
                          <circle cx="50" cy="50" r="28" fill="none" stroke="currentColor" stroke-width="1.5"/>
                          <circle cx="50" cy="50" r="14" fill="none" stroke="currentColor" stroke-width="1.5"/>
                          <path d="M50 8 L50 92 M8 50 L92 50 M20 20 L80 80 M20 80 L80 20" stroke="currentColor" stroke-width="1.2"/>
                        </svg>
                        <span class="blog-placeholder-tag"><?php echo $cat_name; ?></span>
                      </div>
                    <?php endif; ?>
                  </a>
                  <div class="blog-card-body">
                    <div class="blog-card-meta">
                      <span class="blog-cat-badge"><?php echo $cat_name; ?></span>
                      <span class="blog-dot">·</span>
                      <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
                      <span class="blog-dot">·</span>
                      <span class="blog-read-time"><?php echo esc_html($read_time); ?></span>
                    </div>
                    <h3 class="blog-card-title">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="blog-card-excerpt">
                      <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="blog-card-link">
                      <span>Read Article</span>
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                      </svg>
                    </a>
                  </div>
                </article>
                <?php
            endwhile;
            ?>
          </div>

          <!-- Pagination -->
          <div class="pagination-wrapper reveal" style="margin-top: 48px; text-align: center;">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('&larr; Previous', 'eliza-reconnection'),
                'next_text' => __('Next &rarr;', 'eliza-reconnection'),
            ));
            ?>
          </div>
        <?php else : ?>
          <p>No articles found.</p>
        <?php endif; ?>
      </div>
    </section>
  </main>
<?php
get_footer();
