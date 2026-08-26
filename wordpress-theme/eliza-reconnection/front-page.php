<?php
/**
 * Template for Homepage
 * @package Eliza_Reconnection
 */
get_header();

// Hero Fields
$hero_badge       = eliza_field('hero_badge', 'Sacred Alignment · Lakeside, Cape Town');
$hero_title       = eliza_field('hero_title', 'Sacred Alignment');
$hero_subtitle    = eliza_field('hero_subtitle', 'Where Inner Stillness Meets Sacred Power');
$hero_lede        = eliza_field('hero_lede', '“We are each Miraculous Works of Art in this amazing tapestry called Life. Allow me to guide you toward experiencing this Life Journey in a meaningful way, to gently hold the space as you step onto your unique path toward the unfolding of your Becoming.”');
$hero_btn1_text   = eliza_field('hero_btn1_text', 'Book a session');
$hero_btn1_url    = eliza_field('hero_btn1_url', home_url('/contact/'));
$hero_btn2_text   = eliza_field('hero_btn2_text', 'Explore Book & Trailer');
$hero_btn2_url    = eliza_field('hero_btn2_url', '#book');
$hero_image       = eliza_field('hero_image', get_template_directory_uri() . '/assets/eliza-headshot.jpg');
$hero_float_badge = eliza_field('hero_float_badge', 'Since 2011 · Lakeside, Cape Town');

// Biography Fields
$bio_eyebrow      = eliza_field('bio_eyebrow', 'About Eliza');
$bio_title        = eliza_field('bio_title', 'Biography');
$bio_portrait     = eliza_field('bio_portrait', get_template_directory_uri() . '/assets/eliza-headshot.jpg');
$bio_p1           = eliza_field('bio_p1', "I am a graduate of the University of Cape Town Graduate School of Business; an experienced Reconnective Healing Practitioner (having added the skill of presenting Meditation and Conscious Breathing Workshops into the mix). Conversational or presenting the more structured Life Coaching Workshops is second nature and I resonate strongly with the work of Drs Hurtak (Academy for Future Science). However, being a student and friend of St Germain is what brings me the most joy. My 9-year Spiritual Journey with the enigmatic Comte de St Germain was recently shared with the world in my internationally published work (A Most Extraordinary Journey of Self-discovery).");
$bio_p2           = eliza_field('bio_p2', "I consider myself an ordinary individual, grounded in the realities of daily life. I am a mother, a colleague, a friend and a sibling - someone who laughs with abandon, sheds tears unashamedly, feels the full spectrum of emotions, and loves fiercely. I am not immune to the world's hardships and the harsh realities of corruption, inequality, and inhumanity. And yes, I often voice my frustration with a heartfelt, “What the f#ck!”");
$bio_p3           = eliza_field('bio_p3', "I've always had this sense that “there must be more to life” than what the status quo offers - that there is a greater truth beyond what most people settle for. My hunger for understanding has led me to seminars, books, and teachings that dive into the mysteries of the world. These steps are not just intellectual - each step is a quest to know the Self more deeply, to uncover the truth of who I really am. I believe that true freedom comes from self-awareness, and that the journey is most enlightening when guided by wisdom and clarity.");
$bio_p4           = eliza_field('bio_p4', "In these shifting times, I fully embrace the dawning of the Age of Aquarius - a time when the individual is called to take full responsibility for their own path. With courage, understanding, and consciousness. And so I urge others to step into their power and experience life with intention and self-awareness. For me, the human journey is not one to be left to chance; it is something to be consciously directed and lived to its fullest potential.");
$bio_workshop_img = eliza_field('bio_workshop_image', get_template_directory_uri() . '/assets/eliza-workshop-presentation.jpg');
$bio_photo_badge  = eliza_field('bio_photo_badge', '✦ Interactive Workshops & Mentorship');
$bio_photo_caption= eliza_field('bio_photo_caption', 'Guiding seekers, students, and professionals toward conscious self-mastery.');
$bio_logistics_title = eliza_field('bio_logistics_title', 'Session Logistics & Inquiries');
$bio_logistics_text  = eliza_field('bio_logistics_text', 'Available weekdays after 6pm and weekends from 3pm by appointment in Lakeside, Cape Town or via distant session.');

