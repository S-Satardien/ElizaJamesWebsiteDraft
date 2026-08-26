<?php
/**
 * Template Name: Science & Evidence
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
        <span class="eyebrow eyebrow-on-dusk">Research &amp; Exploration</span>
        <h1>Evidence &amp; Science</h1>
        <p>&ldquo;The reality of its existence has been demonstrated clearly in practice, as well as in scientific research laboratories.&rdquo;</p>
      </div>
    </section>

    <!-- Section 1: Science Confirms (Evenly Balanced Columns) -->
    <section id="science-confirms">
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Laboratory Research</span>
          <h2 class="section-title">Science Confirms</h2>
        </div>

        <div class="grid-balanced-2">
          <!-- Column 1: Background & Physiological Response -->
          <div class="prose reveal equal-col">
            <p>A number of researchers and research teams from prominent Universities and Research Facilities (University of Arizona, Stanford University, Quantum Biology Research Labs, St. Petersburg Federal Research Institute, amongst others) have confirmed that Reconnective Healing is indeed unique and that it represents a comprehensive spectrum of healing comprising energy, light and information.</p>

            <div class="glass-box" style="margin: 16px 0;">
              <h4>Session Physical Effects</h4>
              <p style="margin:0; font-size:0.94rem;">During a session the client will experience a number of physical effects (involuntary muscle movement, twitching, rapid eye movement, changes in breathing patterns, intestinal noises, etc.) – known as registers – which is a reaction of the client's body to the RH frequencies. These registers can be seen and felt, and is an acknowledgement that the healing frequencies are actively at work.</p>
            </div>

            <p>One of the most noticeable registers is rapid eye movement (or fluttering of the eyelids). This indicates that the client has slipped into a brainwave state that is completely relaxed, but at the same time highly receptive and aware.</p>
          </div>

          <!-- Column 2: 4 Key Research Findings Grid -->
          <div class="reveal delay-1 equal-col">
            <div class="stat-list" style="margin-top:0;">
              <div class="stat-item">
                <strong>University of Arizona</strong>
                <span>Dr. Gary Schwartz demonstrated that the energy facilitates measurable transformations in both practitioners and subjects beyond traditional biofield energy therapies.</span>
              </div>
              <div class="stat-item">
                <strong>Stanford University</strong>
                <span>Dr. William Tiller showed that when these frequencies are introduced, entropy decreases and measurable coherence and order are created within the ambient space and biological tissue.</span>
              </div>
              <div class="stat-item">
                <strong>Quantum Biology Labs</strong>
                <span>Dr. Glen Rein discovered that human DNA unwinds and heals at substantially accelerated rates when exposed to Reconnective Healing frequencies compared to control samples.</span>
              </div>
              <div class="stat-item">
                <strong>St. Petersburg Institute</strong>
                <span>Dr. Konstantin Korotkov demonstrated immediate, sustained enhancements in human autonomic nervous system regulation and biophotonic emissions.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 2: Russian DNA Discoveries (Evenly Balanced Columns) -->
    <section class="section-alt">
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Danica Collins Research</span>
          <h2 class="section-title">Russian DNA Discoveries: Words and Frequencies Can Alter Human DNA</h2>
        </div>

        <div class="grid-balanced-2">
          <!-- Column 1: Reprogramming DNA & Acoustic Language -->
          <div class="prose reveal equal-col">
            <p>Russian scientists have delved into the 90% of our DNA that western researchers used to label as &ldquo;junk DNA&rdquo;. Biophysicist and molecular biologist Pjotr Garjajev and his colleagues discovered that DNA is not only responsible for the construction of our body, but also serves as data storage and communication medium.</p>

            <div class="glass-box" style="margin-top: auto;">
              <h4>Changing DNA With Spoken Words and Phrases</h4>
              <p style="font-size:0.94rem; margin-bottom:0;">The Russian researchers found that the genetic code follows the same rules as human languages. Living DNA substance will always react to language-modulated laser rays and even to radio waves, if the proper frequencies are being used. This explains why affirmations, autogenous training, hypnosis, and spiritual intentions can have such strong effects on human bodies and genomes.</p>
            </div>
          </div>

          <!-- Column 2: Hypercommunication & Magnetized Wormholes -->
          <div class="prose reveal delay-1 equal-col">
            <p>Garjajev's research group proved that with modulated frequencies, damaged chromosomes can be repaired. They captured information patterns of a particular DNA and transmitted it onto another, thus reprogramming cells to another genome (e.g. transforming frog embryos to salamander embryos purely through transmitting informational frequencies).</p>

            <div class="glass-box" style="margin-top: auto;">
              <h4>DNA and Intuition: Magnetized Wormholes</h4>
              <p style="font-size:0.94rem; margin-bottom:0;">When hypercommunication occurs, an observation of human consciousness and DNA interacting through vacuum micro-tubes (&ldquo;magnetized wormholes&rdquo; or Einstein-Rosen bridges) can be recorded. This explains remote healing, telepathy, and spontaneous spiritual insight without spatial or temporal degradation.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 3: Dr. Eric Pearl (Evenly Balanced Columns) -->
    <section id="dr-eric-pearl">
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Founder Insights</span>
          <h2 class="section-title">Dr. Eric Pearl</h2>
        </div>

        <div class="grid-balanced-2">
          <!-- Column 1: Background, Channel & Quote -->
          <div class="prose reveal equal-col">
            <p>Dr. Eric Pearl is the founder of The Reconnection and Reconnective Healing. As a chiropractor in Los Angeles, his patients began reporting miraculous recoveries from cancer, cerebral palsy, and multiple sclerosis when he simply held his hands near them.</p>

            <blockquote class="pull">
              &ldquo;I am not the healer; only GOD is the healer. We are the instrument of transmission, the conduit through which these newly available frequencies flow to catalyze balance and wholeness.&rdquo;
              <cite>Dr. Eric Pearl</cite>
            </blockquote>

            <p>He has appeared on television worldwide, spoken at the United Nations, and authored the international bestseller <em>The Reconnection: Heal Others, Heal Yourself</em> and <em>Solomon Speaks On Reconnecting Your Life</em>.</p>
          </div>

          <!-- Column 2: What Healing Means & Cured vs Healed -->
          <div class="prose reveal delay-1 equal-col">
            <div class="glass-box" style="margin-top: 0; margin-bottom: 20px;">
              <h4>What Does Healing Mean to You?</h4>
              <p style="font-size:0.94rem; margin-bottom:0;">Healing is a return to balance. Every health challenge is a combination of the physical, mental, spiritual, and emotional. We don't &lsquo;treat&rsquo; the symptom. Reconnective Healing doesn't specifically diagnose or treat illness &ndash; it restores harmonic coherence so the body can heal itself naturally.</p>
            </div>

            <div class="glass-box" style="margin-top: auto;">
              <h4>Cured vs Healed</h4>
              <p style="font-size:0.94rem; margin-bottom:0;">To be cured means the physical symptom has been removed or alleviated. To be healed means to be restored to wholeness on all levels of your Being. Often, when you receive Reconnective Healing, you receive far more than you anticipated, opening doors to profound spiritual evolution.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 4: Of Interest & Articles (Evenly Balanced Columns) -->
    <section id="of-interest" class="section-alt">
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Scientific Insights</span>
          <h2 class="section-title">Of Interest &amp; Articles</h2>
        </div>

        <div class="grid-balanced-2">
          <!-- Column 1: Heart Field & Biophotons -->
          <div class="reveal equal-col">
            <div class="journal-entry" style="margin-bottom: 24px;">
              <div class="meta-row">
                <span class="eyebrow" style="margin-bottom:0;">Physics &amp; Biology</span>
                <span class="date">David Math &middot; HeartMath</span>
              </div>
              <h3>The Human Heart Electromagnetic Field</h3>
              <p>The electrical field generated by the human heart is about 60 times greater in amplitude than the brain waves, and its magnetic field is up to 5,000 times stronger than that of the brain. It permeates every cell in our body and radiates several feet into the surrounding space, synchronizing with those around us.</p>
            </div>

            <div class="journal-entry">
              <div class="meta-row">
                <span class="eyebrow" style="margin-bottom:0;">Biophysics</span>
                <span class="date">Dr. Fritz-Albert Popp</span>
              </div>
              <h3>DNA Light &amp; Biophoton Emission</h3>
              <p>Living organisms emit a steady stream of photons (light particles) called biophotons. Healthy cells emit coherent biophotons, while diseased cells exhibit chaotic light emission. Reconnective Healing frequencies restore this biological light coherence, triggering cellular repair.</p>
            </div>
          </div>

          <!-- Column 2: Holistic Health & Brain/Consciousness Articles -->
          <div class="reveal delay-1 equal-col">
            <div class="journal-entry" style="margin-bottom: 24px;">
              <div class="meta-row">
                <span class="eyebrow" style="margin-bottom:0;">Article Review</span>
                <span class="date">Holistic Medicine</span>
              </div>
              <h3>Holistic Health: The Interconnected Matrix</h3>
              <p>Modern medicine is increasingly acknowledging that true well-being requires addressing the triad of body, mind, and spirit. When one area experiences trauma or disharmony, it manifests across the entire physiological and energetic matrix of the human organism.</p>
            </div>

            <div class="journal-entry">
              <div class="meta-row">
                <span class="eyebrow" style="margin-bottom:0;">Consciousness</span>
                <span class="date">Dr. Eben Alexander &middot; Harvard</span>
              </div>
              <h3>The Brain Does Not Create Consciousness</h3>
              <p>Harvard-trained neurosurgeon Dr. Eben Alexander discovered through his profound clinical near-death experience that consciousness exists independently of the brain. The physical brain functions as a reduction valve or transceiver for a vast, universal consciousness.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Tea Chat CTA -->
    <section class="cta-band">
      <div class="glow" aria-hidden="true"></div>
      <div class="container-narrow reveal">
        <h2>Do call me – let's have an informal chat over a cup of tea</h2>
        <p>I am sure you have lots of questions and you will be under no obligation to then book a session. Psssssttt – really, I don't charge "an arm and a leg" for a 30 minute session.<br><br>
        <strong>You are alive to give voice, action and physicality to GOD. To become the grandest version of the greatest vision you hold about Who You Are.</strong></p>
        <div class="btn-row">
          <a class="btn btn-primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Book a Session</a>
          <a class="btn btn-ghost-light" href="<?php echo esc_url(home_url('/results/')); ?>">Read Client Results</a>
        </div>
      </div>
    </section>
  </main>
<?php
}
?>

<?php
get_footer();
