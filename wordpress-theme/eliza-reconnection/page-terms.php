<?php
/**
 * Template Name: Terms & Conditions & Policies
 * @package Eliza_Reconnection
 */
get_header();
?>
<style>
/* =========================================================================
   STICKY TERMS POLICIES SUBNAV & SCROLL TARGETS
   ========================================================================= */
.admin-bar .site-header {
  top: 32px;
}
@media (max-width: 782px) {
  .admin-bar .site-header {
    top: 0;
  }
}
.terms-subnav {
  position: -webkit-sticky;
  position: sticky;
  top: 62px;
  z-index: 400;
  padding: 10px 0;
  background: rgba(253, 251, 247, 0.96);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border-bottom: 1px solid rgba(212, 175, 55, 0.25);
  box-shadow: 0 4px 20px rgba(23, 15, 10, 0.04);
  transition: top 0.15s ease;
}
.logged-in .terms-subnav,
.admin-bar .terms-subnav {
  top: 94px; /* 32px admin bar + 62px scrolled header = 94px (FLUSH, ZERO GAP!) */
}
@media (max-width: 782px) {
  .logged-in .terms-subnav,
  .admin-bar .terms-subnav {
    top: 62px;
  }
}
.terms-subnav-inner {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}
.terms-subnav-label {
  font-size: 0.78rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--gold-dark, #AA7C11);
  flex-shrink: 0;
}
.terms-subnav-links {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}
.terms-nav-chip {
  display: inline-flex;
  align-items: center;
  padding: 7px 15px;
  border-radius: 999px;
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--ink, #170F0A);
  background: rgba(255, 255, 255, 0.92);
  border: 1px solid rgba(212, 175, 55, 0.35);
  text-decoration: none;
  transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
  white-space: nowrap;
  cursor: pointer;
}
.terms-nav-chip:hover {
  background: rgba(212, 175, 55, 0.14);
  border-color: var(--gold, #D4AF37);
  color: var(--gold-dark, #AA7C11);
  transform: translateY(-1px);
}
.terms-nav-chip.active {
  background: var(--gold-dark, #AA7C11) !important;
  color: #ffffff !important;
  border-color: var(--gold-dark, #AA7C11) !important;
  box-shadow: 0 4px 12px rgba(170, 124, 17, 0.25);
}
.terms-policy-section {
  scroll-margin-top: 155px;
}
@media (max-width: 768px) {
  .terms-subnav-inner {
    justify-content: flex-start;
  }
  .terms-subnav-links {
    flex-wrap: nowrap;
    overflow-x: auto;
    justify-content: flex-start;
    padding-bottom: 4px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
  }
  .terms-subnav-links::-webkit-scrollbar {
    display: none;
  }
  .terms-policy-section {
    scroll-margin-top: 140px;
  }
}
</style>
<?php
$page_id = get_queried_object_id() ?: get_the_ID();
if (is_front_page() || is_home()) {
    $page_id = get_option('page_on_front') ?: $page_id;
}
$saved_content = get_post_field('post_content', $page_id);
?>
<main id="main">
<?php
if (!empty(trim($saved_content))) {
    $clean_saved = preg_replace('#^<main[^>]*>#i', '', trim($saved_content));
    $clean_saved = preg_replace('#</main>$#i', '', trim($clean_saved));
    echo $clean_saved;
} else {
?>
<!-- Page Hero -->
  <section class="page-hero">
    <div class="glow" aria-hidden="true"></div>
    <div class="container reveal is-revealed">
      <span class="eyebrow eyebrow-on-dusk">Customer Care &amp; Compliance · Eliza Reconnection</span>
      <h1>Terms &amp; Conditions · Store Policies</h1>
      <p>“Honouring transparent, secure, and respectful relationships with every client, reader, and seeker.”</p>
    </div>
  </section>

  <!-- Sticky Quick Navigation Bar for Policies -->
  <nav class="terms-subnav" aria-label="Store Policies Navigation" style="top: 103px;">
    <div class="container">
      <div class="terms-subnav-inner">
        <span class="terms-subnav-label">Jump to:</span>
        <div class="terms-subnav-links">
          <a href="#merchant-info" class="terms-nav-chip">1. Business Details</a>
          <a href="#delivery" class="terms-nav-chip">2. Delivery Policy</a>
          <a href="#cancellations" class="terms-nav-chip">3. Cancellations</a>
          <a href="#refunds" class="terms-nav-chip">4. Refunds &amp; Returns</a>
          <a href="#payment-security" class="terms-nav-chip">5. Payment Security</a>
          <a href="#popia-privacy" class="terms-nav-chip active">6. Privacy &amp; POPIA</a>
          <a href="#contact-support" class="terms-nav-chip">7. Contact Support</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Legal & Policy Content -->
  <section style="padding: 48px 0 80px;">
    <div class="container">
      <div style="max-width: 920px; margin: 0 auto; display: flex; flex-direction: column; gap: 48px;">

        <!-- 1. BUSINESS DETAILS & GENERAL TERMS -->
        <article id="merchant-info" class="reveal terms-policy-section is-revealed" style="scroll-margin-top: 155px;">
          <div style="margin-bottom: 16px;">
            <span class="eyebrow">Overview · Agreement to Terms</span>
            <h2 class="section-title" style="font-size: 1.85rem;">1. General Terms of Service &amp; Business Information</h2>
          </div>
          <div class="prose" style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft);">
            <p>These Terms and Conditions govern your purchase of publications and engagement with services through this website (<code>https://elizareconnection.co.za</code>). By placing an order or booking an appointment, you confirm that you have read, understood, and agreed to be bound by these Terms. We reserve the right to revise or update these Terms to reflect changes in regulatory standards, courier arrangements, or payment gateway requirements. The latest version will always be published on this page.</p>
            
            <div class="glass-box" style="margin: 20px 0; padding: 24px; border-left: 4px solid var(--gold);">
              <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; margin-bottom: 12px; font-size: 1.1rem;">Merchant &amp; Business Registration Details</h4>
              <ul style="margin: 0; padding-left: 20px; font-size: 0.92rem; line-height: 1.7;">
                <li><strong>Trading Name:</strong> Eliza Reconnection (Sole Proprietorship of Eliza James)</li>
                <li><strong>Country of Domicile:</strong> South Africa</li>
                <li><strong>Physical Operating Address:</strong> Promenade Road, Lakeside, Cape Town, 7945, Western Cape, South Africa</li>
                <li><strong>Contact Email:</strong> <a href="mailto:eliza.reconnection@gmail.com" style="color: var(--gold-dark, #AA7C11); font-weight: 600;">eliza.reconnection@gmail.com</a></li>
                <li><strong>Customer Support Phone:</strong> <a href="tel:+27829269851" style="color: var(--gold-dark, #AA7C11); font-weight: 600;">+27 82 926 9851</a></li>
                <li><strong>Transactional Currency:</strong> South African Rand (ZAR)</li>
              </ul>
            </div>
            <p><br></p>
          </div>
        </article>

        <!-- 2. DELIVERY & SHIPPING POLICY -->
        <article id="delivery" class="reveal terms-policy-section is-revealed" style="scroll-margin-top: 155px;">
          <div style="margin-bottom: 16px;">
            <span class="eyebrow">Fulfillment · Nationwide Courier</span>
            <h2 class="section-title" style="font-size: 1.85rem;">2. Delivery &amp; Shipping Policy</h2>
          </div>
          <div class="prose" style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft);">
            <p>We pride ourselves on prompt, personal, and reliable fulfillment of both physical literature and instant digital editions:</p>

            <div class="grid-balanced-2" style="margin: 24px 0; gap: 24px;">
              <!-- Physical Book Deliveries -->
              <div class="glass-box" style="padding: 24px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                  <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                    <span>Physical Books · Door-to-Door Courier</span>
                  </h4>
                  <ul style="margin: 0; padding-left: 18px; font-size: 0.92rem; line-height: 1.65;">
                    <li><strong>Coverage:</strong> Door-to-door courier delivery across all 9 provinces in South Africa.</li>
                    <li><strong>Delivery Timeframe:</strong> Dispatched and delivered to your doorstep within <strong>10 to 14 business days</strong> from receipt of payment.</li>
                    <li><strong>Courier Cost:</strong> <strong>Included</strong> in the advertised price (e.g. R450 includes packaging, local handling, and tracked door courier).</li>
                    <li><strong>Tracking:</strong> A unique courier tracking waybill number is sent to your mobile phone via SMS and to your email upon collection.</li>
                    <li><strong>Signed Copies:</strong> If you requested a personal author inscription, Eliza will personally sign the book prior to packaging.</li>
                  </ul>
                </div>
              </div>

              <!-- Digital PDF Publications -->
              <div class="glass-box" style="padding: 24px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                  <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                    <span>Instant Digital Guides · PDF Download</span>
                  </h4>
                  <ul style="margin: 0; padding-left: 18px; font-size: 0.92rem; line-height: 1.65;">
                    <li><strong>Delivery Method:</strong> Immediate electronic delivery.</li>
                    <li><strong>Delivery Timeframe:</strong> <strong>Instant</strong> upon completion of PayFast payment.</li>
                    <li><strong>Fulfillment Access:</strong> A direct download button is rendered on your payment confirmation screen, and an automated download link is sent to your email address.</li>
                    <li><strong>Shipping Fee:</strong> <strong>R0.00 (Free)</strong> — No shipping charges apply to digital products.</li>
                  </ul>
                </div>
              </div>
            </div>

            <p><strong>Physical Address Requirements:</strong> Deliveries are carried out by door-to-door couriers who require a physical street address where a recipient is available during normal working hours (8:00 AM to 5:00 PM, Monday through Friday). Deliveries cannot be completed to P.O. Box addresses.</p>
            <p><strong>International Orders:</strong> Physical orders via PayFast on this website are restricted to South African addresses. For international readers please use the provided links to order through <strong>Amazon Paperback</strong> or <strong>Amazon Kindle</strong>.</p>
          </div>
        </article>

        <!-- 3. CANCELLATION POLICY -->
        <article id="cancellations" class="reveal terms-policy-section is-revealed" style="scroll-margin-top: 155px;">
          <div style="margin-bottom: 16px;">
            <span class="eyebrow">Order Adjustments · Prior to Dispatch</span>
            <h2 class="section-title" style="font-size: 1.85rem;">3. Cancellation Policy</h2>
          </div>
          <div class="prose" style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft);">
            <p>We understand that circumstances may change. Our cancellation rules are fair, practical, and transparent:</p>

            <div class="glass-box" style="margin: 20px 0; padding: 24px;">
              <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.05rem;">Consultation &amp; Healing Appointments</h4>
              <p style="margin: 0; font-size: 0.92rem; line-height: 1.65;">
                In-person or remote Reconnective Healing appointments, Meditation and Consciousness Coaching Workshop attendance may be rescheduled or cancelled with at least <strong>48 hours prior notice</strong>. Appointments cancelled with less than 48 hours notice may incur a 50% reservation fee due to the venue requirements, practitioner preparation and dedicated time slot allocated.
              </p>
            </div>
          </div>
        </article>

        <!-- 4. REFUND & RETURN POLICY -->
        <article id="refunds" class="reveal terms-policy-section is-revealed" style="scroll-margin-top: 155px;">
          <div style="margin-bottom: 16px;">
            <span class="eyebrow">Consumer Protection · Returns Guarantee</span>
            <h2 class="section-title" style="font-size: 1.85rem;">4. Return &amp; Refund Policy</h2>
          </div>
          <div class="prose" style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft);">
            <p>In full compliance with Section 56 of the <strong>South African Consumer Protection Act (CPA No. 68 of 2008)</strong>, we stand behind the quality and integrity of all materials supplied:</p>

            <div class="glass-box" style="margin: 20px 0; padding: 24px; border-left: 4px solid var(--sage, #4A7C59);">
              <h4 style="color: var(--sage, #4A7C59); margin-top: 0; font-size: 1.05rem;">Damaged, Defective or Misprinted Physical Books</h4>
              <p style="margin: 0 0 12px 0; font-size: 0.93rem; line-height: 1.65;">
                If your physical book arrives damaged, with missing pages, or misprints:
              </p>
              <ol style="margin: 0; padding-left: 20px; font-size: 0.92rem; line-height: 1.7;">
                <li>Notify us within&nbsp;<strong>3 calendar days</strong> of delivery by emailing photos of the defect and your order reference to <a href="mailto:eliza.reconnection@gmail.com" style="color: var(--gold-dark, #AA7C11); font-weight: 600;">eliza.reconnection@gmail.com</a>.</li>
                <li>Return the damaged product and we will immediately dispatch a <strong>brand-new replacement copy free of charge</strong>, or issue a <strong>full refund</strong> of the purchase price.</li>
              </ol>
            </div>

            <div class="glass-box" style="margin: 20px 0; padding: 24px;">
              <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.05rem;">Personalized &amp; Author Inscribed Books</h4>
              <p style="margin: 0; font-size: 0.92rem; line-height: 1.65;">
                Where an author dedication or custom inscription was specifically requested by the customer, such items represent bespoke, personalized goods under Section 42(2)(f) of the ECTA. They cannot be returned for a change-of-mind, but remain fully guaranteed against any physical defect or courier damage.
              </p>
            </div>

            <div class="glass-box" style="margin: 20px 0; padding: 24px;">
              <h4 style="color: var(--gold-dark, #AA7C11); margin-top: 0; font-size: 1.05rem;">Digital Publications (PDF Downloads)</h4>
              <p style="margin: 0; font-size: 0.92rem; line-height: 1.65;">
                Due to the immediate access nature of electronic downloads, digital publications are non-refundable once downloaded. If you experience technical difficulty opening the PDF file, we will promptly re-issue a working copy to your email address or assist with alternate access.
              </p>
            </div>

            <p><strong>Refund Processing Method:</strong> Approved refunds are credited directly back to the original funding card, bank account, or digital wallet through the <strong>PayFast Merchant Gateway</strong>. Processing typically completes within 5 to 7 South African banking days.</p>
          </div>
        </article>

        <!-- 5. PAYMENT SECURITY & GATEWAY GOVERNANCE -->
        <article id="payment-security" class="reveal terms-policy-section is-revealed" style="scroll-margin-top: 155px;">
          <div style="margin-bottom: 16px;">
            <span class="eyebrow">Encrypted Checkout · South African Banking Standards</span>
            <h2 class="section-title" style="font-size: 1.85rem;">5. Payment Gateway &amp; Transaction Security</h2>
          </div>
          <div class="prose" style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft);">
            <p>Online transactions through this website are secured and managed in partnership with South Africa's foremost payment aggregator:</p>

            <div class="glass-box" style="margin: 20px 0; padding: 24px; background: rgba(255,255,255,0.92); border: 1.5px solid rgba(212,175,55,0.35);">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
                <h4 style="margin: 0; color: var(--ink); font-size: 1.15rem;">Processed by PayFast (Pty) Ltd</h4>
                <span style="background: #fff; padding: 4px 10px; border-radius: 4px; border: 1px solid #ddd; font-weight: 700; font-size: 0.9rem; color: #EE2E24;">
                  Pay<span style="color:#009FE3;">Fast</span>
                </span>
              </div>
              <ul style="margin: 0; padding-left: 20px; font-size: 0.92rem; line-height: 1.7;">
                <li><strong>PCI-DSS Level 1 Certification:</strong> PayFast complies with the highest global security standards for handling credit card data.</li>
                <li><strong>Encryption:</strong> Transactions are protected by 256-bit Extended Validation SSL encryption.</li>
                <li><strong>3D Secure &amp; Two-Factor Authentication:</strong> Card payments require mandatory OTP or banking app biometric verification (Mastercard ID Check, Verified by Visa).</li>
                <li><strong>Zero Cardholder Data Storage:</strong> Eliza Reconnection never captures, processes, or stores your credit card number, CVV code, or banking login credentials on our website. All sensitive payment data is inputted directly onto PayFast's secured banking environment.</li>
                <li><strong>Supported Payment Methods:</strong> Visa, Mastercard, Instant EFT (ABSA, Capitec, FNB, Nedbank, Standard Bank, Investec, TymeBank, African Bank, Bidvest), SnapScan, Zapper, and Capitec Pay.</li>
              </ul>
            </div>
          </div>
        </article>

        <!-- 6. PRIVACY & POPIA COMPLIANCE -->
        <article id="popia-privacy" class="reveal terms-policy-section is-revealed" style="scroll-margin-top: 155px;">
          <div style="margin-bottom: 16px;">
            <span class="eyebrow">Data Governance · POPIA Act</span>
            <h2 class="section-title" style="font-size: 1.85rem;">6. Customer Privacy &amp; Data Protection</h2>
          </div>
          <div class="prose" style="font-size: 0.98rem; line-height: 1.75; color: var(--ink-soft);">
            <p>In accordance with the <strong>Protection of Personal Information Act (POPIA Act No. 4 of 2013)</strong>, we hold customer confidentiality and data security sacred:</p>
            <ul style="margin: 0 0 16px; padding-left: 20px; font-size: 0.92rem; line-height: 1.7;">
              <li><strong>Information Collected:</strong> Name, delivery street address, contact telephone number, and email address provided during the checkout or inquiry process.</li>
              <li><strong>Purpose of Processing:</strong> Contact information is processed strictly to execute order fulfillment, generate courier waybills, communicate tracking updates, and fulfill tax/accounting obligations.</li>
              <li><strong>Third-Party Disclosure:</strong> Your information is never sold, rented, or distributed to advertisers or data brokers. It is shared solely with the designated courier service and PayFast for the direct fulfillment of your transaction.</li>
              <li><strong>Right of Access &amp; Correction:</strong> You have the right to request confirmation of the personal data held on record and to request correction or deletion at any time by contacting us.</li>
            </ul>
          </div>
        </article>

        <!-- 7. CONTACT FOR DISPUTES & INQUIRIES -->
        <article id="contact-support" class="reveal terms-policy-section is-revealed" style="scroll-margin-top: 155px;">
          <div class="glass-box" style="padding: 30px; text-align: center; border-radius: 14px; background: linear-gradient(135deg, rgba(212,175,55,0.08) 0%, rgba(255,255,255,0.95) 100%); border: 1.5px solid rgba(212,175,55,0.4);">
            <h3 style="margin-top: 0; font-family: var(--font-serif); font-size: 1.45rem; color: var(--ink);">Questions Regarding Our Terms or Orders?</h3>
            <p style="margin: 8px auto 20px; max-width: 600px; font-size: 0.94rem; color: var(--ink-soft); line-height: 1.6;">
              Please reach out directly. We are committed to prompt, personalized customer support for all readers and clients.
            </p>
            <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
              <a href="mailto:eliza.reconnection@gmail.com" class="btn btn-primary" style="padding: 12px 24px; font-size: 0.92rem;">
                <span>Email Customer Support</span>
                <span>→</span>
              </a>
              <a href="tel:+27829269851" class="btn btn-ghost" style="padding: 12px 24px; font-size: 0.92rem;">
                <span>Call / WhatsApp: 082 926 9851</span>
              </a>
            </div>
          </div>
        </article>

      </div>
    </div>
  </section>
<?php
}
?>
</main>
<?php
get_footer();