// Services Fields
$serv_eyebrow     = eliza_field('serv_eyebrow', 'Offerings & Modalities');
$serv_title       = eliza_field('serv_title', 'A Symphony of Energy, Mind & Breath');
$serv_intro       = eliza_field('serv_intro', 'Harmonizing physical vitality, cognitive clarity, and spiritual awareness.');

// Book Fields
$book_eyebrow     = eliza_field('book_eyebrow', '✦ Internationally Published Work');
$book_title       = eliza_field('book_title', 'A Most Extraordinary Journey of Self-Discovery');
$book_subtitle    = eliza_field('book_subtitle', 'A 9-Year Spiritual Journey with the Enigmatic Comte de St Germain · By Eliza James');
$book_badge       = eliza_field('book_badge', 'Spiritual Biography · Metaphysical Wisdom');
$book_lead_quote  = eliza_field('book_lead_quote', '“Being a student and friend of St Germain is what brings me the most joy. My 9-year Spiritual Journey with the enigmatic Comte de St Germain is shared with the world in this work.”');
$book_synopsis    = eliza_field('book_synopsis', 'In this deeply personal and transformative book, Eliza chronicles her extraordinary nine-year communion with the Ascended Master, the enigmatic Comte de St Germain. Spanning deep metaphysical revelations, the dawning of the Age of Aquarius, and the sacred truth of personal sovereignty, the book serves as a guiding light for anyone seeking to uncover the truth of who they really are.');
$book_trailer_id  = eliza_field('book_trailer_youtube_id', 'VmsQBtoa7h0');

// Interview Fields
$int_eyebrow      = eliza_field('interview_eyebrow', '✦ Featured In-Depth Dialogue');
$int_title        = eliza_field('interview_title', 'In Conversation: Sacred Alignment');
$int_subtitle     = eliza_field('interview_subtitle', 'An In-Depth Interview with Body and Mind · Frequencies, Remoteness & Inner Unfolding');
$int_badge        = eliza_field('interview_badge', 'Body & Mind South Africa · Featured Guest');
$int_lead_quote   = eliza_field('interview_lead_quote', '“Spirit has no boundaries or borders — we touch on the essence of frequency elevation, remote healing, and holding the space for your becoming.”');
$int_narrative    = eliza_field('interview_narrative', 'In this heart-centered conversation, Eliza shares the origins of her journey—from deeply contemplating spiritual doctrines at age sixteen to her nine-year tutelage with the Ascended Master St Germain. We touch on the essence of Reconnective Healing (RH), the inner transformation that comes with elevating the frequency at which you vibrate, and what it means to hold space for your unique unfolding.');
$int_case_study   = eliza_field('interview_case_study', 'One of my most remarkable remote healing sessions had a team of Specialists at the world-renowned Groote Schuur Hospital (Cape Town, South Africa) stumped when their patient, after remotely administered RH sessions, no longer presented symptoms of an illness for which he was scheduled to go into a 6-month period of strict quarantine.');
$int_video_id     = eliza_field('interview_youtube_id', 'jJ9U9D2H43I');

