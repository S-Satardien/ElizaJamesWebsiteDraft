<?php
/**
 * Single Post Template for Eliza Reconnection Theme
 * Luxury Glassmorphic Design with Pure Typography Fidelity (Zero Breadcrumbs, Zero Comments)
 * @package Eliza_Reconnection
 */
get_header();
?>
  <main id="main">
    <?php
    while (have_posts()) : the_post();
        $categories = get_the_category();
        $cat_name = !empty($categories) ? esc_html($categories[0]->name) : 'Sacred Journal';
        $read_time = max(1, round(str_word_count(strip_tags(get_the_content())) / 200)) . ' min read';
        ?>
        <!-- Single Post Luxury Hero -->
        <article class="single-article-view">
          <header class="single-hero-dark">
            <div class="glow-1" aria-hidden="true"></div>
            <div class="glow-2" aria-hidden="true"></div>
            <!-- Sacred Geometry Ambient Background -->
            <svg class="single-hero-mandala" viewBox="0 0 400 400" aria-hidden="true">
              <circle cx="200" cy="200" r="180" fill="none" stroke="rgba(229, 191, 101, 0.08)" stroke-width="1.5" stroke-dasharray="4 6"/>
              <circle cx="200" cy="200" r="120" fill="none" stroke="rgba(229, 191, 101, 0.1)" stroke-width="1.5"/>
              <circle cx="200" cy="200" r="60" fill="none" stroke="rgba(229, 191, 101, 0.12)" stroke-width="1.5"/>
              <polygon points="200,20 355,110 355,290 200,380 45,290 45,110" fill="none" stroke="rgba(229, 191, 101, 0.08)" stroke-width="1"/>
            </svg>

            <div class="container container-narrow reveal" style="position: relative; z-index: 2;">
              <div class="single-badge-row">
                <span class="glass-chip">
                  <span class="pulse-dot"></span>
                  <span><?php echo $cat_name; ?></span>
                </span>
                <span class="single-meta-date"><?php echo get_the_date('F j, Y'); ?></span>
                <span class="single-meta-sep">·</span>
                <span class="single-meta-time"><?php echo esc_html($read_time); ?></span>
              </div>

              <h1 class="single-hero-title"><?php the_title(); ?></h1>

              <?php if (has_excerpt()) : ?>
                <p class="single-hero-lead"><?php echo get_the_excerpt(); ?></p>
              <?php endif; ?>

              <div class="single-author-pill">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/eliza-headshot.jpg" alt="Eliza James" class="single-author-pill-avatar" width="44" height="44">
                <div>
                  <span class="single-author-name">Eliza James</span>
                  <span class="single-author-role">Reconnective Healing Practitioner · Author</span>
                </div>
              </div>
            </div>
          </header>

          <!-- Article Content Body -->
          <div class="single-content-section">
            <div class="container container-narrow">
              <?php if (has_post_thumbnail()) : ?>
                <div class="single-featured-frame reveal">
                  <?php the_post_thumbnail('large', array('class' => 'single-featured-img', 'alt' => get_the_title())); ?>
                </div>
              <?php endif; ?>

              <!-- Rich Typography Prose -->
              <div class="article-prose prose dropcap reveal">
                <?php the_content(); ?>
              </div>

              <!-- Author Bio Card -->
              <div class="single-author-card glass-box reveal" style="border-left: 4px solid var(--gold); margin-top: 60px;">
                <div class="single-author-card-grid">
                  <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/eliza-headshot.jpg" alt="Eliza James" class="single-author-avatar-lg" width="90" height="90">
                  <div class="single-author-bio-content">
                    <span class="eyebrow" style="margin-bottom: 4px;">About the Author</span>
                    <h3>Eliza James</h3>
                    <p class="single-author-sub">UCT GSB Graduate · Reconnective Healing Practitioner · Student of St Germain</p>
                    <p>Practicing energy healing, consciousness curation, and conscious breathing from a dedicated home-office in Lakeside, Cape Town. Author of <em>A Most Extraordinary Journey of Self-discovery</em>.</p>
                    <div style="margin-top: 14px;">
                      <a href="<?php echo esc_url(home_url('/about/')); ?>" class="single-author-link">Learn more about Eliza &rarr;</a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Article Navigation -->
              <nav class="single-nav-bar reveal" aria-label="Post Navigation">
                <div class="single-nav-prev">
                  <?php previous_post_link('%link', '<small>← Previous Article</small><span>%title</span>'); ?>
                </div>
                <div class="single-nav-center">
                  <a href="<?php echo esc_url(home_url('/about/')); ?>#journal" class="btn btn-ghost">All Articles</a>
                </div>
                <div class="single-nav-next">
                  <?php next_post_link('%link', '<small>Next Article →</small><span>%title</span>'); ?>
                </div>
              </nav>
            </div>
          </div>

          <!-- Related Recent Articles Section -->
          <section class="section-alt" style="padding: 72px 0;">
            <div class="container">
              <div class="reveal" style="text-align: center; margin-bottom: 40px;">
                <span class="eyebrow">Continue Reading</span>
                <h2 class="section-title">More Reflections &amp; Teachings</h2>
              </div>

              <div class="blog-grid-3">
                <?php
                $related_query = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'post__not_in'   => array(get_the_ID()),
                    'post_status'    => 'publish',
                ));

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                        $rcats = get_the_category();
                        $rcat_name = !empty($rcats) ? esc_html($rcats[0]->name) : 'Sacred Journal';
                        $rread_time = max(1, round(str_word_count(strip_tags(get_the_content())) / 200)) . ' min read';
                        ?>
                        <article class="blog-card reveal">
                          <a href="<?php the_permalink(); ?>" class="blog-card-img-link" tabindex="-1" aria-hidden="true">
                            <div class="blog-card-placeholder-img">
                              <svg viewBox="0 0 100 100" class="blog-mandala-icon" aria-hidden="true">
                                <circle cx="50" cy="50" r="42" fill="none" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 3"/>
                                <circle cx="50" cy="50" r="28" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="50" cy="50" r="14" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M50 8 L50 92 M8 50 L92 50 M20 20 L80 80 M20 80 L80 20" stroke="currentColor" stroke-width="1.2"/>
                              </svg>
                              <span class="blog-placeholder-tag"><?php echo $rcat_name; ?></span>
                            </div>
                          </a>
                          <div class="blog-card-body">
                            <div class="blog-card-meta">
                              <span class="blog-cat-badge"><?php echo $rcat_name; ?></span>
                              <span class="blog-dot">·</span>
                              <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
                            </div>
                            <h3 class="blog-card-title">
                              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="blog-card-excerpt">
                              <?php echo esc_html(wp_trim_words(get_the_excerpt(), 16, '...')); ?>
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
                    wp_reset_postdata();
                endif;
                ?>
              </div>
            </div>
          </section>

          <!-- Bottom CTA Band -->
          <section class="cta-band">
            <div class="glow" aria-hidden="true"></div>
            <div class="container container-narrow reveal">
              <h2>Do call me – let's have an informal chat over a cup of tea</h2>
              <p>I am sure you have lots of questions and you will be under no obligation to then book a session. Psssssttt – really, I don't charge "an arm and a leg" for a 30 minute session.<br><br>
              <strong>You are alive to give voice, action and physicality to GOD. To become the grandest version of the greatest vision you hold about Who You Are.</strong></p>
              <div class="btn-row" style="justify-content:center; margin-top:28px;">
                <a class="btn btn-primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Get in touch</a>
                <a class="btn btn-ghost-light" href="<?php echo esc_url(home_url('/services/')); ?>">View Services</a>
              </div>
            </div>
          </section>
        </article>
        <?php
    endwhile;
    ?>
  </main>
<?php
get_footer();
