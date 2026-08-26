<?php
/**
 * Template Name: About Us & Sacred Journey
 * @package Eliza_Reconnection
 */
get_header();
?>
<?php
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
        <h1>About Us</h1>
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

            <p>I am based in Lakeside, Cape Town and most of my clients come to my home-office. Clients living in other Provinces book distant healing sessions or would plan sessions during their holidays to the Cape.</p>

            <p>During office hours, I manage an <a href="http://www.asf.org.za" target="_blank" rel="noopener noreferrer">NGO</a>. Healing sessions are strictly by appointment. Available times are: weekdays after 6pm, Saturdays and Sundays from 3pm. And should you be wondering &ndash; my youngest client is aged 8yrs and the eldest, to date is aged 79yrs.</p>

            <div class="glass-box" style="margin-top: auto;">
              <h4>Session Logistics &amp; Hours</h4>
              <ul>
                <li><strong>Practicing Since:</strong> 2011 (Sydney, Australia training)</li>
                <li><strong>Location:</strong> Lakeside, Cape Town (Home-Office)</li>
                <li><strong>Available Times:</strong> Weekdays after 6pm, Saturdays &amp; Sundays from 3pm</li>
                <li><strong>Format:</strong> In-person or Distant Healing sessions</li>
                <li><strong>Daily Work:</strong> NGO Management (African Scholars' Fund)</li>
                <li><strong>Client Span:</strong> 8 years young to 79 years grand</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Biography & Background Section (Evenly Balanced Columns) -->
    <section class="section-alt">
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Background &amp; Philosophy</span>
          <h2 class="section-title">Biography</h2>
        </div>

        <div class="grid-balanced-2">
          <div class="prose reveal equal-col">
            <p>I am a graduate of the University of Cape Town Graduate School of Business; an experienced Reconnective Healing Practitioner (having added the skill of presenting Meditation and Conscious Breathing Workshops into the mix). Conversational or presenting the more structured Life Coaching Workshops is second nature and I resonate strongly with the work of Drs Hurtak (Academy for Future Science). However, being a student and friend of St Germain is what brings me the most joy. My 9-year Spiritual Journey with the enigmatic Comte de St Germain was recently shared with the world in my internationally published work (<em>A Most Extraordinary Journey of Self-discovery</em>).</p>

            <p>I consider myself an ordinary individual, grounded in the realities of daily life. I am a mother, a colleague, a friend and a sibling - someone who laughs with abandon, sheds tears unashamedly, feels the full spectrum of emotions, and loves fiercely. I am not immune to the world's hardships and the harsh realities of corruption, inequality, and inhumanity. And yes, I often voice my frustration with a heartfelt, &ldquo;What the f#ck!&rdquo;</p>
          </div>

          <div class="prose reveal delay-1 equal-col">
            <p>I've always had this sense that &ldquo;there must be more to life&rdquo; than what the status quo offers - that there is a greater truth beyond what most people settle for. My hunger for understanding has led me to seminars, books, and teachings that dive into the mysteries of the world. These steps are not just intellectual - each step is a quest to know the Self more deeply, to uncover the truth of who I really am. I believe that true freedom comes from self-awareness, and that the journey is most enlightening when guided by wisdom and clarity.</p>

            <p>In these shifting times, I fully embrace the dawning of the Age of Aquarius - a time when the individual is called to take full responsibility for their own path. With courage, understanding, and consciousness. And so I urge others to step into their power and experience life with intention and self-awareness. For me, the human journey is not one to be left to chance; it is something to be consciously directed and lived to its fullest potential.</p>

            <!-- Group Collaboration & Vision Photo Card -->
            <div class="bio-photo-card">
              <div class="bio-photo-frame">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/eliza-group-session.jpg" alt="Eliza James facilitating conscious vision and alignment sessions" width="1000" height="750" loading="lazy" style="height: 200px; object-fit: cover; object-position: center 30%;">
                <div class="bio-photo-caption">
                  <span class="bio-photo-badge">✦ Conscious Life Purpose &amp; Vision</span>
                  <p>Transforming inner clarity into shared growth, vision, and real-world alignment.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Tea Chat & Contact CTA -->
    <section class="cta-band">
      <div class="glow" aria-hidden="true"></div>
      <div class="container-narrow reveal">
        <h2>Do call me – let's have an informal chat over a cup of tea</h2>
        <p>I am sure you have lots of questions and you will be under no obligation to then book a session. Psssssttt – really, I don't charge "an arm and a leg" for a 30 minute session.<br><br>
        <strong>You are alive to give voice, action and physicality to GOD. To become the grandest version of the greatest vision you hold about Who You Are.</strong></p>
        <div class="btn-row">
          <a class="btn btn-primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Get in touch</a>
          <a class="btn btn-ghost-light" href="<?php echo esc_url(home_url('/services/')); ?>">View Services</a>
        </div>
      </div>
    </section>
  </main>
<?php
}
?>

<?php
get_footer();
