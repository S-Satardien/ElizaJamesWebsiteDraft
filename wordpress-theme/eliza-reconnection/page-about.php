<?php
/**
 * Template Name: About & Sacred Journey
 * @package Eliza_Reconnection
 */
get_header();

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
        <span class="eyebrow eyebrow-on-dusk">About Eliza</span>
        <h1>About</h1>
        <p>&ldquo;You are alive to give voice, action and physicality to GOD. To become the grandest version of the greatest vision you hold about Who You Are.&rdquo;</p>
      </div>
    </section>

    <!-- Main Narrative Section (Evenly Balanced Columns) -->
    <section>
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Practitioner Journey</span>
          <h2 class="section-title">A Magical Journey of Discovery</h2>
        </div>

        <div class="grid-balanced-2">
          <!-- Column 1: Portrait, Initiation & Christ Consciousness Update -->
          <div class="prose dropcap reveal equal-col">
            <div class="home-hero-portrait-wrap" style="margin-bottom: 24px;">
              <div class="home-hero-portrait" style="max-width: 340px;">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/eliza-headshot.jpg" alt="Eliza James, Reconnective Healing practitioner" width="565" height="700">
              </div>
            </div>

            <p>I was en-trained and have been practicing since 2011, so I am an experienced Reconnective Healing Practitioner for Level I/II (Reconnective Healing) and Level III (The Reconnection).</p>

            <div class="glass-box" style="border-left: 4px solid var(--sage); margin: 20px 0;">
              <h4 style="color:var(--sage); margin-bottom:6px;">A QUICK, ALL IMPORTANT UPDATE (June 2014)</h4>
              <p style="margin:0; font-size:0.95rem; font-style:italic;">I am grateful for the introduction into the field of energy healing introduced by RH, but I am even more humbled to have progressed on to working with the Christ Consciousness. The Light, Love and Wisdom felt during a session communicates &amp; merges with Your Light within and you know, instinctively, that you have experienced Grace.</p>
            </div>

            <p>To continue 🙂 &hellip; I’ve always had this sense that &ldquo;there must be more to life&rdquo;, than what many seem to accept as the norm. So I’ve made it my business to attend seminars and immerse myself in books that explores the mysteries of this world, whether it be self help books, books on spiritual matters, books that address metaphysical concepts &ndash; anything really that would bring me closer to understanding more of the SELF. This, in itself, has made Life quite fascinating &ndash; a magical journey of discovery that I would encourage everyone to embark on.</p>
          </div>

          <!-- Column 2: Roots, Communion, Practice Logistics & Hours -->
          <div class="prose reveal delay-1 equal-col">
            <p>Always searching for the root cause of an emotional or physical problem, I considered many options, until I was introduced to Dr. Eric Pearl (2011). I did not hesitate to attend the seminars in Sydney, Australia. On my return to South Africa, I immediately started offering The Reconnection and Reconnective Healing sessions.</p>

            <p>Despite doing sessions on an almost daily basis, every interaction with my client continues to leave me in absolute awe of our ability to commune with GOD / The Universe / Source Energy / The Creator (or whatever label you are most comfortable using). And every session confirms that we are all Divine, that the spark of GOD resides within us &ndash; all we need do is allow it to come forth. Albeit sometimes skeptical, clients that have come for sessions, find themselves booking a second or third session.</p>

            <p>For more details on in-person and remote sessions, call <strong>082 926 9851</strong> or email <a href="mailto:eliza.reconnection@gmail.com">eliza.reconnection@gmail.com</a>. Practicing from a dedicated home office in Lakeside, Cape Town.</p>

            <div class="glass-box" style="margin-top: 24px;">
              <h4 style="color:var(--gold); margin-bottom: 8px;">Practice Logistics &amp; Hours</h4>
              <p style="margin: 0; font-size: 0.92rem; line-height: 1.6;">Appointments available on weekdays from 6pm and weekends from 3pm. Distant / remote healing sessions available globally by prior arrangement.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION: Blog Posts / Sacred Journal Grid (Auto-populated from WordPress Posts) -->
    <section class="section-alt" id="journal">
      <div class="container">
        <div class="section-header-row reveal" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 36px; flex-wrap: wrap; gap: 16px;">
          <div>
            <span class="eyebrow">Reflections &amp; Sacred Journal</span>
            <h2 class="section-title">Articles, Wisdom &amp; Insights</h2>
            <p class="section-intro" style="margin: 0;">Explore teachings on energy frequencies, spiritual discernment, and conscious living.</p>
          </div>
          <div>
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/journal/')); ?>" class="btn btn-ghost">View All Articles &rarr;</a>
          </div>
        </div>

        <div class="blog-grid-3">
          <?php
          $blog_query = new WP_Query(array(
              'post_type'           => 'post',
              'posts_per_page'      => 6,
              'post_status'         => 'publish',
              'ignore_sticky_posts' => true,
          ));

          if ($blog_query->have_posts()) :
              $delay_idx = 0;
              while ($blog_query->have_posts()) : $blog_query->the_post();
                  $delay_idx++;
                  $delay_class = ($delay_idx > 1) ? 'delay-' . min($delay_idx - 1, 3) : '';
                  $categories = get_the_category();
                  $cat_name = !empty($categories) ? esc_html($categories[0]->name) : 'Spiritual Wisdom';
                  $read_time = max(1, round(str_word_count(strip_tags(get_the_content())) / 200)) . ' min read';
                  ?>
                  <article class="blog-card reveal <?php echo esc_attr($delay_class); ?>">
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
              wp_reset_postdata();
          else :
              ?>
              <p class="text-muted">New articles coming soon. Stay tuned for reflections and teachings.</p>
          <?php endif; ?>
        </div>

        <div class="text-center reveal" style="margin-top: 44px;">
          <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/journal/')); ?>" class="btn btn-primary">View All Articles &amp; Insights &rarr;</a>
        </div>
      </div>
    </section>

    <!-- Bottom CTA Band -->
    <section class="cta-band">
      <div class="container container-narrow reveal">
        <span class="eyebrow eyebrow-on-dusk">Begin Your Journey</span>
        <h2>Do call me – let's have an informal chat over a cup of tea</h2>
        <p>I am sure you have lots of questions and you will be under no obligation to then book a session. Psssssttt – really, I don't charge "an arm and a leg" for a 30 minute session.</p>
        <div class="btn-row" style="justify-content:center; margin-top:28px;">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary">Get in Touch</a>
          <a href="tel:+27829269851" class="btn btn-ghost-light">Call 082 926 9851</a>
        </div>
      </div>
    </section>
  </main>
<?php
}
get_footer();