// CTA Band Fields
$cta_title        = eliza_field('cta_title', "Do call me – let's have an informal chat over a cup of tea");
$cta_p1           = eliza_field('cta_p1', 'I am sure you have lots of questions and you will be under no obligation to then book a session. Psssssttt – really, I don\'t charge "an arm and a leg" for a 30 minute session.');
$cta_quote        = eliza_field('cta_quote', 'You are alive to give voice, action and physicality to GOD. To become the grandest version of the greatest vision you hold about Who You Are.');
?>
  <main id="main">

    <!-- Section 1: Hero -->
    <section class="home-hero">
      <div class="glow-1" aria-hidden="true"></div>
      <div class="glow-2" aria-hidden="true"></div>

      <!-- Sacred Geometry Ambient Ornament -->
      <svg class="sacred-mandala-bg" viewBox="0 0 400 400" aria-hidden="true">
        <g fill="none" stroke="#E5BF65" stroke-width="1.2">
          <circle cx="200" cy="200" r="60"/>
          <circle cx="200" cy="200" r="130"/>
          <circle cx="200" cy="200" r="195"/>
          <line x1="265" y1="200" x2="395" y2="200"/>
          <line x1="256.3" y1="232.5" x2="368.9" y2="297.5"/>
          <line x1="232.5" y1="256.3" x2="297.5" y2="368.9"/>
          <line x1="200" y1="265" x2="200" y2="395"/>
          <line x1="167.5" y1="256.3" x2="102.5" y2="368.9"/>
          <line x1="143.7" y1="232.5" x2="31.1" y2="297.5"/>
          <line x1="135" y1="200" x2="5" y2="200"/>
          <line x1="143.7" y1="167.5" x2="31.1" y2="102.5"/>
          <line x1="167.5" y1="143.7" x2="102.5" y2="31.1"/>
          <line x1="200" y1="135" x2="200" y2="5"/>
          <line x1="232.5" y1="143.7" x2="297.5" y2="31.1"/>
          <line x1="256.3" y1="167.5" x2="368.9" y2="102.5"/>
        </g>
        <g fill="#E5BF65">
          <circle cx="395" cy="200" r="3.5"/>
          <circle cx="368.9" cy="297.5" r="3.5"/>
          <circle cx="297.5" cy="368.9" r="3.5"/>
          <circle cx="200" cy="395" r="3.5"/>
          <circle cx="102.5" cy="368.9" r="3.5"/>
          <circle cx="31.1" cy="297.5" r="3.5"/>
          <circle cx="5" cy="200" r="3.5"/>
          <circle cx="31.1" cy="102.5" r="3.5"/>
          <circle cx="102.5" cy="31.1" r="3.5"/>
          <circle cx="200" cy="5" r="3.5"/>
          <circle cx="297.5" cy="31.1" r="3.5"/>
          <circle cx="368.9" cy="102.5" r="3.5"/>
          <circle cx="200" cy="200" r="5"/>
        </g>
      </svg>

      <!-- Mountain Silhouette Horizon -->
      <svg class="mountains" viewBox="0 0 1400 500" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <polygon points="0,500 0,300 220,160 420,340 560,220 760,390 860,270 1060,380 1180,230 1400,340 1400,500" fill="#241710" opacity="0.85"></polygon>
        <polygon points="0,500 0,380 160,310 380,420 500,330 700,440 900,340 1100,430 1300,390 1400,400 1400,500" fill="#170F0A"></polygon>
      </svg>

      <!-- Violet Flame Interactive Canvas -->
      <canvas class="hero-flame-canvas" id="heroFlameCanvas" aria-hidden="true"></canvas>

      <div class="inner">
        <div class="reveal">
          <div class="glass-chip" style="margin-bottom: 18px;">
            <span class="pulse-dot" aria-hidden="true"></span>
            <span><?php echo esc_html($hero_badge); ?></span>
          </div>
          <h1><?php echo esc_html($hero_title); ?></h1>
          <div class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></div>
          <p class="lede"><?php echo esc_html($hero_lede); ?></p>
          <div class="btn-row">
            <a class="btn btn-primary" href="<?php echo esc_url($hero_btn1_url); ?>"><?php echo esc_html($hero_btn1_text); ?></a>
            <a class="btn btn-ghost-light" href="<?php echo esc_url($hero_btn2_url); ?>"><?php echo esc_html($hero_btn2_text); ?></a>
          </div>
        </div>

        <div class="home-hero-portrait-wrap reveal delay-1">
          <div class="home-hero-portrait">
            <img src="<?php echo esc_url($hero_image); ?>" alt="<?php esc_attr_e('Eliza James', 'eliza-reconnection'); ?>" width="565" height="700" loading="eager">
          </div>
          <div class="portrait-floating-badge" aria-label="<?php esc_attr_e('Experience badge', 'eliza-reconnection'); ?>">
            <span style="color:var(--gold);">✦</span> <?php echo esc_html($hero_float_badge); ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 2: Biography -->
    <section>
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow"><?php echo esc_html($bio_eyebrow); ?></span>
          <h2 class="section-title"><?php echo esc_html($bio_title); ?></h2>
        </div>

        <div class="grid-balanced-2">
          <div class="prose reveal equal-col">
            <div class="home-hero-portrait-wrap" style="margin-bottom: 24px;">
              <div class="home-hero-portrait" style="max-width: 320px;">
                <img src="<?php echo esc_url($bio_portrait); ?>" alt="<?php esc_attr_e('Eliza James', 'eliza-reconnection'); ?>" width="565" height="700">
              </div>
            </div>
            <p><?php echo esc_html($bio_p1); ?></p>
            <p><?php echo esc_html($bio_p2); ?></p>
          </div>

          <div class="prose reveal delay-1 equal-col">
            <p><?php echo esc_html($bio_p3); ?></p>
            <p><?php echo esc_html($bio_p4); ?></p>

            <div class="bio-photo-card">
              <div class="bio-photo-frame">
                <img src="<?php echo esc_url($bio_workshop_img); ?>" alt="<?php esc_attr_e('Eliza James facilitating consciousness coaching workshops', 'eliza-reconnection'); ?>" width="1000" height="667" loading="lazy">
                <div class="bio-photo-caption">
                  <span class="bio-photo-badge"><?php echo esc_html($bio_photo_badge); ?></span>
                  <p><?php echo esc_html($bio_photo_caption); ?></p>
                </div>
              </div>
            </div>

            <div class="glass-box" style="margin-top: auto;">
              <h4><?php echo esc_html($bio_logistics_title); ?></h4>
              <p style="font-size:0.94rem; margin-bottom:12px;"><?php echo esc_html($bio_logistics_text); ?></p>
              <a class="btn btn-primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Schedule a Session</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 3: Services Grid -->
    <section class="section-alt">
      <div class="container-wide">
        <div class="reveal text-center" style="max-width: 780px; margin: 0 auto 12px;">
          <span class="eyebrow"><?php echo esc_html($serv_eyebrow); ?></span>
          <h2 class="section-title"><?php echo esc_html($serv_title); ?></h2>
          <p class="section-intro" style="margin: 10px auto 0; font-family: var(--font-serif); font-size: 1.15rem; font-style: italic; color: var(--ink-soft); max-width: 620px;">
            <?php echo esc_html($serv_intro); ?>
          </p>
        </div>

        <div class="offer-grid">
          <!-- Card 1 -->
          <div class="offer-card reveal delay-1">
            <div class="offer-card-header">
              <div class="offer-icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 32 32"><circle cx="16" cy="16" r="13" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="16" cy="16" r="5" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="16" cy="16" r="2" fill="currentColor"/></svg>
              </div>
              <span class="tag">Frequency Restoration</span>
              <h3>Reconnective Healing</h3>
              <span class="card-subtitle">(Restoring Balance and Harmony to Body, Mind and Spirit)</span>
            </div>
            <p class="card-desc">Reconnective Healing is often described as a form of energy that conveys corrective information to the body and mind.</p>
            <div class="offer-highlight-box">
              <span class="box-label">Stanford Research &amp; Clinical Impact</span>
              <p style="margin:0;">Stanford Professor Emeritus Dr. William Tiller states that when information carried through these frequencies is introduced, it creates coherence and order within the field and the body itself. The result: dramatic reports of regeneration instead of degeneration.</p>
            </div>
            <p class="offer-callout"><strong>The reality of its existence has been demonstrated clearly in practice, as well as in scientific research laboratories.</strong></p>
            <a class="card-cta-btn" href="<?php echo esc_url(home_url('/services/#reconnective-healing')); ?>">Explore Modality &rarr;</a>
          </div>

          <!-- Card 2 -->
          <div class="offer-card reveal delay-2">
            <div class="offer-card-header">
              <div class="offer-icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 32 32"><path d="M16 4 L28 16 L16 28 L4 16 Z" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="16" cy="16" r="4.5" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="16" cy="16" r="1.6" fill="currentColor"/></svg>
              </div>
              <span class="tag">Life Coaching</span>
              <h3>Curator of Consciousness</h3>
              <span class="card-subtitle">(Aligning your Outer Reality with your Inner World)</span>
            </div>
            <p class="card-desc">A curator doesn't create - hence I select, arrange, and present so others can understand and experience in a meaningful way.</p>
            <div class="offer-highlight-box">
              <span class="box-label">Applied to Consciousness</span>
              <ul>
                <li>I encourage reflection on wisdom from diverse traditions, experiences, and perspectives.</li>
                <li>I hold the space for contemplation and dialogue.</li>
                <li>I help you discover insights and explore the wisdom that exists within.</li>
                <li>I don't give you consciousness; I help you discover, recognize and encounter your own.</li>
              </ul>
            </div>
            <p class="offer-callout"><strong>Be you a student, a young employee, an executive, a religious follower or a seeker of truths - I help connect your head and your heart in a way that transforms your passion for your dreams into action for your life.</strong></p>
            <a class="card-cta-btn" href="<?php echo esc_url(home_url('/services/#curator-of-consciousness')); ?>">Explore Coaching &rarr;</a>
          </div>

          <!-- Card 3 -->
          <div class="offer-card reveal delay-3">
            <div class="offer-card-header">
              <div class="offer-icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 32 32"><path d="M16 16c0-4.5 4.3-6.8 7.6-4.6 3.3 2.2 2.7 7.7-1.7 8.9-5.6 1.5-10.4-3-9.7-8.6C12.9 6 19 3 24 6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
              </div>
              <span class="tag">Sacred Practice</span>
              <h3>Meditation and Conscious Breathing</h3>
              <span class="card-subtitle">(Connecting with a Higher Aspect of the Self)</span>
            </div>
            <p class="card-desc">Meditation is that sacred moment where the Consciousness comes to rest in the heartspace and connects to a Higher Aspect of the Self.</p>
            <div class="offer-highlight-box">
              <span class="box-label">The Breath as Elixir</span>
              <p style="margin:0;">The breath is the elixir of Life itself - it sustains our very being, yet we engage in this act of nurturing so unconsciously. 15min of deep, conscious breathing - practiced regularly, brings a transformation within that cascades into our outer experiences and enriches the very tapestry of our Life Journey.</p>
            </div>
            <p class="offer-callout"><strong>During one such breathing meditation the words “Pay attention to me and I shall attend to you” was downloaded into my consciousness.</strong></p>
            <a class="card-cta-btn" href="<?php echo esc_url(home_url('/services/#meditation-breathing')); ?>">Explore Practice &rarr;</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 4: Featured Book -->
    <section id="book" class="section-subtle">
      <div class="container-wide">
        <div class="reveal text-center" style="max-width: 840px; margin: 0 auto 36px;">
          <span class="eyebrow"><?php echo esc_html($book_eyebrow); ?></span>
          <h2 class="section-title"><?php echo esc_html($book_title); ?></h2>
          <p class="section-intro" style="margin: 12px auto 0; font-family: var(--font-serif); font-size: 1.18rem; font-style: italic; color: var(--ink-soft); max-width: 680px;">
            <?php echo esc_html($book_subtitle); ?>
          </p>
        </div>

        <div class="grid-balanced-2" style="align-items: center; gap: 44px;">
          <div class="prose reveal">
            <div class="glass-chip" style="margin-bottom: 16px;">
              <span class="pulse-dot" aria-hidden="true"></span>
              <span><?php echo esc_html($book_badge); ?></span>
            </div>
            <p class="lede" style="color: var(--ink); font-weight: 600; font-size: 1.15rem; line-height: 1.5; margin-bottom: 16px;">
              <?php echo esc_html($book_lead_quote); ?>
            </p>
            <p style="font-size: 0.98rem; line-height: 1.68; color: var(--ink-soft); margin-bottom: 20px;">
              <?php echo esc_html($book_synopsis); ?>
            </p>
            <div class="btn-row">
              <a class="btn btn-primary" href="https://www.youtube.com/watch?v=<?php echo esc_attr($book_trailer_id); ?>" target="_blank" rel="noopener noreferrer">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                Watch Trailer on YouTube &nearr;
              </a>
              <a class="btn btn-ghost-dark" href="<?php echo esc_url(home_url('/contact/')); ?>">Inquire About the Book</a>
            </div>
          </div>

          <div class="reveal delay-1">
            <div class="video-frame">
              <iframe src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($book_trailer_id); ?>?rel=0" title="A Most Extraordinary Journey of Self-Discovery - Official Book Trailer" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="video-footer-link">
              <a href="https://www.youtube.com/watch?v=<?php echo esc_attr($book_trailer_id); ?>" target="_blank" rel="noopener noreferrer">
                <span>✦</span> Watch &ldquo;A Most Extraordinary Journey of Self-Discovery&rdquo; Trailer on YouTube &nearr;
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 5: In Conversation Interview -->
    <section id="interview" class="section-alt">
      <div class="container-wide">
        <div class="reveal text-center" style="max-width: 840px; margin: 0 auto 36px;">
          <span class="eyebrow"><?php echo esc_html($int_eyebrow); ?></span>
          <h2 class="section-title"><?php echo esc_html($int_title); ?></h2>
          <p class="section-intro" style="margin: 12px auto 0; font-family: var(--font-serif); font-size: 1.18rem; font-style: italic; color: var(--ink-soft); max-width: 680px;">
            <?php echo esc_html($int_subtitle); ?>
          </p>
        </div>

        <div class="grid-balanced-2" style="align-items: center; gap: 44px;">
          <div class="prose reveal">
            <div class="glass-chip" style="margin-bottom: 16px;">
              <span class="pulse-dot" aria-hidden="true"></span>
              <span><?php echo esc_html($int_badge); ?></span>
            </div>
            <p class="lede" style="color: var(--ink); font-weight: 600; font-size: 1.15rem; line-height: 1.5; margin-bottom: 16px;">
              <?php echo esc_html($int_lead_quote); ?>
            </p>
            <p style="font-size: 0.98rem; line-height: 1.68; color: var(--ink-soft); margin-bottom: 20px;">
              <?php echo esc_html($int_narrative); ?>
            </p>
            <div class="offer-highlight-box" style="border-left: 3.5px solid var(--sage); background: rgba(77, 114, 87, 0.05); margin-bottom: 24px;">
              <span class="box-label" style="color: var(--sage);">✦ Remote Healing · Groote Schuur Hospital Case</span>
              <p style="margin: 0; font-size: 0.92rem; line-height: 1.62;">
                <?php echo esc_html($int_case_study); ?>
              </p>
            </div>
            <div class="btn-row">
              <a class="btn btn-primary" href="https://www.youtube.com/watch?v=<?php echo esc_attr($int_video_id); ?>" target="_blank" rel="noopener noreferrer">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                Watch Full Interview on YouTube &nearr;
              </a>
              <a class="btn btn-ghost-dark" href="<?php echo esc_url(home_url('/contact/')); ?>">Book a Distant Session</a>
            </div>
          </div>

          <div class="reveal delay-1">
            <div class="video-frame">
              <iframe src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr($int_video_id); ?>?rel=0" title="Sacred Alignment with Eliza: An Interview with Body and Mind" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="video-footer-link">
              <a href="https://www.youtube.com/watch?v=<?php echo esc_attr($int_video_id); ?>" target="_blank" rel="noopener noreferrer">
                <span>✦</span> Watch &ldquo;Sacred Alignment with Eliza&rdquo; Full Interview on YouTube &nearr;
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 6: Testimonials Grid -->
    <section>
      <div class="container">
        <div class="reveal text-center" style="max-width: 680px; margin: 0 auto 10px;">
          <span class="eyebrow">Explore</span>
          <h2 class="section-title">Testimonials &amp; Resources</h2>
        </div>
        <div class="offer-grid">
          <a class="offer-card reveal delay-1" href="<?php echo esc_url(home_url('/results/')); ?>">
            <span class="tag">Testimonials</span>
            <h3>Healing Results</h3>
            <p>Click to view documented client healing experiences across physical, emotional, and spiritual sessions.</p>
            <span class="card-link">View Results &rarr;</span>
          </a>
          <a class="offer-card reveal delay-2" href="<?php echo esc_url(home_url('/results/#coaching')); ?>">
            <span class="tag">Feedback</span>
            <h3>Coaching Remarks</h3>
            <p>What attendees and workshop participants are saying after meditation and life coaching sessions.</p>
            <span class="card-link">Read Remarks &rarr;</span>
          </a>
          <a class="offer-card reveal delay-3" href="https://www.austinmacauley.com/book/a-most-extraordinary-journey-of-self-discovery" target="_blank" rel="noopener">
            <span class="tag">Published Work</span>
            <h3>A Most Extraordinary Journey of Self-discovery</h3>
            <p>Eliza's internationally published book recounting nine years of study and spiritual journey with the Comte de St Germain.</p>
            <span class="card-link">Explore Book &rarr;</span>
          </a>
        </div>
      </div>
    </section>

    <!-- Section 7: Tea Chat CTA -->
    <section class="cta-band">
      <div class="glow" aria-hidden="true"></div>
      <div class="container-narrow reveal">
        <h2><?php echo esc_html($cta_title); ?></h2>
        <p><?php echo esc_html($cta_p1); ?><br><br>
        <strong><?php echo esc_html($cta_quote); ?></strong></p>
        <div class="btn-row">
          <a class="btn btn-primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Schedule an Appointment</a>
          <a class="btn btn-ghost-light" href="<?php echo esc_url(home_url('/results/')); ?>">View Client Results</a>
        </div>
      </div>
    </section>
  </main>
<?php
get_footer();
