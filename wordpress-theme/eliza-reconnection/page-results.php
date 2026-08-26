<?php
/**
 * Template Name: Results & Testimonials
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
        <span class="eyebrow eyebrow-on-dusk">Client Experiences</span>
        <h1>Results &amp; Voices</h1>
        <p>&ldquo;That transference that you give them is very real. They take it away with them. So whether they are done in an hour or whether they are done in the future, it’s with them. It’s their path.&rdquo; &mdash; <em>Dr Eric Pearl (Solomon Speaks, Ch. 23)</em></p>
      </div>
    </section>

    <!-- Documented Results with Filter Tabs (Balanced Grid) -->
    <section>
      <div class="container">
        <div class="reveal">
          <span class="eyebrow">Documented Cases</span>
          <h2 class="section-title">Healing Outcomes</h2>
          
          <div class="filter-tabs-row" role="tablist" aria-label="Testimonial Categories">
            <button class="filter-btn active" data-filter="all">All Outcomes</button>
            <button class="filter-btn" data-filter="physical">Physical Healing</button>
            <button class="filter-btn" data-filter="emotional">Emotional / Mental</button>
            <button class="filter-btn" data-filter="spiritual">Spiritual Touch</button>
          </div>
        </div>

        <div class="testi-grid">
          <!-- Physical 1 -->
          <div class="testi-card kind-physical reveal" data-category="physical">
            <span class="kind">Physical healing (1)</span>
            <p>&ldquo;This client has been walking with a limp for more than a year. During the session he could feel the energy moving through his body and down his legs. He reported feeling his &lsquo;spine being locked into the correct position&rsquo; and in fact mimicked the clicking sound it made. He felt completely relaxed during the session.&rdquo;</p>
            <div class="who"><strong>Result:</strong> He was immediately able to walk properly and continues to do so.</div>
          </div>

          <!-- Physical 2 -->
          <div class="testi-card kind-physical reveal" data-category="physical">
            <span class="kind">Physical healing (2)</span>
            <p>&ldquo;This client was diagnosed with a very aggressive strand of Tuberculosis (TB) and was scheduled to be hospitalised (quarantined) for a period of 6 months. I performed three distant healing sessions on him. Three weeks later the client was sent from the hospital ward where he was quarantined to a major hospital for testing, since no trace of tuberculosis could be found.&rdquo;</p>
            <div class="who"><strong>Result:</strong> The team of professors investigating his case took further X-rays and on determining that he was clear of TB, he was released from hospital.</div>
          </div>

          <!-- Physical 3 -->
          <div class="testi-card kind-physical reveal" data-category="physical">
            <span class="kind">Physical healing (3)</span>
            <p>&ldquo;This client suffered from regular bouts of pain in her side (spastic colon). She came for three sessions. Although every session brought a different experience, she always felt completely relaxed. It was specifically during her second session that she reported feeling a slight pain and discomfort in her side, as if her condition was aggravated &ndash; this subsided a little while after the session ended.&rdquo;</p>
            <div class="who"><strong>Result:</strong> To date, she has been free of the pain.</div>
          </div>

          <!-- Physical 4 -->
          <div class="testi-card kind-physical reveal" data-category="physical">
            <span class="kind">Physical healing (4)</span>
            <p>&ldquo;This client had a problem that had not yet been diagnosed. She was plagued with pains in her back that seemed to reach her heart region. Numerous visits to doctors yielded nothing, and she was eventually scheduled to see a specialist. She had two sessions prior to her visit to the specialist. When she eventually went to see the specialist, X-rays and other tests were done.&rdquo;</p>
            <div class="who"><strong>Result:</strong> Nothing out of the ordinary was found and she has since not again experienced any further pain/discomfort.</div>
          </div>

          <!-- Emotional 1 -->
          <div class="testi-card kind-emotional reveal" data-category="emotional">
            <span class="kind">Emotional / mental healing (1)</span>
            <p>&ldquo;This client found herself in a space where the burdens of life had become too much. She was emotionally drained and ready to give up. The parents approached me and I did three sessions with her. Every session saw her grow stronger, able to look ahead with enthusiasm and a renewed determination to face her future head on.&rdquo;</p>
            <div class="who"><strong>Result:</strong> A happy, healthy young person that sees a bright future ahead.</div>
          </div>

          <!-- Emotional 2 -->
          <div class="testi-card kind-emotional reveal" data-category="emotional">
            <span class="kind">Emotional / mental healing (2)</span>
            <p>&ldquo;This 55yr old lady suffers from diabetes. She was a heavy smoker and partook of the more than occasional beer or two. After her 2nd session, she found herself in tears and stated that she felt a profound awareness that all her illnesses that she is suffering from has been brought on by herself. She felt a deep sense of sadness that she had, for so many years, abused her body and she immediately resolved to stop doing so.&rdquo;</p>
            <div class="who"><strong>Result:</strong> Although she still indulges in the occasional puff and the odd drink, she looks and feels much younger &amp; stronger. Friends have commented on the change in her, and she has noted an improvement in her memory. Her medication (diabetes) has been reduced.</div>
          </div>

          <!-- Spiritual 1 -->
          <div class="testi-card kind-spiritual reveal" data-category="spiritual">
            <span class="kind">Spiritual touch (1)</span>
            <p>&ldquo;This client had a vision of a brightly lit tunnel extending up into the heavens. At the end of the tunnel she saw the outline of a man, whom she stated was of Light (a Being made of light). The vision brought a feeling of calm, peace and contentment. She then saw the colours green and blue (colours that represent healing) and the colour pink (representing love) flowing from the tunnel towards her. She was completely relaxed during the session and felt a deep sense of peace thereafter.&rdquo;</p>
            <div class="who"><strong>Outcome:</strong> Deep peace, contentment &amp; vision of Light</div>
          </div>

          <!-- Spiritual 2 -->
          <div class="testi-card kind-spiritual reveal" data-category="spiritual">
            <span class="kind">Spiritual touch (2)</span>
            <p>&ldquo;This client, who is a devout Christian and who was initially very sceptical of Reconnective Healing, had a profound experience. She exclaimed that she saw GOD, standing on a mountain top &ndash; his arms was outstretched and there was light pouring from his heart/chest area. We concluded that this was GODs way of showing her that this work was indeed of the Light.&rdquo;</p>
            <div class="who"><strong>Outcome:</strong> Profound encounter of divine Light</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Remarks From Clients (Balanced Multi-Column Masonry Flow) -->
    <section class="section-alt">
      <div class="container">
        <div class="reveal">
          <span class="eyebrow">Direct Words</span>
          <h2 class="section-title">Remarks From Clients</h2>
          <p class="section-intro">Immediate observations and sensations shared by clients upon rising from the healing table:</p>
        </div>

        <ul class="remarks-columns">
          <li class="reveal">1. &ldquo;I did not really feel anything specific, but I do feel extremely relaxed. In fact, I wish I could just lay here and soak it all up for a while longer&hellip;&rdquo;</li>
          <li class="reveal">2. &ldquo;That felt kinda cool &ndash; I could feel like little shocks in my arms and in my one leg&hellip;&rdquo; <em>(11yr old boy)</em></li>
          <li class="reveal">3. &ldquo;Were you focussing on my injured foot. I could feel heat on the soles of my feet&hellip;&rdquo;</li>
          <li class="reveal">4. &ldquo;I felt a tingling in my ear and then I could feel you take something out of it&hellip;&rdquo; <em>(13yr old girl)</em></li>
          <li class="reveal">5. &ldquo;That was amazing &ndash; I could feel the energy move through my body, like goosebumps. I feel quite chilled out and energized all at the same time&hellip;&rdquo;</li>
          <li class="reveal">6. &ldquo;I felt pressure in my head and then it sort of just whooshed out on the left side of my head. I could also feel the energy moving down my arm and into my fingers (like when your foot is &lsquo;sleeping&rsquo; &ndash; that kind of feeling)&hellip;&rdquo;</li>
          <li class="reveal">7. &ldquo;I felt warmth at the top of my head and then it moved over my whole body. I feel extremely relaxed&hellip;&rdquo;</li>
          <li class="reveal">8. &ldquo;I could feel the energy popping in certain areas in my body. I also felt my spine clicking back into place &ndash; did you hear it too&hellip;&rdquo;</li>
          <li class="reveal">9. &ldquo;At first I felt a bit heavy &ndash; like I was sinking into a foam mattress, but then my body felt somewhat light &ndash; like I was floating off the bed&hellip;&rdquo;</li>
          <li class="reveal">10. &ldquo;I felt a tapping on my shoulder and then I felt you apply pressure to my hand &ndash; over the inside of the thumb area&hellip;&rdquo;</li>
          <li class="reveal">11. &ldquo;When you started I saw colours, which I did not expect. It was dark green, with black blotches in it and there was a horrible smell &ndash; I can only describe it as arid. Later into the session, the colour and smell disappeared and there was a lovely pink and turquoise colour flowing over my tummy area. I have problems with my spine, but I have to tell you that you touched on all of them and I don't feel discomfort now. It also felt as if my arms were floating above the bed and I could feel energy run through it into my hands and out. That was quite extraordinary &ndash; thank you.&rdquo;</li>
          <li class="reveal">12. &ldquo;Wow, that was interesting. It felt like my insides were moving and I could feel you sort of repositioning my heart correctly in my chest area&hellip;&rdquo;</li>
          <li class="reveal">13. &ldquo;I feel different. I dont know how to put it into words, but I just know that I feel different&hellip;&rdquo;</li>
          <li class="reveal">14. &ldquo;That was very relaxing. I found myself lying on my back (like when I was a child) and looking up at the clouds sailing above me. It felt like I was floating off with the clouds. I feel very peaceful&hellip;&rdquo;</li>
          <li class="reveal">15. &ldquo;I felt a lot of energy around me. I also saw the colours blue and purple (but a different kind of blue and purple &ndash; deeper and brighter) swirling in circles in front of me. It was beautiful. Things look different &ndash; brighter &ndash; my eyesight seems better&hellip;&rdquo;</li>
          <li class="reveal">16. &ldquo;It felt like my head moved &ndash; did it? I also felt the energy in my leg and then it felt like my knee was sort of twisting around in my leg. I've always had problems with my knee&hellip;&rdquo;</li>
          <li class="reveal">17. &ldquo;I felt coldish and my back was paining a bit. Towards the end of the session, I started to warm up&hellip;&rdquo;</li>
          <li class="reveal">18. &ldquo;That was really very interesting. I felt relaxed, but it also felt like my right arm was sort of floating. I could also feel like one of my ligaments was put back into place in my right foot &ndash; I felt it a few times, although I dont have problems with my foot. And then you also touched my forehead (between my eyes)&hellip;&rdquo;</li>
          <li class="reveal">19. <em>(my 79yrs old client)</em>: &ldquo;Phew, I was floating &ndash; I feel relaxed. I felt you working on my colon &ndash; I will come again and maybe they will say that the colonoscopy won't be necessary after all&hellip;&rdquo;</li>
          <li class="reveal">20. <em>(8yr old little girl)</em>: &ldquo;Wow, I was in a bigggg hamster bubble full of energy. I was rolling forward and backward and swinging around and around &ndash; it was succhhhh fun!!! I tried to tell you that I was in a hamster bubble full of energy, but I could not speak, so I tried to write it on the bed for you (during the session this little girl was writing on the bed with her finger. I noticed it too late and could not make out the letters she was forming). And it was so nice and warm in the bubble.&rdquo;</li>
          <li class="reveal">21. <em>(21yr old varsity student)</em>: &ldquo;I don't know why, but I just felt happy &ndash; I just wanted to smile all the time. And I kept singing the song Time of My Life in my head &ndash; over and over. Strange, its not even one of my favourite songs. And the one line about standing out and being counted just had such an effect on me. I know I am going to do well in my upcoming exams &ndash; I look forward to my final year, and to think I was so worried about it! By the way &ndash; the pounding headache I had is completely gone!!&rdquo;</li>
          <li class="reveal">22. &ldquo;A few minutes into the session, I became aware of a bright orange/yellow light on my right hand side (about shoulder height). I wondered if you had brought a light into the room, but then it moved over my body and the orange/yellow rays hovered over my body for a while. The light then moved to my left side. Then I noticed a tall, dark of complexion man standing at the foot of the bed &ndash; he was just standing there smiling at me. It reminded me of my father (for some reason) and I felt a sense of peace. The light started to fade and so did the man standing at the foot of the bed. He was waving at me as he was fading away, and the words &lsquo;I will come again&rsquo; dropped into my head.&rdquo;</li>
        </ul>
      </div>
    </section>

    <!-- Coaching & Meditation Attendee Remarks (Evenly Balanced Columns) -->
    <section id="coaching">
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Feedback</span>
          <h2 class="section-title">Attendee Remarks from Workshops</h2>
        </div>

        <div class="grid-balanced-2">
          <!-- Column 1: Asiphe & Michelle -->
          <div class="reveal equal-col" style="display:flex; flex-direction:column; gap:20px;">
            <div class="testi-card kind-emotional" style="flex:1;">
              <span class="kind">Coaching Feedback</span>
              <p>&ldquo;What I would like you guys to know is that from today it is as if I am seeing life in a different way from what I previously thought. You are doing what you were born to do and what you have to do. Thank you.&rdquo;</p>
              <div class="who"><strong>Asiphe</strong></div>
            </div>

            <div class="testi-card kind-emotional" style="flex:1;">
              <span class="kind">Workshop Experience</span>
              <p>&ldquo;It was not like other workshops &ndash; very unique and eye opening. I am glad I attended.&rdquo;</p>
              <div class="who"><strong>Michelle</strong></div>
            </div>
          </div>

          <!-- Column 2: Nadia, Khanya & Thando -->
          <div class="reveal delay-1 equal-col" style="display:flex; flex-direction:column; gap:20px;">
            <div class="testi-card kind-spiritual" style="flex:1;">
              <span class="kind">Transformation</span>
              <p>&ldquo;OMW, I went from being rather nervous in the workshop to being excited about life and what lies ahead. Thank you for inviting me.&rdquo;</p>
              <div class="who"><strong>Nadia</strong></div>
            </div>

            <div class="testi-card kind-emotional" style="flex:1;">
              <span class="kind">Empowerment</span>
              <p>&ldquo;It was not what I expected. I now know that I am responsible for everything &ndash; from thought to deed. It feels empowering. A bit frightening, but also empowering to know that I am actually in control of my life (or not)&rdquo;</p>
              <div class="who"><strong>Khanya</strong></div>
            </div>

            <div class="testi-card kind-spiritual" style="flex:1;">
              <span class="kind">Meditation Insight</span>
              <p>&ldquo;And I thought meditation was something weird &ndash; something that I would not be interested in or even be able to really do.&rdquo;</p>
              <div class="who"><strong>Thando</strong></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Practitioner Testimonials Section (Evenly Balanced Columns) -->
    <section class="section-alt">
      <div class="container">
        <div class="reveal" style="margin-bottom: 28px;">
          <span class="eyebrow">Global Practitioner Records</span>
          <h2 class="section-title">Practitioner Testimonials</h2>
        </div>

        <div class="grid-balanced-2">
          <!-- Column 1: Father's Case -->
          <div class="reveal equal-col">
            <div class="glass-box" style="height:100%; display:flex; flex-direction:column;">
              <h4>Father's Case (RH Official Email Link, 5 Feb 2020)</h4>
              <p style="font-size:0.94rem; line-height:1.65; flex-grow:1;">&ldquo;Let me start by talking about my dear father&hellip; 6 years ago, when he was 87 years old, he was diagnosed with bladder cancer. His surgeon advised our family that he had around 6 months to live and, after his physician tried different advanced treatment methods on him, my father's situation wasn't improving. I suggested to my dad that I would be glad to facilitate 3 Reconnective Healing sessions for him. Even though my dad wasn't a believer in the RH frequencies, surprisingly he accepted my offer. After the 3rd session of RH, he slowly started to get his energy back. Then, 1 month later, we went back for a follow up with his surgeon who reviewed his case and was dumbfounded by the results&hellip; it showed a clear bill of health with no cancer remaining.</p>
              <p style="font-size:0.94rem; line-height:1.65; margin-bottom:0;">My papa is now 93 years old, walking half an hour each day and enjoying his life to the fullest. From time to time when he seems to have a little less energy, he asks me for a RH session and what he sees is amazing :-)! While lying in bed with his eyes closed he sees beautiful rainbow colors; beautiful flowers; a shining light piercing through the clouds&hellip; and more. He once saw the face of a beautiful woman with large wings spread on both sides of her body telling him not to be scared who carried him on beautiful voyages into the sky above. Each time, upon his awakening, he felt a sense of peace and the next day, his energy was back in full swing again 🙂&rdquo;</p>
            </div>
          </div>

          <!-- Column 2: Dr. Xavier Guzmán Case -->
          <div class="reveal delay-1 equal-col">
            <div class="glass-box" style="height:100%; display:flex; flex-direction:column;">
              <h4>Case Record by Dr. F. Xavier C. Guzmán (Surgeon, Oaxaca, Mexico)</h4>
              <p style="font-size:0.94rem; line-height:1.65; flex-grow:1;">&ldquo;I will start with a most spectacular healing that happened immediately after receiving Reconnective Healing training in Mexico City. My patient Manuel (55 years old) could not stand on his feet, one step would cause a strong attack of rheumatoid arthritis. He also had systemic immune nature and diabetes mellitus with Glycemia at 400 mg. He had not slept for a month because of intense pain, fever, and chills despite all specialist medications.</p>
              <p style="font-size:0.94rem; line-height:1.65; margin-bottom:0;">Manuel sat during the session, which lasted no more than 15 minutes. At the end of this time Manuel reported a very nice light and heat went through his body from head to foot and his pain had decreased 30%. On Monday, he walked upstairs needing only one person to help. By Friday, his glucose dropped to 220mg, he walked upstairs with no assistance, and had an 80% recovery with vitality returned. The next week Manuel returned to work, and all his laboratory levels were normal just 10 days after his last healing session. Manuel is now healthy with no symptoms of lupus or rheumatoid arthritis, and his diabetes has stabilized. I think the future of medicine is this, the management of energy and the interaction of the patient with a new way of thinking and energy levels. Subtle, but powerful.&rdquo;</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Tea Chat & Booking CTA -->
    <section class="cta-band">
      <div class="glow" aria-hidden="true"></div>
      <div class="container-narrow reveal">
        <h2>Do call me – let's have an informal chat over a cup of tea</h2>
        <p>I am sure you have lots of questions and you will be under no obligation to then book a session. Psssssttt – really, I don't charge "an arm and a leg" for a 30 minute session.<br><br>
        <strong>You are alive to give voice, action and physicality to GOD. To become the grandest version of the greatest vision you hold about Who You Are.</strong></p>
        <div class="btn-row">
          <a class="btn btn-primary" href="<?php echo esc_url(home_url('/contact/')); ?>">Schedule a Session</a>
          <a class="btn btn-ghost-light" href="<?php echo esc_url(home_url('/services/')); ?>">Explore Services</a>
        </div>
      </div>
    </section>
  </main>
<?php
}
?>

<?php
get_footer();
